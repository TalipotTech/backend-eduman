<?php

namespace App\Http\Controllers\Admin;
use App\Helpers\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Enums\AuthorCategoryEnum;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:author-list', ['only' => ['index','show']]);
        $this->middleware('permission:author-create', ['only' => ['create','store']]);
        $this->middleware('permission:author-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:author-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::all();
        return view("dashboard.author.list", compact("authors"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authorCategories = AuthorCategoryEnum::cases();
        $categories = array();
        foreach($authorCategories as $key => $cat)
        {
            $categories[] = array(
                'id' => $cat->value,
                'title' => $cat->value,
            );
        }
        return view("dashboard.author.new", compact("categories"));
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
            'salute_name' => 'nullable|string',
            'titel_name' => 'nullable|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'designation' => 'required|string',
            'institute' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
            'street_address' => 'required|string',
            'city' => 'required|string',
            'zip' => 'required|string',
            'country' => 'required|string',
            'teaser' => 'required|string',
            'description' => 'required|string',
            'promo_video_url' => 'nullable|file',
            'logo_url' => 'nullable|file',
            'banner_url' => 'nullable|file',
            'website_url' => 'nullable|string',
            'fb_url' => 'nullable|string',
            'instagram_url' => 'nullable|string',
            'twitter_url' => 'nullable|string',
            'linkedin_url' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $lastName = !empty($request->last_name) ? ' '. $request->last_name : '';
        $slug = str()->slug($request->first_name . $lastName);

        $author_data = [
            "salute_name" => $request->salute_name ?? "",
            "titel_name" => $request->titel_name ?? "",
            "first_name" => $request->first_name ?? "",
            "last_name" => $request->last_name ?? "",
            "slug" => $slug,
            "designation" => $request->designation ?? "",
            "institute" => $request->institute ?? "",
            "email" => $request->email ?? "",
            "phone" => $request->phone ?? "",
            "street_address" => $request->street_address ?? "",
            "city" => $request->city ?? "",
            "zip" => $request->zip ?? "",
            "country" => $request->country ?? "",
            "teaser" => $request->teaser ?? "",
            "description" => $request->description ?? "",
            "promo_video_url" => $request->promo_video_url ?? "",
            "logo_url" => $request->logo_url ?? "",
            "banner_url" => $request->banner_url ?? "",
            "category" => $request->category ?? "",
            "website_url" => $request->website_url ?? "",
            "fb_url" => $request->fb_url ?? "",
            "instagram_url" => $request->instagram_url ?? "",
            "twitter_url" => $request->twitter_url ?? "",
            "linkedin_url" => $request->linkedin_url ?? "",
            "status" => $request->status ?? "",
        ];

        $author_data = uploadMediaInArray("promo_video_url", "promo_video_url", $author_data);
        $author_data = uploadMediaInArray("logo_url", "logo_url", $author_data);
        $author_data = uploadMediaInArray("banner_url", "banner_url", $author_data);

        $author = Author::create($author_data);

        if ($author) {
            return redirect()->route("dashboard.authors.list")->with(ResponseMessage::createSucceed(__("Author")));
        }
        return back()->withErrors(ResponseMessage::createFailed(__("Author")));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        $authorCategories = AuthorCategoryEnum::cases();
        $categories = array();
        foreach($authorCategories as $key => $cat)
        {
            $categories[] = array(
                'id' => $cat->value,
                'title' => $cat->value,
            );
        }
        return view("dashboard.author.edit", compact("author", "categories"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'salute_name' => 'nullable|string',
            'titel_name' => 'nullable|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'designation' => 'required|string',
            'institute' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
            'street_address' => 'required|string',
            'city' => 'required|string',
            'zip' => 'required|string',
            'country' => 'required|string',
            'teaser' => 'required|string',
            'description' => 'required|string',
            'promo_video_url' => 'nullable|file',
            'logo_url' => 'nullable|file',
            'banner_url' => 'nullable|file',
            'website_url' => 'nullable|string',
            'fb_url' => 'nullable|string',
            'instagram_url' => 'nullable|string',
            'twitter_url' => 'nullable|string',
            'linkedin_url' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $lastName = !empty($request->last_name) ? ' '. $request->last_name : '';
        $slug = str()->slug($request->first_name . $lastName);

        $author_data = [
            "salute_name" => $request->salute_name ?? "",
            "titel_name" => $request->titel_name ?? "",
            "first_name" => $request->first_name ?? "",
            "last_name" => $request->last_name ?? "",
            "slug" => $slug,
            "designation" => $request->designation ?? "",
            "institute" => $request->institute ?? "",
            "email" => $request->email ?? "",
            "phone" => $request->phone ?? "",
            "street_address" => $request->street_address ?? "",
            "city" => $request->city ?? "",
            "zip" => $request->zip ?? "",
            "country" => $request->country ?? "",
            "teaser" => $request->teaser ?? "",
            "description" => $request->description ?? "",
            "website_url" => $request->website_url ?? "",
            "fb_url" => $request->fb_url ?? "",
            "instagram_url" => $request->instagram_url ?? "",
            "twitter_url" => $request->twitter_url ?? "",
            "linkedin_url" => $request->linkedin_url ?? "",
            "category" => $request->category ?? "",
            "status" => $request->status ?? "",
        ];

        $author_data = uploadMediaInArray("promo_video_url", "promo_video_url", $author_data);
        $author_data = uploadMediaInArray("logo_url", "logo_url", $author_data);
        $author_data = uploadMediaInArray("banner_url", "banner_url", $author_data);

        $updated = $author->update($author_data);

        if ($updated) {
            return redirect()->route("dashboard.authors.list")->with(ResponseMessage::updateSucceed(__("Author")));
        }
        return back()->with(ResponseMessage::updateFailed(__("Author")));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        $deleted = $author->delete();

        if ($deleted) {
            return response()->json(ResponseMessage::deleteSucceed(__("Author")));
        }
        return response()->json(ResponseMessage::deleteFailed(__("Author")));
    }
}
