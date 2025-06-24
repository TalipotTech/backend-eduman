<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:asset-list', ['only' => ['index','show']]);
        $this->middleware('permission:asset-create', ['only' => ['create','store']]);
        $this->middleware('permission:asset-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:asset-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assets = Asset::all();
        $categories = array();
        if( !empty($assets) )
        {
            foreach($assets as $asset)
            {
                if( !in_array( $asset->category, $categories ) )
                {
                    array_push($categories, $asset->category);
                }
            }
        }
        
        return view('dashboard.assets.list', [
            "assets" => $assets,
            "categories" => $categories,
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
        $request->validate([
            "title" => "required|string",
            "category" => "required|string",
        ]);

        $image_url = '';
        $upload = new UploadFileController();

        if (!empty($request->file('image_url'))) {
            $image_url = $upload->uploadImage($request, 'image_url');
        }

        $asset = Asset::create([
            "title" => $request->title,
            "path" => $image_url,
            "category" => $request->category,
            "status" => 'Active',
        ]);

        if ($asset) {
            return back()->with(ResponseMessage::createSucceed(__("Asset")));
        }
        return back()->with(ResponseMessage::createFailed(__("Asset")));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asset $asset)
    {
        $deleted = $asset->delete();
        if ($deleted) {
            return response()->json(ResponseMessage::deleteSucceed(__("Asset")));
        }
        return response()->json(ResponseMessage::deleteFailed(__("Asset")));
    }
}
