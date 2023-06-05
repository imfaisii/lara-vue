<?php

namespace App\Services;

use App\Models\Blog;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class BlogService
{
    protected bool $isBucketAvailable = false;

    public function __construct()
    {
        $this->isBucketAvailable = (bool)(filled(config('app.isS3Available')));
    }

    public function index(): LengthAwarePaginator
    {
        $searchQuery = request()->query('search');
        $perPage = request()->get('rowsPerPage', 10);

        if ($searchQuery) {
            $blogs = Blog::where('title', 'like', "%$searchQuery%")
                ->orWhere('body', 'like', "%$searchQuery%")
                ->paginate($perPage);
        } else {
            $blogs = Blog::paginate($perPage);
        }

        return $blogs;
    }

    public function create(array $data): Blog
    {
        if (array_key_exists("image", $data) && filled($data['image'])) {
            $data['image_path'] = $this->upload($data['image']);
        }

        return auth()->user()->blogs()->firstOrCreate(Arr::except($data, 'image'));
    }

    public function update(Blog $blog, array $data): Blog
    {
        if (array_key_exists("image", $data) && filled($data['image'])) {
            $data['image_path'] = $this->upload($data['image']);
        }

        $blog->update($data);

        return $blog;
    }

    public function toggleLike(Blog $blog, int $userId): void
    {
        $blog->liked($userId) ? $blog->unlike($userId) : $blog->like($userId);
    }

    private function upload($image): string
    {
        return !$this->isBucketAvailable
            ? $image->store('blogs', 'public')
            : AWSService::upload($image);
    }
}
