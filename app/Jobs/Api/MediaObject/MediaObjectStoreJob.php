<?php

namespace App\Jobs\Api\MediaObject;

use App\Jobs\Basic\StoreJob;
use App\Models\MediaObject\MediaObject;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mockery\Exception;
use Tymon\JWTAuth\JWTAuth;

class MediaObjectStoreJob extends StoreJob
{

    /**
     * Execute the job.
     */
    public function handle()
    {
        $attributes = $this->request_data['data']['attributes'];
        $media = $attributes['media_object'];

        $file_name = $attributes['file_name'] ?? $media->getClientOriginalName();
        $file_name = $this->prepareFileName($file_name);

        $contentSize = $media->getSize();
        $encondingFormat = $media->getMimeType();

        $path = 'uploads/';
        $contentUrl = $path . $file_name;

        Storage::disk('public')->put($contentUrl, $media);

        $attributes['contentUrl'] = $contentUrl;
        $attributes['contentSize'] = $contentSize;
        $attributes['encondingFormat'] = $encondingFormat;
        unset($attributes['media_object']);

        $attributes['uploader_id'] = $this->getCurrentUserId();

        $this->request_data['data']['attributes'] = $attributes;

        return $this->process();

    }

    private function prepareFileName($file_name)
    {
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_name = Str::slug(str_replace($extension, '', $file_name)) . ".$extension";
        return $file_name;
    }

    public function getCurrentUserId()
    {
        $user_id = null;

        try {
            $user = JWTAuth::parseToken()->authenticate();
            dd($user);
            $user_id = $user->id;
        } catch( Exception $e ) {
            dd($e);
        }

        return $user_id;
    }

    /**
     * Initialize the IndexJob with the wished and needed attributes
     */
    protected function init()
    {
        $this->setApiModel( new MediaObject() );
    }
}
