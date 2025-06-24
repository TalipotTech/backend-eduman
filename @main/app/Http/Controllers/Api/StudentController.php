<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use Laravel\Cashier\Order\Order;
use App\Models\CourseReview;
use App\Models\CourseUser;
use App\Enums\StatusEnum;

class StudentController extends Controller
{
    
    /**
     * @OA\Get(
     *    path="/student/all",
     *    operationId="getStudents",
     *    tags={"Student"},
     *    summary="Get list of Students",
     *    description="Get list of Students",
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getStudents(Request $request)
    {
        $Students = Student::with('user')
            ->where('status', StatusEnum::ACTIVE)
            ->get();
        
        return response()->json([
            'data' => $Students,
        ]);
    }
    
    /**
     * @OA\Get(
     *    path="/student/{student}/courses",
     *    operationId="getStudentCourses",
     *    tags={"Student"},
     *    summary="Get list of Student Courses",
     *    description="Get list of Student Courses",
     *    @OA\Parameter(name="student", in="path", description="student", required=true,
     *        @OA\Schema(type="integer")
     *    ),
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getStudentCourses(Student $student, Request $request)
    {
        return response()->json([
            'data' => $student->courses,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/student/details",
     *    operationId="getStudentFromSlug",
     *    tags={"Student"},
     *    summary="Get student details",
     *    description="Get student details", 
     *    @OA\Parameter(name="slug", in="query", description="slug", example="samiha-jahan", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getStudentFromSlug(Request $request)
    {
        $student = Student::where('slug', [$request->slug])
            ->with('courses')
            ->with('user')
            ->first();

        return response()->json([
            'data' => $student,
        ]);
    }

    /**
     * @OA\Get(
     *    path="/student/details/from-user",
     *    operationId="getStudentDetails",
     *    tags={"Student"},
     *    summary="Get Student details",
     *    description="Get Student details",
     *    @OA\Parameter(name="userId", in="query", description="userId", required=true,
     *        @OA\Schema(type="integer")
     *    ),
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getStudentDetails(Request $request)
    {
        if( $request->userId != null )
        {
            $userId = $request->userId;
            $std = Student::where('user_id', $userId)
                ->with('user')
                ->first();
            $user = User::where('id', $userId)
                ->with([
                    'courses' => [
                        'categories',
                    ]
                ])
                ->first();
            $std['courses'] = $user->courses;
            $std['courseReviews'] = CourseReview::where('user_id', $userId)->get();
            
            $orderArray = array();
            $orderSingleArray = array(
                'email' => $user->email,
                'total_price' => '0',
                'start_at' => '',
                'end_at' => '',
            );
    
            $orders = Order::join("order_items","order_items.order_id","=","orders.id")
                ->where('orders.owner_id', $userId)
                ->orderBy("orders.id", "DESC")
                ->select('orders.currency', 'orders.total', 'orders.mollie_payment_status', 'order_items.description_extra_lines', 'order_items.quantity')
                ->get();

            if( !empty($orders) )
            {
                foreach($orders as $order)
                {
                    $startEndDate = json_decode($order->description_extra_lines);
                    if( !empty($startEndDate[0]) )
                    {
                        $startEndDateArray = explode(' ', $startEndDate[0]);
                        $orderSingleArray['currency'] = $order->currency;
                        $orderSingleArray['total_price'] = $order->total;
                        $orderSingleArray['status'] = $order->mollie_payment_status;
                        $orderSingleArray['quantity'] = $order->quantity;
                        $orderSingleArray['start_at'] = !empty($startEndDateArray[1]) ? $startEndDateArray[1] : date('Y-m-d');
                        $orderSingleArray['end_at'] = !empty($startEndDateArray[3]) ? $startEndDateArray[3] : date('Y-m-d');
                    }
                    array_push($orderArray, $orderSingleArray);
                }
            }
            $std['orders'] = $orderArray;
            
            return response()->json([
                'data' => $std,
                'userId' => $request->userId,
            ]);
        }
        else 
        {
            return response()->json([
                "success" => false,
            ]);
        }
    }

   /**
     * @OA\Post(
     * path="/student/profile/update",
     * summary="Create course review",
     * description="Create course review",
     * operationId="createOrUpdate",
     * tags={"Student"},
     * security={ {"sanctum": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Course review",
     *    @OA\JsonContent(         
     *       required={"userId", "titel_name", "first_name", "last_name", "street_address", "city", "zip", 
     *    "country", "teaser", "description", "fb_url", "website_url", "instagram_url", "status"},
     *       @OA\Property(property="titelName", type="string", example="Mr."),
     *       @OA\Property(property="firstName", type="string", example="Saif"),
     *       @OA\Property(property="lastName", type="string", example="Hasan"),
     *       @OA\Property(property="streetAddress", type="string", example="House 405, Suite 3"),
     *       @OA\Property(property="city", type="string", example="New York"),
     *       @OA\Property(property="zip", type="string", example="10005"),
     *       @OA\Property(property="country", type="string", example="USA"),
     *       @OA\Property(property="fbUrl", type="string", example="https://www.facebook.com/eduman"),
     *       @OA\Property(property="websiteUrl", type="string", example="https://eduman.edu"),
     *       @OA\Property(property="instagramUrl", type="string", example="https://www.instagram.com/"),
     *       @OA\Property(property="status", type="string", example="Active")
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Error response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, Can't create")
     *        )
     *     )
     * )
     */
    public function createOrUpdate(Request $request)
    {
        if( !empty($request->user()->id) )
        {
            $lastName = !empty($request->lastName) ? ' '. $request->lastName : '';
            $slug = str()->slug($request->firstName . $lastName);

            $studentData = [
                "user_id" => $request->user()->id,
                "titel_name" => $request->titelName ?? "",
                "first_name" => $request->firstName ?? "",
                "last_name" => $request->lastName ?? "",
                "slug" => $slug,
                "street_address" => $request->streetAddress ?? "",
                "city" => $request->city ?? "",
                "zip" => $request->zip ?? "",
                "country" => $request->country ?? "",
                "teaser" => $request->teaser ?? "",
                "description" => $request->description ?? "",
                "fb_url" => $request->fbUrl ?? "",
                "website_url" => $request->websiteUrl ?? "",
                "instagram_url" => $request->instagramUrl ?? "",
                "status" => $request->status ?? "",
            ];

            $studentData['image_url'] = "";
            $studentData['banner_url'] = "";

            if( Student::where('user_id', $request->user()->id)->count() > 0 )
            {
                $student = Student::where('user_id', $request->user()->id)->first();
                $student->update($studentData);
            }
            else 
            {
               $student = Student::create($studentData);
            }

            return response()->json([
                'data' => $student,
            ]);
        }
        else 
        {
            return response()->json([
                "success" => false,
            ]);
        }
    }

