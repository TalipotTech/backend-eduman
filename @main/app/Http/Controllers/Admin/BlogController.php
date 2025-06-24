<?php

namespace App\Http\Controllers\Admin;
use App\Helpers\ResponseMessage;
use App\Http\Controllers\Admin\UploadFileController;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Blog;
use App\Models\Category;
use App\Enums\CategoryTypeEnum;
use App\Enums\AuthorCategoryEnum;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:blog-list', ['only' => ['index','show']]);
        $this->middleware('permission:blog-create', ['only' => ['create','store']]);
        $this->middleware('permission:blog-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:blog-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::with(["category", "author"])->get();
        return view("dashboard.blog.all", compact("blogs"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $blog_categories = Category::where('type', CategoryTypeEnum::BLOG)->get();
        $authors = Author::where('category', AuthorCategoryEnum::BLOG)->get();
        return view("dashboard.blog.new", compact("blog_categories", "authors"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required|string",
            "teaser" => "nullable|string",
            "content" => "nullable|string",
            "image" => "nullable|file",
            "category_id" => "required|exists:categories,id",
            "status" => "nullable|string",
            "meta_title" => "nullable|string",
            "meta_description" => "nullable|string",
            "meta_image" => "nullable|file",
        ]);

        $title_slug = str()->slug($request->title);
        $slug = $this->getAvailableSlug($title_slug);

        $blog_data = [
            "title" => $request->title ?? "",
            "author_id" => $request->author_id ?? "",
            "slug" => $slug ?? "",
            "teaser" => $request->content ?? "",
            "content" => $request->content ?? "",
            "category_id" => $request->category_id ?? 0,
            "status" => $request->status ?? "Active",
            "meta_title" => $request->meta_title ?? "",
            "meta_description" => $request->meta_description ?? "",
        ];

        $blog_data = uploadMediaInArray("image", "image", $blog_data);
        $blog_data = uploadMediaInArray("meta_image", "meta_image", $blog_data);

        $uploaded_image = uploadMedia("image");
        if ($uploaded_image) {
            $blog_data["image"] = $uploaded_image;
        }

        $blog = Blog::create($blog_data);

        if ($blog) {
            return redirect()->route("dashboard.blogs.list")
                ->with(ResponseMessage::createSucceed(__("Blog")));
        }

        return redirect()->back()->with(ResponseMessage::createFailed(__("Blog")));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        $blog_categories = Category::where('type', CategoryTypeEnum::BLOG)->get();
        $authors = Author::where('category', AuthorCategoryEnum::BLOG)->get();
        return view("dashboard.blog.edit", compact("blog", "blog_categories", "authors"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            "title" => "required|string",
            "teaser" => "nullable|string",
            "content" => "nullable|string",
            "image" => "nullable|file",
            "category_id" => "required|exists:categories,id",
            "status" => "nullable|string",
            "meta_title" => "nullable|string",
            "meta_description" => "nullable|string",
            "meta_image" => "nullable|file",
        ]);

        $slug = $blog->slug;

        if ($blog->name != $request->name) {
            $title_slug = str()->slug($request->title);
            $slug = $this->getAvailableSlug($title_slug);
        }

        $blog_data = [
            "title" => $request->title ?? "",
            "author_id" => $request->author_id ?? "",
            "slug" => $slug ?? "",
            "teaser" => $request->teaser ?? "",
            "content" => $request->content ?? "",
            "category_id" => $request->category_id ?? 0,
            "status" => $request->status ?? "Active",
            "meta_title" => $request->meta_title ?? "",
            "meta_description" => $request->meta_description ?? "",
        ];

        //upload image
        $upload = new UploadFileController();

        if (!empty($request->file('image')) && $request->hasFile('image')) {
            $blog_data['image'] = $upload->uploadImage($request, 'image');
        }

        if (!empty($request->file('meta_image')) && $request->hasFile('meta_image')) {
            $blog_data['meta_image'] = $upload->uploadImage($request, 'meta_image');
        }

        $updated = $blog->update($blog_data);
        if ($updated) {
            return redirect()->route("dashboard.blogs.list")
                ->with(ResponseMessage::updateSucceed(__("Blog")));
        }
        return redirect()->back()->with(ResponseMessage::updateFailed(__("Blog")));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $deleted = $blog->delete();

        if ($deleted) {
            return response()->json(ResponseMessage::deleteSucceed(__("Blog")));
        }

        return response()->json(ResponseMessage::deleteFailed(__("Blog")));
    }

    public function getAvailableSlug($slug = "")
    {
        $available_count = Blog::where("slug", $slug)->count();
        /**
         * If a blog having this slug is not found, then this a valid slug
         */
        if (!$available_count) {
            return $slug;
        }
        /**
         * If a match found, then this is not a valid slug.
         */
        $new_slug = $slug . "-" . uniqid();
        
        return $this->getAvailableSlug($new_slug);
    }
}
