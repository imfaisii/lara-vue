<?php

namespace App\Services;

class AWSService
{
    public static function upload($file): string
    {
        return $file->store('blogs', 's3');
    }
}
