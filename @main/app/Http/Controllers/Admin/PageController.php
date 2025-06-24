<?php

namespace App\Http\Controllers\Admin;
use App\Helpers\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:page-list', ['only' => ['index','show']]);
        $this->middleware('permission:page-create', ['only' => ['create','store']]);
        $this->middleware('permission:page-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:page-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::all();
        return view("dashboard.pages.list", compact("pages"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.pages.new");
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
            "content" => "required|string",
            "status" => "required|string",
            "visibility_scope" => "nullable|string",
            "meta_title" => "nullable|string",
            "meta_description" => "nullable|string",
            "meta_image" => "nullable|file",
        ]);

        $page_data = [
            "title" => $request->title,
            "slug" => str()->slug($request->title) ,
            "content" => $request->content,
            "status" => $request->status,
            "visibility_scope" => $request->visibility_scope,
            "meta_title" => $request->meta_title,
            "meta_description" => $request->meta_description,
        ];

        $page_data = uploadMediaInArray("meta_image", "meta_image", $page_data);

        $page = Page::create($page_data);
        if ($page) {
            return redirect()->route("dashboard.pages.list")->with(ResponseMessage::createSucceed(__("Page")));
        }
        return redirect()->route("dashboard.pages.list")->with(ResponseMessage::createFailed(__("Page")));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view("dashboard.pages.edit", compact("page"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $request->validate([
            "title" => "required|string",
            "content" => "required|string",
            "status" => "required|string",
            "meta_title" => "nullable|string",
            "meta_description" => "nullable|string",
            "meta_image" => "nullable|file",
        ]);

        $page_data = [
            "title" => $request->title,
            "slug" => str()->slug($request->title),
            "content" => $request->content,
            "status" => $request->status,
            "meta_title" => $request->meta_title,
            "meta_description" => $request->meta_description,
        ];

        $page_data = uploadMediaInArray("meta_image", "meta_image", $page_data);
        $updated = $page->update($page_data);
        if ($updated) {
            return redirect()->route("dashboard.pages.list")->with(ResponseMessage::updateSucceed(__("Page")));
        }
        return redirect()->route("dashboard.pages.list")->with(ResponseMessage::updateFailed(__("Page")));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $deleted = $page->delete();
        if ($deleted) {
            return response()->json(ResponseMessage::deleteSucceed(__("Page")));
        }
        return response()->json(ResponseMessage::deleteFailed(__("Page")));
    }
}
