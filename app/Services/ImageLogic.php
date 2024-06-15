<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageLogic
{

    /**
     * store image from form to storage directory
     *
     * @param UploadedFile $image
     * @param string $diskName
     * @return string
     */
    public static function upload(UploadedFile $image, string $diskName): string
    {
        $fileName = $image->hashName();

        Storage::disk($diskName)->put($fileName, file_get_contents($image));

        return $fileName;
    }



    /**
     * delete image in storage that link in public directory
     * that use model accesor and also trim that url
     *
     * @param string $hashName
     * @param int $offsetUrl
     * @param string $diskName
     * @return void
     */
    public static function delete(string $hashName, int $offsetUrl, string $diskName): void
    {
        /**
         * using parse_url to remove url like: http://127.0.0.1:8000 or PHP_URL_PATH
         *
         * example: using substr() with offset 9 to remove: /artikel/
         *
         * result from those logic: hashName.extension
         */
        $hashName = substr(parse_url($hashName, PHP_URL_PATH), $offsetUrl);
        /**
         * delete image that had hashName in public directory
         */
        if (Storage::disk($diskName)->exists($hashName)) {
            /**
             * delete image that had hashName in public directory
             */
            Storage::disk($diskName)->delete($hashName);
        }
    }
}
