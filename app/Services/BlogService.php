<?php

namespace App\Services;

use App\Models\Blog;

class BlogService
{
    public static function create(array $data): Blog
    {
        if (filled($data['image'])) {
            $data['image_path'] = AWSService::upload($data['image']);
        }


        return auth()->user()->blogs()->firstOrCreate($data);
    }
}
