<?php

namespace App\Console\Commands;

use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class PruneUnusedVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:prune-unused-videos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $videos = Video::all();
        $persistThreshold = now()->subHours(12);

        foreach (File::allFiles(storage_path('app/public')) as $file) {
            $carbonLastAccessed = Carbon::createFromTimestamp($file->getATime());
            $fileFullPath = $file->getPath() . '/' . $file->getFilename();
            if ($carbonLastAccessed->diffInHours($persistThreshold) > 0 && File::exists($fileFullPath)) {
                File::delete($fileFullPath);
                $this->info('Deleted file '. $file->getFilename());
            }
            // echo File::exists($file->getPath() . '/' . $file->getFilename());
            // echo $carbonLastAccessed . '; ' . $carbonLastAccessed->diffInHours($persistThreshold) .';' . $file->getPath() . '/' . $file->getFilename() . PHP_EOL;
        }

    
    }
}
