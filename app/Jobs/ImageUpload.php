<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $directoryName;
    private array $dimension;
    private string $type;
    private string $image;
    private string $existsPath;
    private string $savePath;

    /**
     * Create a new job instance.
     *
     * @param $existsPath
     * @param $savePath
     * @param $directoryName
     * @param $dimension
     * @param $image
     * @param string $type
     */
    public function __construct($existsPath, $savePath, $directoryName, $dimension, $image, string $type)
    {
        $this->directoryName = $directoryName;
        $this->dimension = $dimension;
        $this->type = $type;
        $this->image = $image;
        $this->existsPath = $existsPath;
        $this->savePath = $savePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        if (!Storage::disk('public')->exists($this->directoryName)) {
            Storage::disk('public')->makeDirectory($this->directoryName);
        }
        if ($this->type !== 'insert') {
            if (Storage::disk('public')->exists($this->existsPath)) {
                Storage::disk('public')->delete($this->existsPath);
            }
        }
        $convertImage = Image::make($this->image)->resize($this->dimension[0], $this->dimension[1])->stream('png', 100);
        Storage::disk('public')->put($this->savePath, $convertImage);
    }
}
