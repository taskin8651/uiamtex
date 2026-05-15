<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBlogPostRequest;
use App\Http\Requests\StoreBlogPostRequest;
use App\Http\Requests\UpdateBlogPostRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BlogPostsController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('blog_post_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = BlogPost::with(['select_category'])->select(sprintf('%s.*', (new BlogPost)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'blog_post_show';
                $editGate      = 'blog_post_edit';
                $deleteGate    = 'blog_post_delete';
                $crudRoutePart = 'blog-posts';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('select_category_name', function ($row) {
                return $row->select_category ? $row->select_category->name : '';
            });

            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });
            $table->editColumn('slug', function ($row) {
                return $row->slug ? $row->slug : '';
            });
            $table->editColumn('excerpt', function ($row) {
                return $row->excerpt ? $row->excerpt : '';
            });
            $table->editColumn('featured_image', function ($row) {
                if ($photo = $row->featured_image) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('read_time', function ($row) {
                return $row->read_time ? $row->read_time : '';
            });
            $table->editColumn('published_at', function ($row) {
                return $row->published_at ? $row->published_at : '';
            });
            $table->editColumn('is_published', function ($row) {
                return $row->is_published ? BlogPost::IS_PUBLISHED_SELECT[$row->is_published] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'select_category', 'featured_image']);

            return $table->make(true);
        }

        return view('admin.blogPosts.index');
    }

    public function create()
    {
        abort_if(Gate::denies('blog_post_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $select_categories = BlogCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.blogPosts.create', compact('select_categories'));
    }

    public function store(StoreBlogPostRequest $request)
    {
        $blogPost = BlogPost::create($request->all());

        if ($request->input('featured_image', false)) {
            $blogPost->addMedia(storage_path('tmp/uploads/' . basename($request->input('featured_image'))))->toMediaCollection('featured_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $blogPost->id]);
        }

        return redirect()->route('admin.blog-posts.index');
    }

    public function edit(BlogPost $blogPost)
    {
        abort_if(Gate::denies('blog_post_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $select_categories = BlogCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $blogPost->load('select_category');

        return view('admin.blogPosts.edit', compact('blogPost', 'select_categories'));
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

        return redirect()->route('admin.blog-posts.index');
    }

    public function show(BlogPost $blogPost)
    {
        abort_if(Gate::denies('blog_post_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $blogPost->load('select_category');

        return view('admin.blogPosts.show', compact('blogPost'));
    }

    public function destroy(BlogPost $blogPost)
    {
        abort_if(Gate::denies('blog_post_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $blogPost->delete();

        return back();
    }

    public function massDestroy(MassDestroyBlogPostRequest $request)
    {
        $blogPosts = BlogPost::find(request('ids'));

        foreach ($blogPosts as $blogPost) {
            $blogPost->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('blog_post_create') && Gate::denies('blog_post_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new BlogPost();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