    /**
     * Upload/update user avatar
     *
     * @param Request $request
     * @return object
     */
    public function uploadStudentAvatar(Request $request)
    {
        if( !empty($request->user()->id) )
        {
            $image_url = '';
            $user = $request->user();
            $upload = new \App\Http\Controllers\Admin\UploadFileController();
            if (!empty($request->file('imageUrl'))) {
                $image_url = $upload->uploadImage($request, 'imageUrl');
            }

            if( Student::where('user_id', $request->user()->id)->count() > 0 )
            {
                $student = Student::where('user_id', $request->user()->id)->first();
                if( !empty($student) )
                {
                    $student->update([
                        'image_url' => $image_url
                    ]);
    
                    return response()->json([
                        'data' => $student,
                    ]);
                }
                
            }

            return response()->json([
                'success' => false,
            ]);
        }
        else 
        {
            return response()->json([
                "success" => false,
            ]);
        }
    }

    /**
     * Upload/update user banner
     *
     * @param Request $request
     * @return object
     */
    public function uploadStudentBanner(Request $request)
    {
        if( !empty($request->user()->id) )
        {
            $banner_url = '';
            $user = $request->user();
            $upload = new \App\Http\Controllers\Admin\UploadFileController();
            if (!empty($request->file('bannerUrl'))) {
                $banner_url = $upload->uploadImage($request, 'bannerUrl');
            } 

            if( Student::where('user_id', $request->user()->id)->count() > 0 )
            {
                $student = Student::where('user_id', $request->user()->id)->first();
                if( !empty($student) )
                {
                    $student->update([
                        'banner_url' => $banner_url
                    ]);
    
                    return response()->json([
                        'data' => $student,
                    ]);
                }
            }

            return response()->json([
                'success' => false,
            ]);
        }
        else 
        {
            return response()->json([
                "success" => false,
            ]);
        }
    }
}
