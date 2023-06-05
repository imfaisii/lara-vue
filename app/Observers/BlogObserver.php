<?php

namespace App\Observers;

use App\Models\Blog;
use Illuminate\Support\Facades\Storage;

class BlogObserver
{
    public function deleting(Blog $blog): void
    {
        Storage::disk('public')->delete($blog->image_path);
    }
}
