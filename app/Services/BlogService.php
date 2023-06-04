<?php

namespace App\Services;

use App\Models\Blog;
use Illuminate\Support\Facades\Storage;

class BlogService
{
    protected bool $isBucketAvailable = false;

    public function __construct()
    {
        $this->isBucketAvailable = (bool)(filled(config('isS3Available')));
    }

    public function create(array $data): Blog
    {
        //! Not uploading as s3 credentials are not shared you can update aws creds and uncomment it
        if (filled($data['image'])) {
            $data['image_path'] =  $this->isBucketAvailable
                ? AWSService::upload($data['image'])
                : $data['image']->store('blogs', 'public');
        }


        return auth()->user()->blogs()->firstOrCreate($data);
    }
}
