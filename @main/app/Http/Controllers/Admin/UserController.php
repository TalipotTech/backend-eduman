<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\StatusEnum;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:user-list', ['only' => ['index','show']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view("dashboard.users.list", compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.users.new");
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
            'status' => 'required|string',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'role' => 'Student',
            'password' => Hash::make($request->password),
            'status' => StatusEnum::ACTIVE,
        ]);

        $lastName = !empty($request->last_name) ? ' '. $request->last_name .'-'. $user->id: '';
        $slug = str()->slug($request->first_name . $lastName);

        $studentData = [
            "user_id" => $user->id,
            "titel_name" => "",
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "slug" => $slug,
            "street_address" => "",
            "city" => "",
            "zip" => "",
            "country" => "",
            "teaser" => "",
            "description" => "",
            "fb_url" => "",
            "website_url" => "",
            "instagram_url" => "",
            "status" => StatusEnum::ACTIVE,
        ];

        $student = Student::create($studentData);
        if ($user) {
            return redirect()->route("dashboard.users.list")->with(ResponseMessage::createSucceed(__("User")));
        }
        return back()->withErrors(ResponseMessage::createFailed(__("User")));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(user $user)
    {
        return view("dashboard.users.edit", compact("user"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user $user)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $userData = [
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            "phone" => $request->phone,
            "password" => $request->password,
            "email_verified_at" => now(),
            "status" => null,
        ];

        $updated = $user->update($userData);
        if ($updated) {
            return redirect()->route("dashboard.users.list")->with(ResponseMessage::updateSucceed(__("User")));
        }
        return back()->with(ResponseMessage::updateFailed(__("User")));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(user $user)
    {
        $deleted = $user->delete();
        if ($deleted) {
            return response()->json(ResponseMessage::deleteSucceed(__("User")));
        }
        return response()->json(ResponseMessage::deleteFailed(__("User")));
    }
}
