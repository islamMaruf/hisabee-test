<?php

namespace App\Traits;

use App\Jobs\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

trait UploadImage
{
    /**
     * @param Request $request
     * @param string $fieldName
     * @param string $directoryName
     * @param string[] $dimension
     * @param string $type
     * @return string
     */
    private function imageUpload(Request $request, string $fieldName, string $directoryName, array $dimension, string $type = 'insert'): string
    {
        if ($request->hasFile($fieldName)) {
            $currentDate = Carbon::now()->toDateString();
            $image = $request->file($fieldName);
            $imageName = Str::slug(trim($fieldName)) . '-' . $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $uploadPath = "$directoryName/$request->$fieldName";
            $savePath = "$directoryName/$imageName";
            ImageUpload::dispatch($uploadPath, $savePath, $directoryName, $dimension, $image, $type);
            return $imageName;
        }
        return '';
    }

    public function insertImage(Request $request, $fieldName = 'image', $directoryName = 'image', $dimension = ['300', '200']): string
    {
        return $this->imageUpload($request, $fieldName, $directoryName, $dimension);
    }

    public function updateImage(Request $request, $fieldName = 'image', $directoryName = 'image', $dimension = ['300', '200']): string
    {
        return $this->imageUpload($request, $fieldName, $directoryName, $dimension, 'upload');
    }
}
