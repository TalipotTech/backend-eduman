<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\SiteSetting\SiteSettingController;
use App\Http\Controllers\Api\InnerPageSetting\SiteInnerPageController;
use App\Http\Controllers\Api\PageSetting\HomepageOneInfoController;
use App\Http\Controllers\Api\PageSetting\HomepageTwoInfoController;
use App\Http\Controllers\Api\PageSetting\HomepageThreeInfoController;
use App\Http\Controllers\Api\PageSetting\MenusController as PageSettingMenusController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\ResultController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\TopicController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\CourseReviewController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\ClassroomController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\EnrollController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\FaqController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('/v1')->group(function () {
    /** ======================================================
     *      1. User Routes
     * ====================================================== */
    Route::prefix('/users')->group(function () {
        /* Login route */
        Route::post('/login', [LoginController::class, 'store'])->name("users.login");
        Route::post('/register', [RegisterController::class, 'saveUser'])->name("users.register");
        Route::post('/order-with-register', [RegisterController::class, 'saveUserAndOrder'])->name("users.order_with_register");
        Route::post('/check-email', [ResetPasswordController::class, 'setCode'])->name("users.check_email");
        Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name("users.reset_password");
    });

    /** ======================================================
     *      2. Auth Routes
     * ====================================================== */
    Route::middleware('auth:sanctum')->group(function () {
        /* auth:sanctum user routes */
        Route::prefix('/users')->group(function () {
            Route::get('/me', [UserController::class, 'me']);
            Route::get('/courses', [UserController::class, 'getAuthUserCourses']);
            Route::get('/wishlist', [UserController::class, 'getAuthUserWishlist']);
            Route::get('/wishlist-save', [UserController::class, 'saveAuthUserWishlist']);
        });

        /* course enroll routes */
        Route::group(["prefix" => "course/enroll","as" => "course_enroll."], function () {
            Route::post('/student', [EnrollController::class, 'studentEnroll']);
            Route::post('/instructor', [EnrollController::class, 'instructorEnroll']);
        });

        /* course review routes */
        Route::group(["prefix" => "course/review","as" => "course_review."], function () {
            Route::post('/create', [CourseReviewController::class, 'createReview']);
        });

        /* update profile student routes */
        Route::group(["prefix" => "student/profile","as" => "studentProfile."], function () {
            Route::post('/update', [StudentController::class, 'createOrUpdate']);
            Route::post('/update-avatar', [StudentController::class, 'uploadStudentAvatar']);
            Route::post('/update-banner', [StudentController::class, 'uploadStudentBanner']);
        });
    });

    /** ======================================================
     *      3. Courses Routes
     * ====================================================== */
    Route::group(["prefix" => "courses","as" => "course."], function () {
        Route::get('/all', [ CourseController::class, 'getCourses']);
        Route::get('/top6', [ CourseController::class, 'getTop6Courses']);
        Route::post('/search', [ CourseController::class, 'getSearchCourses']);
        Route::get('/tabs-courses-and-categories', [ CourseController::class, 'getTabsCourses']);
        Route::get('/{course}/categories', [CourseController::class, 'getCategory']);
        Route::get('/{course}/students', [CourseController::class, 'getCourseStudents']);
        Route::get('/{course}/instructors', [CourseController::class, 'getInstructors']);
        Route::get('/{course}/classroom', [CourseController::class, 'getClassroom']);
        Route::get('/details', [CourseController::class, 'getCourseDetailsFromSlug']);
        Route::get('/reviews', [CourseReviewController::class, 'getReviewFromCourse']);
    });

    /** ======================================================
     *      3. Authors Routes
     * ====================================================== */
    Route::group(["prefix" => "author","as" => "author."], function () {
        Route::get('/instructors', [AuthorController::class, 'getAuthors']);
        Route::get('/{author}/courses', [AuthorController::class, 'getCoursesFromAuthor']);
        Route::get('/{authorId}/details', [AuthorController::class, 'getAuthorDetails']);
        Route::get('/details', [AuthorController::class, 'getInstructorFromSlug']);
    });

     /** ======================================================
     *      4. Students Routes
     * ====================================================== */
    Route::group(["prefix" => "student","as" => "student."], function () {
        Route::get('/all', [StudentController::class, 'getStudents']);
        Route::get('/{student}/courses', [StudentController::class, 'getStudentCourses']);
        Route::get('/details/from-user', [StudentController::class, 'getStudentDetails']);
        Route::get('/details', [StudentController::class, 'getStudentFromSlug']);
    });
    
    /** ======================================================
     *      6. Category Routes
     * ====================================================== */
    Route::group(["prefix" => "categories","as" => "category."], function () {
        Route::get('/type', [CategoryController::class, 'getCategoryByTypes']);
        Route::get('/courses', [CategoryController::class, 'getCoursesFromCategory']);
        Route::get('/{category}/chields', [CategoryController::class, 'getCategoryChields']);
    });

    /** ======================================================
     *      7. Event Routes
     * ====================================================== */
    Route::group(["prefix" => "events","as" => "event."], function () {
        Route::get('/', [EventController::class, 'getEvents']);
        Route::get('/upcoming', [EventController::class, 'getUpcomingEvents']);
        Route::get('/past', [EventController::class, 'getPastEvents']);
        Route::get('/{event}/details', [EventController::class, 'getEventDetails']);
        Route::get('/details', [EventController::class, 'getEventDetailsFromSlug']);
    });

    /** ======================================================
     *      7. Page Routes
     * ====================================================== */
    Route::group(["prefix" => "page","as" => "page."], function () {
        Route::get('/', [PageController::class, 'getPages']);
        Route::get('/details', [PageController::class, 'getPageDetailsFromSlug']);
    });

    /** ======================================================
     *      8. Classroom Routes
     * ====================================================== */
    Route::group(["prefix" => "class","as" => "classroom."], function () {
        Route::get('/', [ClassroomController::class, 'getClassrooms']);
        Route::get('/by-course', [ClassroomController::class, 'getClassroomFromCourse']);
        Route::get('/{class}/details', [ClassroomController::class, 'getClassrooms']);
        Route::get('/details', [ClassroomController::class, 'getClassDetailsFromSlug']);
    });

    /** ======================================================
     *      10. Lesson Routes
     * ====================================================== */
    Route::group(["prefix" => "lessons","as" => "lesson."], function () {
        Route::get('/', [LessonController::class, 'getLessons']);
        Route::get('/by-course', [LessonController::class, 'getLessonsFromCourse']);
        Route::get('/by-classroom', [LessonController::class, 'getLessonsFromClassroom']);
        Route::get('/{lesson}/details', [LessonController::class, 'getLessonDetails']);
    });

    /** ======================================================
     *      11. Topic Routes
     * ====================================================== */
    Route::group(["prefix" => "topics","as" => "topic."], function () {
        Route::get('/', [TopicController::class, 'getTopics']);
        Route::get('/by-course', [TopicController::class, 'getTopicsFromCourse']);
        Route::get('/by-classroom', [TopicController::class, 'getTopicsFromClassroom']);
        Route::get('/{topic}/details', [TopicController::class, 'getTopicDetails']);
    });

    /** ======================================================
     *      12. Subscription Routes
     * ====================================================== */
    Route::group(["prefix" => "subscription","as" => "plan."], function () {
        Route::get('/packages', [SubscriptionController::class, 'getPlansAll']);
    });

    /** ======================================================
     *      14. Quiz Routes
     * ====================================================== */
    Route::group(["prefix" => "quiz","as" => "quiz."], function () {
        Route::get('/', [QuizController::class, 'getQuizzes']);
        Route::get('/{quiz}/details', [QuizController::class, 'getQuizDetails']);
        Route::get('/details', [QuizController::class, 'getQuizDetailsFromSlug']);
    });

    /** ======================================================
     *      14. Quiz Results Routes
     * ====================================================== */
    Route::group(["prefix" => "result","as" => "result."], function () {
        Route::get('/', [ResultController::class, 'getResult']);
        Route::get('/{result}/details', [ResultController::class, 'getResultDetails']);
        Route::get('/user-exam', [ResultController::class, 'getResultDetailsFromSlug']);
        Route::post('/quiz-submit', [ResultController::class, 'saveQuizResult']);
    });

    /** ======================================================
     *      13. Question Routes
     * ====================================================== */
    Route::group(["prefix" => "questions","as" => "question."], function () {
        Route::get('/', [QuestionController::class, 'getQuestions']);
        Route::get('/{question}/details', [QuestionController::class, 'getQuestionDetails']);
    });

    /** ======================================================
     *      14. Blog Routes
     * ====================================================== */
    Route::group(["prefix" => "blogs","as" => "blog."], function () {
        Route::get('/list', [BlogController::class, 'getBlogs']);
        Route::get('/{blog}/details', [BlogController::class, 'getBlogDetails']);
        Route::get('/by-category', [BlogController::class, 'getBlogsByCategory']);
        Route::get('/details', [BlogController::class, 'getBlogDetailsFromSlug']);
    });

    /** ======================================================
     *      15. FAQs Routes
     * ====================================================== */
    Route::group(["prefix" => "faqs","as" => "faq."], function () {
        Route::get('/', [FaqController::class, 'getFaqs']);
        Route::get('/{faq}/details', [FaqController::class, 'getFaqDetails']);
        Route::get('/details', [FaqController::class, 'getFaqDetailsFromSlug']);
    });
       
    /** ======================================================
     *      28. Site Inner Pages routes
     * ====================================================== */
    Route::group(["prefix" => "setting/inner-page"], function () {     
        Route::get('login', [SiteInnerPageController::class, 'getLoginPage'])
            ->name('frontend.setting_inner_page.login');
        Route::get('forget-password', [SiteInnerPageController::class, 'getForgetPasswordPage'])
            ->name('frontend.setting_inner_page.forget_password');
        Route::get('signup', [SiteInnerPageController::class, 'getSignUpPage'])
            ->name('frontend.setting_inner_page.signup');
        Route::get('contact', [SiteInnerPageController::class, 'getContactPage'])
            ->name('frontend.setting_inner_page.contact');
        Route::get('zoom-class', [SiteInnerPageController::class, 'getZoomClassPage'])
            ->name('frontend.setting_inner_page.zoom_class');
        Route::get('zoom-class-details', [SiteInnerPageController::class, 'getZoomClassDetailsPage'])
            ->name('frontend.setting_inner_page.zoom_class_details');
        Route::get('course', [SiteInnerPageController::class, 'getCoursePage'])
            ->name('frontend.setting_inner_page.course');
        Route::get('course-details', [SiteInnerPageController::class, 'getCourseDetailsPage'])
            ->name('frontend.setting_inner_page.course_details');
        Route::get('course-details', [SiteInnerPageController::class, 'getCourseDetailsPage'])
            ->name('frontend.setting_inner_page.course_details');
        Route::get('webinar', [SiteInnerPageController::class, 'getWebinarPage'])
            ->name('frontend.setting_inner_page.webinar');
        Route::get('webinar-details', [SiteInnerPageController::class, 'getWebinarDetailsPage'])
            ->name('frontend.setting_inner_page.webinar_details');
        Route::get('wishlist', [SiteInnerPageController::class, 'getWishlistPage'])
            ->name('frontend.setting_inner_page.wishlist');
        Route::get('checkout', [SiteInnerPageController::class, 'getCheckoutPage'])
            ->name('frontend.setting_inner_page.checkout');
        Route::get('cart', [SiteInnerPageController::class, 'getCartPage'])
            ->name('frontend.setting_inner_page.cart');
        Route::get('about', [SiteInnerPageController::class, 'getAboutPage'])
            ->name('frontend.setting_inner_page.about');
        Route::get('instructors', [SiteInnerPageController::class, 'getInstructorsListPage'])
            ->name('frontend.setting_inner_page.instructors');
        Route::get('instructor-details', [SiteInnerPageController::class, 'getInnerInstructorPage'])
            ->name('frontend.setting_inner_page.instructor_details');
        Route::get('student-profile', [SiteInnerPageController::class, 'getStudentProfilePage'])
            ->name('frontend.setting_inner_page.student_profile');
        Route::get('instructor-profile', [SiteInnerPageController::class, 'getInstructorProfilePage'])
            ->name('frontend.setting_inner_page.instructors_profile');
        Route::get('become-instructor', [SiteInnerPageController::class, 'getBecomeInstructorPage'])
            ->name('frontend.setting_inner_page.become_instructor');
        Route::get('blogs', [SiteInnerPageController::class, 'getBlogsListPage'])
            ->name('frontend.setting_inner_page.blogs');
        Route::get('blog-details', [SiteInnerPageController::class, 'getBlogDetailsPage'])
            ->name('frontend.setting_inner_page.blog_details');
        Route::get('events', [SiteInnerPageController::class, 'getEventsListPage'])
            ->name('frontend.setting_inner_page.events');
        Route::get('event-details', [SiteInnerPageController::class, 'getEventDetailsPage'])
            ->name('frontend.setting_inner_page.event_details');
        Route::get('faqs', [SiteInnerPageController::class, 'getFaqsListPage'])
            ->name('frontend.setting_inner_page.faqs');
        Route::get('faq-details', [SiteInnerPageController::class, 'getFaqDetailsPage'])
            ->name('frontend.setting_inner_page.faq_details');
        Route::get('membership', [SiteInnerPageController::class, 'getMembershipPage'])
            ->name('frontend.setting_inner_page.membership');
        Route::get('404-page', [SiteInnerPageController::class, 'get404Page'])
            ->name('frontend.setting_inner_page.404_page');
        Route::get('become-instructor', [SiteInnerPageController::class, 'getBecomeInstructorPage'])
            ->name('frontend.setting_inner_page.become_instructor');
        Route::get('thankyou', [SiteInnerPageController::class, 'getThankyouPage'])
            ->name('frontend.setting_inner_page.thankyou');
        Route::get('failed-payment', [SiteInnerPageController::class, 'getFailedPaymentPage'])
            ->name('frontend.setting_inner_page.failed-payment');
    });

    /** ======================================================
     *      29. Site Setting routes
     * ====================================================== */
    Route::group(["prefix" => "site-setting"], function () {        
        /* header */
        Route::get('header', [SiteSettingController::class, 'getSiteHeader'])
            ->name('frontend.site_setting.header');
        Route::get('footer', [SiteSettingController::class, 'getSiteFooter'])
            ->name('frontend.site_setting.footer');
    });
    
    /** ======================================================
     *      30. PageSetting routes
     * ====================================================== */
    Route::group(["prefix" => "setting"], function () {        
        /* course page setting */
        Route::group(["prefix" => "menu","as" => "menu."], function () {
            Route::get('by-category', [PageSettingMenusController::class, 'getMenusByCategory'])
                ->name('frontend.menus.by-Category');
        });

        /* home-1 page setting */
        Route::group(["prefix" => "home-01","as" => "home-01."], function () {
            Route::get('header', [HomepageOneInfoController::class, 'getHomeOneHeader'])
                ->name("frontend.home-01.header");
            Route::get('categories', [HomepageOneInfoController::class, 'getHomeOneCategories'])
                ->name("frontend.home-01.categories");
            Route::get('course', [HomepageOneInfoController::class, 'getHomeOneCourse'])
                ->name("frontend.home-01.course");
            Route::get('features', [HomepageOneInfoController::class, 'getHomeOneFeatures'])
                ->name("frontend.home-01.features");
            Route::get('about-us', [HomepageOneInfoController::class, 'getHomeOneAbout'])
                ->name("frontend.home-01.about");
            Route::get('testimonial', [HomepageOneInfoController::class, 'getHomeOneTestimonial'])
                ->name("frontend.home-01.testimonial");
            Route::get('cta-01', [HomepageOneInfoController::class, 'getHomeOneCtaOne'])
                ->name("frontend.home-01.cta-01");
            Route::get('cta-02', [HomepageOneInfoController::class, 'getHomeOneCtaTwo'])
                ->name("frontend.home-01.cta-02");
            Route::get('brand', [HomepageOneInfoController::class, 'getHomeOneBrand'])
                ->name("frontend.home-01.brand");
        });

        /* home-2 page setting */
        Route::group(["prefix" => "home-02","as" => "home-02."], function () {
            Route::get('header', [HomepageTwoInfoController::class, 'getHomeTwoHeader'])
                ->name("frontend.home-02.header");
            Route::get('stats', [HomepageTwoInfoController::class, 'getHomeTwoStats'])
                ->name("frontend.home-02.stats");
            Route::get('partners', [HomepageTwoInfoController::class, 'getHomeTwoPartners'])
                ->name("frontend.home-02.partners");
            Route::get('cta-01', [HomepageTwoInfoController::class, 'getHomeTwoCtaOne'])
                ->name("frontend.home-02.cta_01");
            Route::get('categories', [HomepageTwoInfoController::class, 'getHomeTwoCategories'])
                ->name("frontend.home-02.categories");
            Route::get('course', [HomepageTwoInfoController::class, 'getHomeTwoCourse'])
                ->name("frontend.home-02.course");
            Route::get('features', [HomepageTwoInfoController::class, 'getHomeTwoFeatures'])
                ->name("frontend.home-02.features");
            Route::get('cta-02', [HomepageTwoInfoController::class, 'getHomeTwoCtaTwo'])
                ->name("frontend.home-02.cta_02");
            Route::get('cta-03', [HomepageTwoInfoController::class, 'getHomeTwoCtaThree'])
                ->name("frontend.home-02.cta_03");
            Route::get('cta-04', [HomepageTwoInfoController::class, 'getHomeTwoCtaFour'])
                ->name("frontend.home-02.cta_04");
        });

        /* home-3 page setting */
        Route::group(["prefix" => "home-03","as" => "home-03."], function () {
            Route::get('header', [HomepageThreeInfoController::class, 'getHomeThreeHeader'])
                ->name("frontend.home-03.header");
            Route::get('welcome-message', [HomepageThreeInfoController::class, 'getHomeThreeWelcomeMessage'])
                ->name("frontend.home-03.welcomeMessage");
            Route::get('course-overview', [HomepageThreeInfoController::class, 'getHomeThreeCourseOverview'])
                ->name("frontend.home-03.courseOverview");
            Route::get('stats', [HomepageThreeInfoController::class, 'getHomeThreeStats'])
                ->name("frontend.home-03.stats");
            Route::get('course', [HomepageThreeInfoController::class, 'getHomeThreeCourse'])
                ->name("frontend.home-03.course");
            Route::get('about', [HomepageThreeInfoController::class, 'getHomeThreeAboutInfo'])
                ->name("frontend.home-03.about");
            Route::get('insta-images-more-titles', [HomepageThreeInfoController::class, 'getHomeThreeInstaImagesTitles'])
                ->name("frontend.home-03.insta-images-more-titles");
        });
    });
});
