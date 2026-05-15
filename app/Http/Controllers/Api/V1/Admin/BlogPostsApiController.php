<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreBlogPostRequest;
use App\Http\Requests\UpdateBlogPostRequest;
use App\Http\Resources\Admin\BlogPostResource;
use App\Models\BlogPost;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogPostsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('blog_post_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BlogPostResource(BlogPost::with(['select_category'])->get());
    }

    public function store(StoreBlogPostRequest $request)
    {
        $blogPost = BlogPost::create($request->all());

        if ($request->input('featured_image', false)) {
            $blogPost->addMedia(storage_path('tmp/uploads/' . basename($request->input('featured_image'))))->toMediaCollection('featured_image');
        }

        return (new BlogPostResource($blogPost))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(BlogPost $blogPost)
    {
        abort_if(Gate::denies('blog_post_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BlogPostResource($blogPost->load(['select_category']));
    }

    public function update(UpdateBlogPostRequest $request, BlogPost $blogPost)
    {
        $blogPost->update($request->all());

        if ($request->input('featured_image', false)) {
            if (! $blogPost->featured_image || $request->input('featured_image') !== $blogPost->featured_image->file_name) {
                if ($blogPost->featured_image) {
                    $blogPost->featured_image->delete();
                }
                $blogPost->addMedia(storage_path('tmp/uploads/' . basename($request->input('featured_image'))))->toMediaCollection('featured_image');
            }
        } elseif ($blogPost->featured_image) {
            $blogPost->featured_image->delete();
        }

        return (new BlogPostResource($blogPost))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(BlogPost $blogPost)
    {
        abort_if(Gate::denies('blog_post_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $blogPost->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
