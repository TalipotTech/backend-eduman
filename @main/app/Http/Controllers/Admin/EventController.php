<?php

namespace App\Http\Controllers\Admin;
use App\Helpers\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Enums\CategoryTypeEnum;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:event-list', ['only' => ['index','show']]);
        $this->middleware('permission:event-create', ['only' => ['create','store']]);
        $this->middleware('permission:event-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:event-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::with("Category")->get();
        return view("dashboard.event.list", compact("events"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $event_types = Category::where('type', CategoryTypeEnum::EVENT)->get();
        return view("dashboard.event.new", compact("event_types"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "category_id" => "required|exists:categories,id",
            "title" => "required|string",
            "available_seat" => "required|numeric",
            "teaser" => "required|string",
            "description" => "required|string",
            "image_url" => "nullable|file",
            "video_url" => "nullable|file",
            "document_url" => "nullable|file",
            "start_datetime" => "required|date",
            "end_datetime" => "required|date",
            "location" => "nullable|string",
            "join_url" => "nullable|string",
            "visible_from" => "required|date",
            "visible_to" => "required|date",
            "registration_start_at" => "required|date",
            "registration_end_at" => "required|date",
            "status" => "required|string",
        ]);

        $selected_type = Category::find($request->category_id);
        $type = $selected_type ? $selected_type->title : "";

        $event_data = [
            "category_id" => $request->category_id,
            "title" => $request->title,
            "slug" => str()->slug($request->title),
            "type" => $type,
            "available_seat" => $request->available_seat,
            "teaser" => $request->teaser,
            "description" => $request->description,
            "start_datetime" => \Carbon\Carbon::parse($request->start_datetime)->format('Y-m-d H:i:s'),
            "end_datetime" => \Carbon\Carbon::parse($request->end_datetime)->format('Y-m-d H:i:s'),
            "location" => $request->location,
            "join_url" => $request->location,
            "visible_from" => \Carbon\Carbon::parse($request->visible_from)->format('Y-m-d H:i:s'),
            "visible_to" => \Carbon\Carbon::parse($request->visible_to)->format('Y-m-d H:i:s'),
            "registration_start_at" => \Carbon\Carbon::parse($request->registration_start_at)->format('Y-m-d H:i:s'),
            "registration_end_at" => \Carbon\Carbon::parse($request->registration_end_at)->format('Y-m-d H:i:s'),
            "status" => $request->status,
        ];

        $upload = new UploadFileController();
        if (!empty($request->file('image_url'))) {
            $event_data['image_url'] = $upload->uploadImage($request, 'image_url');
        }

        if (!empty($request->file('video_url'))) {
            $event_data['video_url'] = $upload->uploadVideo($request, 'video_url');
        }

        if (!empty($request->file('document_url'))) {
            $event_data['document_url'] = $upload->uploadFile($request, 'document_url');
        }

        $event = Event::create($event_data);
        if ($event) {
            return redirect()->route("dashboard.event.list")->with(ResponseMessage::createSucceed(__("Event")));
        }
        return redirect()->route("dashboard.event.list")->with(ResponseMessage::createFailed(__("Event")));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $event_types = Category::where('type', CategoryTypeEnum::EVENT)->get();
        return view("dashboard.event.edit", compact("event_types", "event"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $this->validate($request, [
            "category_id" => "required|exists:categories,id",
            "title" => "required|string",
            "available_seat" => "required|numeric",
            "teaser" => "required|string",
            "description" => "required|string",
            "image_url" => "nullable|file",
            "video_url" => "nullable|file",
            "document_url" => "nullable|file",
            "start_datetime" => "required|date",
            "end_datetime" => "required|date",
            "location" => "nullable|string",
            "join_url" => "nullable|string",
            "visible_from" => "required|date",
            "visible_to" => "required|date",
            "registration_start_at" => "required|date",
            "registration_end_at" => "required|date",
            "status" => "required|string",
        ]);

        $event_data = [
            "category_id" => $request->category_id,
            "title" => $request->title,
            "slug" => str()->slug($request->title),
            "type" => $request->type,
            "available_seat" => $request->available_seat,
            "teaser" => $request->teaser,
            "description" => $request->description,
            "start_datetime" => $request->start_datetime,
            "end_datetime" => $request->end_datetime,
            "location" => $request->location,
            "join_url" => $request->join_url,
            "visible_from" => $request->visible_from,
            "visible_to" => $request->visible_to,
            "registration_start_at" => $request->registration_start_at,
            "registration_end_at" => $request->registration_end_at,
            "status" => $request->status,
        ];

        $upload = new UploadFileController();
        if (!empty($request->file('image_url'))) {
            $event_data['image_url'] = $upload->uploadImage($request, 'image_url');
        }

        if (!empty($request->file('video_url'))) {
            $event_data['video_url'] = $upload->uploadVideo($request, 'video_url');
        }

        if (!empty($request->file('document_url'))) {
            $event_data['document_url'] = $upload->uploadFile($request, 'document_url');
        }

        $updated = $event->update($event_data);
        if ($updated) {
            return redirect()->route("dashboard.event.list")->with(ResponseMessage::updateSucceed(__("Event")));
        }
        return redirect()->route("dashboard.event.list")->with(ResponseMessage::updateFailed(__("Event")));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $deleted = $event->delete();
        if ($deleted) {
            return response()->json(ResponseMessage::deleteSucceed(__("Event")));
        }
        return response()->json(ResponseMessage::deleteFailed(__("Event")));
    }
}
