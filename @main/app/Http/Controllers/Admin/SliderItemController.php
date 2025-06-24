<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\SliderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SliderItemController extends Controller
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
    public function index(Slider $slider)
    {
        // if the requested slider does no belong to the user
        if (auth()->id()) {
            abort(404);
        }

        $slider_items = SliderItems::where("slider_id", $slider->id)->get();

        return view("dashboard.slider_items.list", [
            "slider" => $slider,
            "slider_items" => $slider_items
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
            "slider_id" => "required|exists:sliders,id",
            "title.*" => "required|string",
            "image.*" => "nullable|file",
            "description.*" => "required|string",
            "btn_text.*" => "required|string",
            "btn_url.*" => "required|string",
        ]);

        $upload = new UploadFileController();

        $previous_slider_items = SliderItems::where("slider_id", $request->slider_id)->get();
        $all_previous_uploaded_images = [];

        // (i) upload new images, (ii) store urls in an array
        $new_uploaded_images = [];

        if (!empty($request->file('image'))) {
            $new_uploaded_images = $upload->uploadMultiple("image", $request, "image");
        }

        try {
            DB::beginTransaction();

            // keep previous image URLs & delete previous slider items
            foreach ($previous_slider_items as $slider_item) {
                $all_previous_uploaded_images[] = $slider_item->image ?? "";
                $slider_item->delete();
            }

            // insert new slider items
            foreach ($request->title as $key => $title) {
                $image_path = !empty($new_uploaded_images[$key]) ? $new_uploaded_images[$key] : "";

                $slider_item = [
                    "slider_id" => $request->slider_id,
                    "title" => $title,
                    "image" => $image_path,
                    "description" => $request->description[$key],
                    "btn_text" => $request->btn_text[$key],
                    "btn_url" => $request->btn_url[$key],
                ];

                SliderItems::create($slider_item);
            }

            DB::commit();

            // if all old records deleted and new ones added successfully
            // delete the old images
            $upload->delete($all_previous_uploaded_images);

            return redirect()
                    ->route("dashboard.slider.list")
                    ->with(ResponseMessage::customSuccess(__("Slider items updated")));
        } catch (\Throwable $th) {
            DB::rollBack();

            // since error occurred, delete newly saved image
            $upload->delete($new_uploaded_images);

            // if APP_DEBUG enabled, return error message.
            $message = env("APP_DEBUG") ? $th->getMessage() : __("Slider items update failed");
            return redirect()
                    ->route("dashboard.slider.list")
                    ->with(ResponseMessage::customFail($message));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SliderItems  $sliderItems
     * @return \Illuminate\Http\Response
     */
    public function destroy(SliderItems $sliderItem)
    {
        $deleted = $sliderItem->delete();
        if ($deleted) {
            return response()->json(ResponseMessage::deleteSucceed(__("Slider Item")));
        }
        return response()->json(ResponseMessage::deleteFailed(__("Slider Item")));
    }
}
