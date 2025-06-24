<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Enums\QuizCategoryEnum;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Topic;
use App\Models\Quiz;
use App\Helpers\ResponseMessage;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:lesson-list', ['only' => ['index','show']]);
        $this->middleware('permission:lesson-create', ['only' => ['create','store']]);
        $this->middleware('permission:lesson-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:lesson-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lessons = Lesson::with('course')
            ->get();
        return view("dashboard.lesson.all", ["lessons" => $lessons]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::all();
        $topics = Topic::all();
        $quizzes = Quiz::where('category', QuizCategoryEnum::CLASS_TEST)
            ->get();

        return view("dashboard.lesson.new", [
            "courses" => $courses,
            "topics" => $topics,
            "quizzes" => $quizzes,
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
            "course_id" => "required|integer",
            "teaser" => "required|string",
            "topics" => "required|array",
            "description" => "required|string",
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

            $contentData = [
                'topics' => $request->topics,
                'course_id' => $request->course_id,
            ];

            $lesson = Lesson::create([
                "course_id" => $request->course_id,
                "title" => $request->title,
                "slug" => str()->slug($request->title),
                "settings_data" => "",
                "content_data" => json_encode($contentData),
                "teaser" => $request->teaser,
                "description" => $request->description,
                "image_url" => $image_url,
                "video_url" => $video_url,
                "document_url" => $document_url,
                "status" => $request->status,
            ]);

            return redirect()->route("dashboard.lessons.list")->with(ResponseMessage::createSucceed(__("Lesson")));

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(ResponseMessage::createFailed(__("Lesson")));
        }
    }

    /**
     * @todo check if dropdown menu value is set or not
     */
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lesson = Lesson::findOrFail($id);
        $courses = Course::all();
        $topics = Topic::all();
        $quizzes = Quiz::where('category', QuizCategoryEnum::CLASS_TEST)
            ->get();

        return view("dashboard.lesson.edit", [
            "lesson" => $lesson,
            "courses" => $courses,
            "topics" => $topics,
            "quizzes" => $quizzes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lesson $lesson)
    {
        $request->validate([
            "course_id" => "required|integer",
            "title" => "required|string",
            "teaser" => "required|string",
            "topics" => "required|array",
            "description" => "required|string",
            "image_url" => "nullable|file",
            "video_url" => "nullable|file",
            "document_url" => "nullable|file",
            "status" => "required|string",
        ]);

        $contentData = [
            'topics' => $request->topics,
            'course_id' => $request->course_id,
        ];

        $update_data = [
            "course_id" => $request->course_id,
            "title" => $request->title,
            "slug" => str()->slug($request->title),
            "settings_data" => $request->settings_data,
            "content_data" => json_encode($contentData),
            "teaser" => $request->teaser,
            "description" => $request->description,
            "image_url" => $request->image_url,
            "video_url" => $request->video_url,
            "document_url" => $request->document_url,
            "status" => $request->status,
        ];

        try {
            $upload = new UploadFileController();
            $image_url = '';
            $video_url = '';
            $document_url = '';

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

            $updated = $lesson->update($update_data);
            if ($updated) {
                return redirect()->route("dashboard.lessons.list")->with(ResponseMessage::updateSucceed(__("Lesson")));
            }
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(ResponseMessage::updateFailed(__("Lesson")));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lesson = Lesson::findOrFail($id);
        $deleted = $lesson->delete();
        if ($deleted) {
            return response()->json(ResponseMessage::deleteSucceed(__("Lesson")));
        }
        return response()->json(ResponseMessage::deleteFailed(__("Lesson")));
    }
}
