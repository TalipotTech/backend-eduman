<?php

namespace App\Http\Controllers\Admin;
use App\Helpers\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:topic-list', ['only' => ['index','show']]);
        $this->middleware('permission:topic-create', ['only' => ['create','store']]);
        $this->middleware('permission:topic-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:topic-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = Topic::all();
        return view("dashboard.topics.all", ["topics" => $topics]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.topics.new");
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
            "teaser" => "required|string",
            "description" => "required|string",
            "settings_data" => "required|string",
            "image_url" => "nullable|file",
            "video_url" => "nullable|file",
            "document_url" => "nullable|file",
            "status" => "required|string",
        ]);

        try {
            $upload = new UploadFileController();

            $image_url = '';
            $video_url = '';
            $document_url = '';

            if (!empty($request->file('image_url'))) {
                $image_url = $upload->uploadImage($request, 'image_url');
            }

            if (!empty($request->file('video_url'))) {
                $video_url = $upload->uploadFile($request, 'video_url');
            }

            if (!empty($request->file('document_url'))) {
                $document_url = $upload->uploadVideo($request, 'document_url');
            }

            $topic = Topic::create([
                "title" => $request->title,
                "teaser" => $request->teaser,
                "description" => $request->description,
                "settings_data" => $request->settings_data,
                "image_url" => $image_url,
                "video_url" => $video_url,
                "document_url" => $document_url,
                "status" => $request->status,
            ]);

            return redirect()->route("dashboard.topics.list")->with(ResponseMessage::createSucceed(__("Topic")));

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(ResponseMessage::createFailed(__("Topic")));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $topic
     * @return \Illuminate\Http\Response
     */
    public function edit(Topic $topic)
    {
        return view("dashboard.topics.edit", [
            "topic" => $topic
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Topic $topic)
    {
        $request->validate([
            "title" => "required|string",
            "teaser" => "required|string",
            "description" => "required|string",
            "settings_data" => "required|string",
            "image_url" => "nullable|file",
            "video_url" => "nullable|file",
            "document_url" => "nullable|file",
            "status" => "required|string",
        ]);

        try {
            $upload = new UploadFileController();
            $update_data = [
                "title" => $request->title,
                "teaser" => $request->teaser,
                "description" => $request->description,
                "settings_data" => $request->settings_data,
                "status" => $request->status,
            ];

            if (!empty($request->file('image_url'))) {
                $image_url = $upload->uploadImage($request, 'image_url');
                $update_data["image_url"] = $image_url;
            }

            if (!empty($request->file('video_url'))) {
                $video_url = $upload->uploadFile($request, 'video_url');
                $update_data["video_url"] = $video_url;
            }

            if (!empty($request->file('document_url'))) {
                $document_url = $upload->uploadVideo($request, 'document_url');
                $update_data["document_url"] = $document_url;
            }

            $topic->update($update_data);
            return redirect()->route("dashboard.topics.list")->with(ResponseMessage::updateSucceed(__("Topic")));

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(ResponseMessage::updateFailed(__("Topic")));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic)
    {
        $deleted = $topic->delete();
        if ($deleted) {
            return response()->json(ResponseMessage::deleteSucceed(__("Topic")));
        }

        return response()->json(ResponseMessage::deleteFailed(__("Topic")));
    }
}
