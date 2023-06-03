<?php

namespace App\Services;

class AWSService
{
    public static function upload($file)
    {
        return $file->store('blogs', 's3');
    }
}
