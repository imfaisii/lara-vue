<?php

namespace App\Models;

use Conner\Likeable\Likeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Blog extends Model
{
    use HasFactory;
    use Likeable;

    protected $fillable = [
        'title',
        'body',
        'image_path',
        'user_id'
    ];

    protected $with = ['likeCounter'];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            if (config('app.isS3Available')) {
                return Storage::disk('s3')->url($this->image_path);
            }

            return Storage::disk('public')->url($this->image_path);
        }

        return null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
