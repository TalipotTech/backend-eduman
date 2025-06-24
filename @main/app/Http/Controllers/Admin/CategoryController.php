<?php

namespace App\Http\Controllers\Admin;
use App\Helpers\ResponseMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Enums\StatusEnum;
use App\Enums\CategoryTypeEnum;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:category-list', ['only' => ['index','show']]);
        $this->middleware('permission:category-create', ['only' => ['create','store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cats = Category::with('parentCategory')
            ->get();

        $catParents = Category::select(
            'id',
            'parent_id',
            'title',
            'type',
            'description',
        )
            ->where('parent_id', 0)
            ->where('status', "Active")
            ->get();
        return view('dashboard.category.list', [
            'categories' => $cats, 
            'catParents' => $catParents,
            "types" => CategoryTypeEnum::cases()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cats = Category::with('parentCategory')
            ->get();

        $catParents = Category::select(
            'id',
            'parent_id',
            'title',
            'type',
            'description',
        )
            ->where('parent_id', 0)
            ->where('status', "Active")
            ->get();
        return view('dashboard.category.new', [
            'categories' => $cats, 
            'catParents' => $catParents,
            "types" => CategoryTypeEnum::cases()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'ctype' => 'required',
        ]);

        $slug = str()->slug($request->title);

        $insertData = [
            'title' => $request->title,
            'description' => !empty($request->description) ? $request->description : "",
            'parent_id' => !empty($request->parent_id) ? $request->parent_id : 0,
            "slug" => $slug,
            "type" => $request->ctype,
            'status' => "Active",
        ];

        $category = Category::create($insertData);
        if ($category) {
            return redirect()->route("dashboard.category.list")->with(ResponseMessage::createSucceed(__("Category")));
        }
        return redirect()->route("dashboard.category.list")->with(ResponseMessage::createFailed(__("Category"))); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $cats = Category::with('parentCategory')
            ->get();

        $catParents = Category::select(
            'id',
            'parent_id',
            'title',
            'type',
            'description',
        )
            ->where('parent_id', 0)
            ->where('status', "Active")
            ->get();
        return view('dashboard.category.edit', [
            'category' => $category,
            'categories' => $cats, 
            'catParents' => $catParents,
            "types" => CategoryTypeEnum::cases()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'ctype' => 'required',
        ]);

        $slug = str()->slug($request->title);

        $updateData = [
            'title' => $request->title,
            'description' => !empty($request->description) ? $request->description : "",
            'parent_id' => !empty($request->parent_id) ? $request->parent_id : 0,
            "slug" => $slug,
            "type" => $request->ctype,
            'status' => "Active",
        ];

        $updated = $category->update($updateData);
        if ($updated) {
            return redirect()->route("dashboard.category.list")->with(ResponseMessage::updateSucceed(__("Category")));
        }
        return redirect()->route("dashboard.category.list")->with(ResponseMessage::updateFailed(__("Category")));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $deleted = $category->delete();
        if ($deleted) {
            return response()->json(ResponseMessage::deleteSucceed(__("Category")));
        }
        return response()->json(ResponseMessage::deleteFailed(__("Category")));
    }
}