<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Enums\FaqCategoryEnum;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:faq-list', ['only' => ['index','show']]);
        $this->middleware('permission:faq-create', ['only' => ['create','store']]);
        $this->middleware('permission:faq-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:faq-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqs = Faq::all();
        $faqCategories = FaqCategoryEnum::cases();
        return view('dashboard.faqs.list', [
            "faqs" => $faqs,
            "categories" => $faqCategories,
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
            "description" => "required|string",
            "status" => "required|string",
            "is_open" => "required|boolean",
        ]);

        $faq = Faq::create([
            "title" => $request->title,
            "slug" => str()->slug($request->title),
            "description" => $request->description,
            "category" => $request->category,
            "status" => $request->status,
            "is_open" => (bool) $request->is_open,
        ]);

        if ($faq) {
            return back()->with(ResponseMessage::createSucceed(__("Faq")));
        }
        return back()->with(ResponseMessage::createFailed(__("Faq")));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            "title" => "required|string",
            "description" => "required|string",
            "status" => "required|string",
            "is_open" => "required|boolean",
        ]);

        $updated = $faq->update([
            "title" => $request->title,
            "slug" => str()->slug($request->title),
            "description" => $request->description,
            "status" => $request->status,
            "is_open" => (bool) $request->is_open,
        ]);

        if ($updated) {
            return back()->with(ResponseMessage::updateSucceed(__("Faq")));
        }
        return back()->with(ResponseMessage::updateFailed(__("Faq")));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        $deleted = $faq->delete();
        if ($deleted) {
            return response()->json(ResponseMessage::deleteSucceed(__("Faq")));
        }
        return response()->json(ResponseMessage::deleteFailed(__("Faq")));
    }
}
