<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->query();

        if (isset($query['title'])) { // Wyszukiwanie po tytule, prawdopodobnie w przyszłości zmienię strukturę działania tego modułu
            $title = $query['title'];
            $videos = Video::query()->where('title', 'like',  '%' . $title . '%')->get();
        } else {
            $videos = Video::all();
        }
        return Inertia::render('Video/List', ['videos' => $videos])->with('query', $query);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return Inertia::render('Video/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVideoRequest $request)
    {
        //
        ['title' => $title, 'description' => $description, 'file' => $file] = $request->validated();
        $file = json_decode($file);
    
        $slug = Str::slug($title);


        $video = new Video();
        $video->url = asset('storage/' . $file->path . $file->name);
        $video->title = $title;
        $video->slug = $slug;
        $video->description = $description;
        $video->author()->associate($request->user());
        $video->save();


        return to_route('video.show', ['video' => $video->id]);
    }

    public function upload(FileReceiver $receiver)
    {
        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }
        // receive the file
        $save = $receiver->receive();

        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
            // save the file and return any response you need
            return $this->saveFile($save->getFile());
        }

        // we are in chunk mode, lets send the current progress
        /** @var AbstractHandler $handler */
        $handler = $save->handler();
        return response()->json([
            "done" => $handler->getPercentageDone()
        ]);

        // zwróć url
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Video $video)
    {
        $video->url = asset($video->url);
        $video->load(['author'])->loadAvg('rates', 'rate');
        $video->rates_avg_rate = $video->rates_avg_rate ?? 0;
        $already_rated = $video->rates()->where('user_id', $request->user()->id);
        return Inertia::render('Video/Show', ['video' => $video, 'already_rated' => $already_rated]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video)
    {
        //
        return Inertia::render('Video/Edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVideoRequest $request, Video $video)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        //
        $video->delete();
    }


    /**
     * Saves the file
     *
     * @param UploadedFile $file
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function saveFile(UploadedFile $file)
    {
        $fileName = $this->createFilename($file);
        // Group files by mime type
        $mime = str_replace('/', '-', $file->getMimeType());
        // Group files by the date (week
        $dateFolder = date("Y-m-W");

        // Build the file path
        $filePath = "upload/{$mime}/{$dateFolder}/";
        $finalPath = storage_path("app/public/" . $filePath);

        // move the file name
        $file->move($finalPath, $fileName);

        return response()->json([
            'path' => $filePath,
            'name' => $fileName,
            'mime_type' => $mime
        ]);
    }

    /**
     * Create unique filename for uploaded file
     * @param UploadedFile $file
     * @return string
     */
    protected function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace("." . $extension, "", $file->getClientOriginalName()); // Filename without extension

        // Add timestamp hash to name of the file
        $filename .= "_" . md5(time()) . "." . $extension;

        return $filename;
    }
}
