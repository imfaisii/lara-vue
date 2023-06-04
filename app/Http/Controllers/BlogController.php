<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Services\BlogService;
use App\Traits\ApiResponseTrait;
use Exception;

class BlogController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected BlogService $blogService)
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->successResponse($this->blogService->index());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        try {
            $blog = $this->blogService->create($request->validated());

            return $this->successResponse(new BlogResource($blog));
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return new BlogResource($blog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        try {
            $blog = $this->blogService->update($blog, $request->validated());

            return new BlogResource($blog);
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return response()->noContent();
    }

    /**
     * Like blog.
     */
    public function like(Blog $blog)
    {
        $blog->like(auth()->id());

        return response()->noContent();
    }
}
