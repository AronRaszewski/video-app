<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::all();
        return Inertia::render('Video/List', ['videos' => $videos]);
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
        ['title' => $title, 'description' => $description] = $request->validated();
        $slug = Str::slug($title);
        
        $file = $request->file('file');

        $path = $file->store('videos', 'public');

        $video = new Video();
        $video->url = $path;
        $video->title = $title;
        $video->slug = $slug;
        $video->description = $description;
        $video->author()->associate($request->user());
        $video->save();
        
        return to_route('video.show', ['video' => $video->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        $video->url = asset($video->url);
        $video->load(['author']);
        return Inertia::render('Video/Show', ['video' => $video]);
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
}
