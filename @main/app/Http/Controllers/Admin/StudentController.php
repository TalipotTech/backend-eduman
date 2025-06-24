<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:student-list', ['only' => ['index','show']]);
        $this->middleware('permission:student-create', ['only' => ['create','store']]);
        $this->middleware('permission:student-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:student-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();
        return view("dashboard.student.list", compact("students"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $studentsData = User::where('role', 'Student')
            ->get();

        $users = array();
        if($studentsData)
        {
            foreach($studentsData as $student)
            {
                $singleStudent = array(
                    'id' => $student->id,
                    'title' => $student->first_name .' '. $student->last_name,
                );
                array_push($users, $singleStudent);
            }
        }
 
        return view("dashboard.student.new", compact("users"));
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
            'titel_name' => 'nullable|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'street_address' => 'required|string',
            'city' => 'required|string',
            'zip' => 'required|string',
            'country' => 'required|string',
            'teaser' => 'required|string',
            'description' => 'required|string',
            'image_url' => 'nullable|file',
            'banner_url' => 'nullable|file',
            'fb_url' => 'nullable|string',
            'website_url' => 'nullable|string',
            'instagram_url' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $lastName = !empty($request->last_name) ? ' '. $request->last_name : '';
        $slug = str()->slug($request->first_name . $lastName);

        $studentData = [
            "user_id" => $request->user_id,
            "titel_name" => $request->titel_name ?? "",
            "first_name" => $request->first_name ?? "",
            "last_name" => $request->last_name ?? "",
            "slug" => $slug,
            "street_address" => $request->street_address ?? "",
            "city" => $request->city ?? "",
            "zip" => $request->zip ?? "",
            "country" => $request->country ?? "",
            "teaser" => $request->teaser ?? "",
            "description" => $request->description ?? "",
            "fb_url" => $request->fb_url ?? "",
            "website_url" => $request->website_url ?? "",
            "instagram_url" => $request->instagram_url ?? "",
            "status" => $request->status ?? "",
        ];

        $upload = new UploadFileController();

        if (!empty($request->file('image_url'))) {
            $studentData['image_url'] = $upload->uploadImage($request, 'image_url');
        }

        if (!empty($request->file('banner_url'))) {
            $studentData['banner_url'] = $upload->uploadImage($request, 'banner_url');
        }

        $student = Student::create($studentData);

        if ($student) {
            return redirect()->route("dashboard.students.list")->with(ResponseMessage::createSucceed(__("Student")));
        }
        return back()->withErrors(ResponseMessage::createFailed(__("Student")));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        $studentsData = User::where('role', 'Student')
            ->get();
        $users = array();
        if($studentsData)
        {
            foreach($studentsData as $std)
            {
                $singleStudent = array(
                    'id' => $std->id,
                    'title' => $std->first_name .' '. $std->last_name,
                );
                array_push($users, $singleStudent);
            }
        }
        return view("dashboard.student.edit", compact("student", "users"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'titel_name' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'street_address' => 'required|string',
            'city' => 'required|string',
            'zip' => 'required|string',
            'country' => 'required|string',
            'teaser' => 'required|string',
            'description' => 'required|string',
            'image_url' => 'nullable|file',
            'banner_url' => 'nullable|file',
            'website_url' => 'nullable|string',
            'instagram_url' => 'nullable|string',
            'fb_url' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $lastName = !empty($request->last_name) ? ' '. $request->last_name : '';
        $slug = str()->slug($request->first_name . $lastName);

        $studentData = [
            "user_id" => $request->user_id,
            "titel_name" => $request->titel_name ?? "",
            "first_name" => $request->first_name ?? "",
            "last_name" => $request->last_name ?? "",
            "slug" => $slug,
            "street_address" => $request->street_address ?? "",
            "city" => $request->city ?? "",
            "zip" => $request->zip ?? "",
            "country" => $request->country ?? "",
            "teaser" => $request->teaser ?? "",
            "description" => $request->description ?? "",
            "fb_url" => $request->fb_url ?? "",
            "website_url" => $request->website_url ?? "",
            "instagram_url" => $request->instagram_url ?? "",
            "status" => $request->status ?? "",
        ];

        $upload = new UploadFileController();

        if (!empty($request->file('image_url'))) {
            $studentData['image_url'] = $upload->uploadImage($request, 'image_url');
        }

        if (!empty($request->file('banner_url'))) {
            $studentData['banner_url'] = $upload->uploadImage($request, 'banner_url');
        }

        $updated = $student->update($studentData);

        if ($updated) {
            return redirect()->route("dashboard.students.list")->with(ResponseMessage::updateSucceed(__("Student")));
        }
        return back()->with(ResponseMessage::updateFailed(__("Student")));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $deleted = $student->delete();
        if ($deleted) {
            return response()->json(ResponseMessage::deleteSucceed(__("Student")));
        }
        return response()->json(ResponseMessage::deleteFailed(__("Student")));
    }
}
