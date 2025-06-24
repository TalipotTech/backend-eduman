<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\SliderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:slider-list', ['only' => ['index','show']]);
        $this->middleware('permission:slider-create', ['only' => ['create','store']]);
        $this->middleware('permission:slider-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:slider-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::all();
        return view('dashboard.slider.list', [
            "sliders" => $sliders,
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
            "name" => "required|string",
            "display_name" => "required|string",
        ]);

        $slider = Slider::create([
            "name" => $request->name,
            "display_name" => $request->display_name,
        ]);

        if ($slider) {
            return back()->with(ResponseMessage::createSucceed(__("Slider")));
        }
        return back()->with(ResponseMessage::createFailed(__("Slider")));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            "name" => "required|string",
            "display_name" => "required|string",
        ]);

        $updated = $slider->update([
            "name" => $request->name,
            "display_name" => $request->display_name,
        ]);

        if ($updated) {
            return back()->with(ResponseMessage::updateSucceed(__("Slider")));
        }
        return back()->with(ResponseMessage::updateFailed(__("Slider")));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        try {
            DB::beginTransaction();
            $slider_items = SliderItems::where("slider_id", $slider->id)
                ->get()
                ->each(function ($slider_item) {
                    $slider_item->delete();
                });
            $deleted = $slider->delete();
            DB::commit();
            return response()->json(ResponseMessage::deleteSucceed(__("Slider")));
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(ResponseMessage::deleteFailed(__("Slider")));
        }
    }
}
