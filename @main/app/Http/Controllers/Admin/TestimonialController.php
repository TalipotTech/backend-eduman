<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Enums\StatusEnum;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:testimonial-list', ['only' => ['index','show']]);
        $this->middleware('permission:testimonial-create', ['only' => ['create','store']]);
        $this->middleware('permission:testimonial-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:testimonial-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = Testimonial::all();
        return view("dashboard.testimonial.list", compact("testimonials"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.testimonial.new");
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
            "name" => "required|string",
            "designation" => "required|string",
            "image" => "nullable|file",
            "title" => "required|string",
            "body" => "required|string",
            "rating" => "required|numeric",
        ]);

        $testimonial_data = [
            "name" => $request->name,
            "designation" => $request->designation,
            "title" => $request->title,
            "body" => $request->body,
            "rating" => $request->rating,
        ];

        $testimonial_data = uploadMediaInArray("image", "image", $testimonial_data);
        $testimonial = Testimonial::create($testimonial_data);
        if ($testimonial) {
            return back()->with(ResponseMessage::createSucceed(__("Testimonial")));
        }
        return back()->with(ResponseMessage::createFailed(__("Testimonial")));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function edit(Testimonial $testimonial)
    {
        return view("dashboard.testimonial.edit", compact("testimonial"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            "name" => "required|string",
            "designation" => "required|string",
            "image" => "nullable|file",
            "title" => "required|string",
            "body" => "required|string",
            "rating" => "required|numeric",
        ]);

        $testimonial_data = [
            "name" => $request->name,
            "designation" => $request->designation,
            "title" => $request->title,
            "body" => $request->body,
            "rating" => $request->rating,
        ];

        $testimonial_data = uploadMediaInArray("image", "image", $testimonial_data);
        $updated = $testimonial->update($testimonial_data);
        if ($updated) {
            return back()->with(ResponseMessage::updateSucceed(__("Testimonial")));
        }
        return back()->with(ResponseMessage::updateFailed(__("Testimonial")));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Testimonial $testimonial)
    {
        $deleted = $testimonial->delete();
        if ($deleted) {
            return response()->json(ResponseMessage::deleteSucceed(__("Testimonial")));
        }
        return response()->json(ResponseMessage::deleteFailed(__("Testimonial")));
    }
}
