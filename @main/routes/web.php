<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ClassroomController;
use App\Http\Controllers\SubscriptionPlanController; 
use App\Http\Controllers\PaypalPayController; 
use App\Http\Controllers\StripePayController; 
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\EdumanInstallController; 
use App\Http\Controllers\AboutController; 
use App\Http\Controllers\ContactController; 
use App\Http\Controllers\PricingController; 
use App\Http\Controllers\GetStartedController; 
use App\Http\Controllers\FaqController as FrontendFaqController; 
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CourseReviewController;
use App\Http\Controllers\Admin\CourseAuthorController;
use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\AssetController; 
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\QuizImportController;
use App\Http\Controllers\Admin\QuizResultController;
use App\Http\Controllers\Admin\Settings\MenuController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SliderItemController;
use App\Http\Controllers\Admin\TopicController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\Settings\HomepageSettingsController;
use App\Http\Controllers\Admin\Settings\Homepage3SettingsController;
use App\Http\Controllers\Admin\Settings\SiteSettingsController;
use App\Http\Controllers\Admin\InnerPageSetting\InnerPageController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\PricePlanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/subscribe/{uid}/{plan}', [SubscriptionPlanController::class, '__invoke']);
    Route::get('paypal-view', [PaypalPayController::class, 'index'])->name('paypal.view');
    Route::get('paypal-payment', [PaypalPayController::class, 'handlePayment'])->name('paypal.payment');
    Route::get('paypal-cancel', [PaypalPayController::class, 'paymentCancel'])->name('paypal.cancel');
    Route::get('paypal-success', [PaypalPayController::class, 'paymentSuccess'])->name('paypal.success');
    Route::get('stripe-payment', [StripePayController::class, 'stripePayment'])->name('StripePay');
    Route::post('stripe-payment', [StripePayController::class, 'stripePaymentPost'])->name('StripePay');
    Route::get('/about', [AboutController::class, 'index']);
    Route::get('/contact', [ContactController::class, 'index']);
    Route::get('/pricing', [PricingController::class, 'index']);
    Route::get('/faq', [FrontendFaqController::class, 'index']);
    Route::get('/get-started', [GetStartedController::class, 'index'])->name('get-started');
    Route::get('/get-started/create', [GetStartedController::class, 'create'])->name('get_started.create');
    Route::post('/get-started/save', [GetStartedController::class, 'store'])->name('get_started.store');
    Route::get('/get-started/create-step2', [GetStartedController::class, 'createStep2'])->name('get_started.createStep2');
    Route::post('/get-started/save-step2', [GetStartedController::class, 'storeStep2'])->name('get_started.storeStep2');
    Route::get('/get-started/create-step3', [GetStartedController::class, 'createStep3'])->name('get_started.createStep3');
    Route::post('/get-started/save-step3', [GetStartedController::class, 'storeStep3'])->name('get_started.storeStep3');
    Route::post('/eduman-install-run', [EdumanInstallController::class, 'installerRun'])->name('edumanEnvironmentDbSave');
    Route::get('/eduman-install-db', [EdumanInstallController::class, 'database'])->name('edumanDatabaseSave');
});
//Route::middleware(['auth', 'verified'])->group(function () {
Route::middleware(['auth', 'verified'])->group(function () {
    /** =======================================================================
     *      Dashboard Routes
     * ======================================================================= */
    Route::prefix('/dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        /** =======================================================================
         *      Author Routes
         * ======================================================================= */
        Route::group(["prefix" => "authors", "as" => "dashboard.authors."], function () {
            Route::get('/', [AuthorController::class, 'index'])->name('list');
            Route::get('/new', [AuthorController::class, 'create'])->name('new');
            Route::post('/new', [AuthorController::class, 'store']);
            Route::get('/edit/{author}', [AuthorController::class, 'edit'])->name('edit');
            Route::post('/edit/{author}', [AuthorController::class, 'update']);
            Route::post('/delete/{author}', [AuthorController::class, 'destroy'])->name('delete');
        });

        /** =======================================================================
         *      Course Review Routes
         * ======================================================================= */
        Route::group(["prefix" => "course-reviews", "as" => "dashboard.courseReview."], function () {
            Route::get('/', [CourseReviewController::class, 'index'])->name('list');
            Route::get('/new', [CourseReviewController::class, 'create'])->name('new');
            Route::post('/new', [CourseReviewController::class, 'store']);
            Route::get('/edit/{review}', [CourseReviewController::class, 'edit'])->name('edit');
            Route::post('/edit/{review}', [CourseReviewController::class, 'update']);
            Route::post('/delete/{review}', [CourseReviewController::class, 'destroy'])->name('delete');
        });

        /** =======================================================================
         *      Student Routes
         * ======================================================================= */
        Route::group(["prefix" => "students", "as" => "dashboard.students."], function () {
            Route::get('/', [StudentController::class, 'index'])->name('list');
            Route::get('/new', [StudentController::class, 'create'])->name('new');
            Route::post('/new', [StudentController::class, 'store']);
            Route::get('/edit/{student}', [StudentController::class, 'edit'])->name('edit');
            Route::post('/edit/{student}', [StudentController::class, 'update']);
            Route::post('/delete/{student}', [StudentController::class, 'destroy'])->name('delete');
        });

        /** =======================================================================
         *      User Routes
         * ======================================================================= */
        Route::group(["prefix" => "users", "as" => "dashboard.users."], function () {
            Route::get('/', [UserController::class, 'index'])->name('list');
            Route::get('/new', [UserController::class, 'create'])->name('new');
            Route::post('/new', [UserController::class, 'store']);
            Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
            Route::post('/edit/{user}', [UserController::class, 'update']);
            Route::post('/delete/{user}', [UserController::class, 'destroy'])->name('delete');
        });

        /** =======================================================================
         *      Course Routes
         * ======================================================================= */
        Route::get('/courses/list', [CourseController::class, 'index'])->name('dashboard.courses.list');
        Route::get('/course/add', [CourseController::class, 'create'])->name('dashboard.course.add');
        Route::post('/course/save', [CourseController::class, 'store'])->name('dashboard.course.save');
        Route::get('/course/{course}/edit', [CourseController::class, 'edit'])->name('dashboard.course.edit');
        Route::post('/course/{course}/update', [CourseController::class, 'update'])->name('dashboard.course.update');
        Route::post('/course/{course}/delete', [CourseController::class, 'destroy'])->name('dashboard.course.delete');

        /** =======================================================================
         *      Course authors Routes
         * ======================================================================= */
        Route::group(["prefix" => "course-authors", "as" => "dashboard.courseAuthor."], function () {
            Route::get('/', [CourseAuthorController::class, 'index'])->name('list');
            Route::get('/new', [CourseAuthorController::class, 'create'])->name('new');
            Route::post('/new', [CourseAuthorController::class, 'store']);
            Route::get('/edit/{ca}', [CourseAuthorController::class, 'edit'])->name('edit');
            Route::post('/edit/{ca}', [CourseAuthorController::class, 'update']);
            Route::post('/delete/{ca}', [CourseAuthorController::class, 'destroy'])->name('delete');
        });

        /** =======================================================================
         *      Course Category Routes
         * ======================================================================= */
        Route::group(["prefix" => "course-category", "as" => "dashboard.courseCategory."], function () {
            Route::get('/', [CourseCategoryController::class, 'index'])->name('list');
            Route::get('/new', [CourseCategoryController::class, 'create'])->name('new');
            Route::post('/new', [CourseCategoryController::class, 'store']);
            Route::get('/edit/{cc}', [CourseCategoryController::class, 'edit'])->name('edit');
            Route::post('/edit/{cc}', [CourseCategoryController::class, 'update']);
            Route::post('/delete/{cc}', [CourseCategoryController::class, 'destroy'])->name('delete');
        });


        // categories
        Route::group(["prefix" => "categories", "as" => "dashboard.category."], function () {
            Route::get('/', [CategoryController::class, 'index'])->name('list');
            Route::get('/new', [CategoryController::class, 'create'])->name('new');
            Route::post('/new', [CategoryController::class, 'store']);
            Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('edit');
            Route::post('/edit/{category}', [CategoryController::class, 'update']);
            Route::post('/delete/{category}', [CategoryController::class, 'destroy'])->name('delete');
        });

        /** =======================================================================
         *      Featured Course Routes
         * ======================================================================= */
        Route::group(["prefix" => "featured-courses", "as" => "dashboard.featured_courses."], function () {
            Route::get('/', [CourseController::class, 'index'])->name('list');
            Route::post('/new', [CourseController::class, 'store'])->name('new');
            Route::post('/edit/{Course}', [CourseController::class, 'update'])->name('edit');
            Route::post('/delete/{Course}', [CourseController::class, 'destroy'])->name('delete');
        });

        /** =======================================================================
         *      Classroom Routes
         * ======================================================================= */
        Route::group(["prefix" => "classrooms", "as" => "dashboard.classrooms."], function () {
            Route::get('/', [ClassroomController::class, 'index'])->name('list');
            Route::get('/new', [ClassroomController::class, 'create'])->name('new');
            Route::post('/new', [ClassroomController::class, 'store']);
            Route::get('/edit/{classroom}', [ClassroomController::class, 'edit'])->name('edit');
            Route::post('/edit/{classroom}', [ClassroomController::class, 'update']);
            Route::post('/delete/{classroom}', [ClassroomController::class, 'destroy'])->name('delete');
        });

        /** =======================================================================
         *      Lesson Routes
         * ======================================================================= */
        Route::group(["prefix" => "lessons", "as" => "dashboard.lessons."], function () {
            Route::get('/', [LessonController::class, 'index'])->name('list');
            Route::get('/new', [LessonController::class, 'create'])->name('new');
            Route::post('/new', [LessonController::class, 'store']);
            Route::get('/edit/{lesson}', [LessonController::class, 'edit'])->name('edit');
            Route::post('/edit/{lesson}', [LessonController::class, 'update']);
            Route::post('/delete/{lesson}', [LessonController::class, 'destroy'])->name('delete');
        });

        /** =======================================================================
         *      Question Routes
         * ======================================================================= */
        Route::group(["prefix" => "questions", "as" => "dashboard.questions."], function () {
            Route::get('/', [QuestionController::class, 'index'])->name('list');
            Route::get('/new', [QuestionController::class, 'create'])->name('new');
            Route::post('/new', [QuestionController::class, 'store']);
            Route::get('/edit/{question}', [QuestionController::class, 'edit'])->name('edit');
            Route::post('/edit/{question}', [QuestionController::class, 'update']);
            Route::post('/delete/{question}', [QuestionController::class, 'destroy'])->name('delete');
        });

        /** =======================================================================
         *      Orders Routes
         * ======================================================================= */
        Route::group(["prefix" => "order", "as" => "dashboard.order."], function () {
            Route::get('/', [OrderController::class, 'index'])->name('list');
            Route::post('/update/{order}', [OrderController::class, 'statusUpdate'])->name('update-status');
            Route::post('/delete/{order}', [OrderController::class, 'destroy'])->name('delete');
        });

        /** =======================================================================
         *      Quiz Routes
         * ======================================================================= */
        Route::group(["prefix" => "quiz", "as" => "dashboard.quiz."], function () {
            Route::get('/', [QuizController::class, 'index'])->name('list');
            Route::get('/new', [QuizController::class, 'create'])->name('new');
            Route::post('/new', [QuizController::class, 'store']);
            Route::get('/edit/{quiz}', [QuizController::class, 'edit'])->name('edit');
            Route::post('/edit/{quiz}', [QuizController::class, 'update']);
            Route::post('/delete/{quiz}', [QuizController::class, 'destroy'])->name('delete');
            Route::get('/import', [QuizImportController::class, 'quizForm'])->name('import');
            Route::post('/import', [QuizImportController::class, 'store']);
        });

        /** =======================================================================
         *      Quiz Result Routes
         * ======================================================================= */
        Route::group(["prefix" => "quiz-results", "as" => "dashboard.quizResult."], function () {
            Route::get('/', [QuizResultController::class, 'index'])->name('list');
        });

        /** =======================================================================
         *      Topic Routes
         * ======================================================================= */
        Route::group(["prefix" => "topics", "as" => "dashboard.topics."], function () {
            Route::get('/', [TopicController::class, 'index'])->name('list');
            Route::get('/new', [TopicController::class, 'create'])->name('new');
            Route::post('/new', [TopicController::class, 'store']);
            Route::get('/edit/{topic}', [TopicController::class, 'edit'])->name('edit');
            Route::post('/edit/{topic}', [TopicController::class, 'update']);
            Route::post('/delete/{topic}', [TopicController::class, 'destroy'])->name('delete');
        });

        /** =======================================================================
         *      Topic Routes
         * ======================================================================= */
        Route::group(["prefix" => "role-permission", "as" => "dashboard.role_permission."], function () {
            Route::get('/', [RolePermissionController::class, 'index'])->name('list');
            Route::get('/new', [RolePermissionController::class, 'create'])->name('new');
            Route::post('/new', [RolePermissionController::class, 'store']);
            Route::get('/edit/{role}', [RolePermissionController::class, 'edit'])->name('edit');
            Route::post('/edit/{role}', [RolePermissionController::class, 'update']);
            Route::post('/delete/{role}', [RolePermissionController::class, 'destroy'])->name('delete');
        });

        /** =======================================================================
         *      Assets Media Routes
         * ======================================================================= */
        Route::group(["prefix" => "assets", "as" => "dashboard.assets."], function () {
            Route::get('/', [AssetController::class, 'index'])->name('list');
            Route::post('/new', [AssetController::class, 'store'])->name('new');
            Route::post('/delete/{asset}', [AssetController::class, 'destroy'])->name('delete');
        });

        /** =======================================================================
         *      Faq Routes
         * ======================================================================= */
        Route::group(["prefix" => "faqs", "as" => "dashboard.faqs."], function () {
            Route::get('/', [FaqController::class, 'index'])->name('list');
            Route::post('/new', [FaqController::class, 'store'])->name('new');
            Route::post('/edit/{faq}', [FaqController::class, 'update'])->name('edit');
            Route::post('/delete/{faq}', [FaqController::class, 'destroy'])->name('delete');
        });

        /** =======================================================================
         *      Blog Routes
         * ======================================================================= */
        Route::group(["prefix" => "blogs", "as" => "dashboard.blogs."], function () {
            Route::get('/', [BlogController::class, 'index'])->name('list');
            Route::get('/new', [BlogController::class, 'create'])->name('new');
            Route::post('/new', [BlogController::class, 'store']);
            Route::get('/edit/{blog}', [BlogController::class, 'edit'])->name('edit');
            Route::post('/edit/{blog}', [BlogController::class, 'update']);
            Route::post('/delete/{blog}', [BlogController::class, 'destroy'])->name('delete');
        });

        /** =======================================================================
         *      Testimonial Routes
         * ======================================================================= */
        Route::group(["prefix" => "testimonials", "as" => "dashboard.testimonial."], function () {
            Route::get('/', [TestimonialController::class, 'index'])->name('list');
            Route::get('/new', [TestimonialController::class, 'create'])->name('new');
            Route::post('/new', [TestimonialController::class, 'store']);
            Route::get('/edit/{testimonial}', [TestimonialController::class, 'edit'])->name('edit');
            Route::post('/edit/{testimonial}', [TestimonialController::class, 'update']);
            Route::post('/delete/{testimonial}', [TestimonialController::class, 'destroy'])->name('delete');
        });

        /** =======================================================================
         *      Slider Routes
         * ======================================================================= */
        Route::group(["prefix" => "slider", "as" => "dashboard.slider."], function () {
            Route::get('/', [SliderController::class, 'index'])->name('list');
            Route::post('/new', [SliderController::class, 'store'])->name('new');
            Route::post('/edit/{slider}', [SliderController::class, 'update'])->name('edit');
            Route::post('/delete/{slider}', [SliderController::class, 'destroy'])->name('delete');

            /** =======================================================================
             *      Slider-items Routes
             * ======================================================================= */
            Route::group(["prefix" => "items", "as" => "items."], function () {
                Route::get('/{slider}', [SliderItemController::class, 'index'])->name('list');
                Route::post('/save', [SliderItemController::class, 'store'])->name('new');
                Route::post('/delete/{sliderItem}', [SliderItemController::class, 'destroy'])->name('delete');
            });
        });

        /** =======================================================================
         *      Price Plan Routes
         * ======================================================================= */
        Route::group(["prefix" => "price-plans", "as" => "dashboard.price_plans."], function () {
            Route::get('/', [PricePlanController::class, 'index'])->name('list');
            Route::post('/new', [PricePlanController::class, 'store'])->name('new');
            Route::post('/edit/{pricePlan}', [PricePlanController::class, 'update'])->name('edit');
            Route::post('/delete/{pricePlan}', [PricePlanController::class, 'destroy'])->name('delete');
        });

        /** =======================================================================
         *      Page Routes
         * ======================================================================= */
        Route::group(["prefix" => "pages", "as" => "dashboard.pages."], function () {
            Route::get('/', [PageController::class, 'index'])->name('list');
            Route::get('/new', [PageController::class, 'create'])->name('new');
            Route::post('/new', [PageController::class, 'store']);
            Route::get('/edit/{page}', [PageController::class, 'edit'])->name('edit');
            Route::post('/edit/{page}', [PageController::class, 'update']);
            Route::post('/delete/{page}', [PageController::class, 'destroy'])->name('delete');
        });

        /** =======================================================================
         *      Event Routes
         * ======================================================================= */
        Route::group(["prefix" => "events", "as" => "dashboard.event."], function () {
            Route::get('/', [EventController::class, 'index'])->name('list');
            Route::get('/new', [EventController::class, 'create'])->name('new');
            Route::post('/new', [EventController::class, 'store']);
            Route::get('/edit/{event}', [EventController::class, 'edit'])->name('edit');
            Route::post('/edit/{event}', [EventController::class, 'update']);
            Route::post('/delete/{event}', [EventController::class, 'destroy'])->name('delete');
        });
    });

    /** =======================================================================
     *      ADMIN Inner Page Settings Routes
     * ======================================================================= */
    Route::group(["prefix" => "dashboard/inner-page-settings", "as" => "dashboard.inner_page_settings."], function () {
        Route::get('login', [InnerPageController::class, 'getLoginPage'])->name('login');
        Route::post('login', [InnerPageController::class, 'saveLoginPage']);
        Route::get('forget-password', [InnerPageController::class, 'getForgetPassPage'])->name('forget_password');
        Route::post('forget-password', [InnerPageController::class, 'saveForgetPassPage']);
        Route::get('contact', [InnerPageController::class, 'getContactPage'])->name('contact');
        Route::post('contact', [InnerPageController::class, 'saveContactPage']);
        Route::get('signup', [InnerPageController::class, 'getSignUpPage'])->name('signup');
        Route::post('signup', [InnerPageController::class, 'saveSignUpPage']);
        Route::get('student-profile', [InnerPageController::class, 'getStudentProfilePage'])->name('student_profile');
        Route::post('student-profile', [InnerPageController::class, 'saveStudentProfilePage']);
        Route::get('about', [InnerPageController::class, 'getAboutPage'])->name('about');
        Route::post('about', [InnerPageController::class, 'saveAboutPage']);  
        Route::get('become-instructor', [InnerPageController::class, 'getBecomeInstructorPage'])->name('become_instructor');
        Route::post('become-instructor', [InnerPageController::class, 'saveBecomeInstructorPage']); 
        Route::get('checkout', [InnerPageController::class, 'getCheckoutPage'])->name('checkout');
        Route::post('checkout', [InnerPageController::class, 'saveCheckoutPage']); 
        Route::get('cart', [InnerPageController::class, 'getCartPage'])->name('cart');
        Route::post('cart', [InnerPageController::class, 'saveCartPage']); 
        Route::get('courses', [InnerPageController::class, 'getCoursesListPage'])->name('courses');
        Route::post('courses', [InnerPageController::class, 'saveCoursesListPage']); 
        Route::get('course-details', [InnerPageController::class, 'getCourseDetailsPage'])->name('course_details');
        Route::post('course-details', [InnerPageController::class, 'saveCourseDetailsPage']); 
        Route::get('events', [InnerPageController::class, 'getEventsListPage'])->name('events');
        Route::post('events', [InnerPageController::class, 'saveEventsListPage']); 
        Route::get('event-details', [InnerPageController::class, 'getEventDetailsPage'])->name('event_details');
        Route::post('event-details', [InnerPageController::class, 'saveEventDetailsPage']); 
        Route::get('faqs', [InnerPageController::class, 'getFaqListPage'])->name('faqs');
        Route::post('faqs', [InnerPageController::class, 'saveFaqListPage']); 
        Route::get('faq-details', [InnerPageController::class, 'getFaqDetailsPage'])->name('faq_details');
        Route::post('faq-details', [InnerPageController::class, 'saveFaqDetailsPage']); 
        Route::get('instructor-details', [InnerPageController::class, 'getInstructorDetailsPage'])->name('instructor_details');
        Route::post('instructor-details', [InnerPageController::class, 'saveInstructorDetailsPage']); 
        Route::get('instructors', [InnerPageController::class, 'getInstructorsListPage'])->name('instructors_list');
        Route::post('instructors', [InnerPageController::class, 'saveInstructorsListPage']); 
        Route::get('blogs', [InnerPageController::class, 'getBlogsPage'])->name('blogs');
        Route::post('blogs', [InnerPageController::class, 'saveBlogsPage']); 
        Route::get('blog-details', [InnerPageController::class, 'getBlogDetailsPage'])->name('blog_details');
        Route::post('blog-details', [InnerPageController::class, 'saveBlogDetailsPage']); 
        Route::get('membership', [InnerPageController::class, 'getMembershipPage'])->name('membership');
        Route::post('membership', [InnerPageController::class, 'saveMembershipPage']);
        Route::get('wishlist', [InnerPageController::class, 'getWishlistPage'])->name('wishlist');
        Route::post('wishlist', [InnerPageController::class, 'saveWishlistPage']);
        Route::get('thankyou', [InnerPageController::class, 'getThankyouPage'])->name('thankyou');
        Route::post('thankyou', [InnerPageController::class, 'saveThankyouPage']);
        Route::get('failed-payment', [InnerPageController::class, 'getFailedPaymentPage'])->name('failed-payment');
        Route::post('failed-payment', [InnerPageController::class, 'saveFailedPaymentPage']);
        Route::get('error-404', [InnerPageController::class, 'get404Page'])->name('error_404');
        Route::post('error-404', [InnerPageController::class, 'save404Page']);
    });

    /** =======================================================================
     *      ADMIN Site Settings Routes
     * ======================================================================= */
    Route::group(["prefix" => "dashboard/site-settings", "as" => "dashboard.site_settings."], function () {
        Route::get('header', [SiteSettingsController::class, 'siteSettingHeader'])->name('header');
        Route::post('header', [SiteSettingsController::class, 'siteSettingHeaderSave']);
        Route::get('footer', [SiteSettingsController::class, 'siteSettingFooter'])->name('footer');
        Route::post('footer', [SiteSettingsController::class, 'siteSettingFooterSave']);
        
    });

    /** =======================================================================
     *      ADMIN Settings Routes
     * ======================================================================= */
    Route::group(["prefix" => "dashboard/settings", "as" => "dashboard.settings."], function () {
        /** =======================================================================
         *      Menu Routes
         * ======================================================================= */
        Route::group(["prefix" => "menus", "as" => "menus."], function () {
            Route::get('/', [MenuController::class, 'index'])->name('list');
            Route::post('/new', [MenuController::class, 'store'])->name('new');
            Route::post('/edit/{menu}', [MenuController::class, 'update'])->name('edit');
            Route::post('/delete/{menu}', [MenuController::class, 'destroy'])->name('delete');
        });

        /** =======================================================================
         *      Page Settings Routes
         * ======================================================================= */
        Route::group(["prefix" => "page", "as" => "page."], function () {
            /** =======================================================================
             *      Homepage 01 Settings Routes
             * ======================================================================= */
            Route::group(["prefix" => "home-01", "as" => "home-01."], function () {
                Route::get('header', [HomepageSettingsController::class, 'homeOneHeader'])->name('header');
                Route::post('header', [HomepageSettingsController::class, 'homeOneHeaderSave']);

                Route::get('categories', [HomepageSettingsController::class, 'homeOneCategoriesPage'])->name('categories');
                Route::post('categories', [HomepageSettingsController::class, 'homeOneCategoriesPageSave']);

                Route::get('course', [HomepageSettingsController::class, 'homeOneCoursePage'])->name('course');
                Route::post('course', [HomepageSettingsController::class, 'homeOneCoursePageSave']);

                Route::get('features', [HomepageSettingsController::class, 'homeOneFeaturesPage'])->name('features');
                Route::post('features', [HomepageSettingsController::class, 'homeOneFeaturesPageSave']);

                Route::get('about-us', [HomepageSettingsController::class, 'homeOneAboutPage'])->name('about-us');
                Route::post('about-us', [HomepageSettingsController::class, 'homeOneAboutPageSave']);

                Route::get('testimonial', [HomepageSettingsController::class, 'homeOneTestimonialPage'])->name('testimonial');
                Route::post('testimonial', [HomepageSettingsController::class, 'homeOneTestimonialPageSave']);

                Route::get('cta-01', [HomepageSettingsController::class, 'homeOneCTAOnePage'])->name('cta-01');
                Route::post('cta-01', [HomepageSettingsController::class, 'homeOneCTAOnePageSave']);

                Route::get('cta-02', [HomepageSettingsController::class, 'homeOneCTATwoPage'])->name('cta-02');
                Route::post('cta-02', [HomepageSettingsController::class, 'homeOneCTATwoPageSave']);

                Route::get('brand', [HomepageSettingsController::class, 'homeOneBrandPage'])->name('brand');
                Route::post('brand', [HomepageSettingsController::class, 'homeOneBrandPageSave']);

                

                // Route::get('/', [HomepageSettingsController::class, 'homeOneSettingsPage'])->name('list');
                // Route::post('/save', [HomepageSettingsController::class, 'homeOneSettingsStore'])->name('save');
            });
            /** =======================================================================
             *      Homepage 02 Settings Routes
             * ======================================================================= */
            Route::group(["prefix" => "home-02", "as" => "home-02."], function () {
                // Route::get('/', [HomepageSettingsController::class, 'index'])->name('list');
                // Route::post('/save', [HomepageSettingsController::class, 'store'])->name('save');

                Route::get("header", [HomepageSettingsController::class, "homeTwoHeaderPage"])->name("header");
                Route::post("header", [HomepageSettingsController::class, "homeTwoHeaderPageSave"]);

                Route::get("stats", [HomepageSettingsController::class, "homeTwoStatsPage"])->name("stats");
                Route::post("stats", [HomepageSettingsController::class, "homeTwoStatsPageSave"]);

                Route::get("cta_01", [HomepageSettingsController::class, "homeTwoCtaOnePage"])->name("cta_01");
                Route::post("cta_01", [HomepageSettingsController::class, "homeTwoCtaOnePageSave"]);

                Route::get("categories", [HomepageSettingsController::class, "homeTwoCategoriesPage"])->name("categories");
                Route::post("categories", [HomepageSettingsController::class, "homeTwoCategoriesPageSave"]);

                Route::get("course", [HomepageSettingsController::class, "homeTwoCoursePage"])->name("course");
                Route::post("course", [HomepageSettingsController::class, "homeTwoCoursePageSave"]);

                Route::get('partners', [HomepageSettingsController::class, 'getHomeTwoPartners'])->name('partners');
                Route::post('partners', [HomepageSettingsController::class, 'saveHomeTwoPartners']);

                Route::get("features", [HomepageSettingsController::class, "homeTwoFeaturesPage"])->name("features");
                Route::post("features", [HomepageSettingsController::class, "homeTwoFeaturesPageSave"]);

                Route::get("cta_02", [HomepageSettingsController::class, "homeTwoCtaTwoPage"])->name("cta_02");
                Route::post("cta_02", [HomepageSettingsController::class, "homeTwoCtaTwoPageSave"]);

                Route::get("cta_03", [HomepageSettingsController::class, "homeTwoCtaThreePage"])->name("cta_03");
                Route::post("cta_03", [HomepageSettingsController::class, "homeTwoCtaThreePageSave"]);

                Route::get("cta_04", [HomepageSettingsController::class, "homeTwoCtaFourPage"])->name("cta_04");
                Route::post("cta_04", [HomepageSettingsController::class, "homeTwoCtaFourPageSave"]);

                Route::get("blog", [HomepageSettingsController::class, "homeTwoBlogPage"])->name("blog");
                Route::post("blog", [HomepageSettingsController::class, "homeTwoBlogPageSave"]);

            });

            /** =======================================================================
             *      Homepage 03 Settings Routes
             * ======================================================================= */
            Route::group(["prefix" => "home-03", "as" => "home-03."], function () {
                Route::get("header", [Homepage3SettingsController::class, "homeThreeHeaderPage"])->name("header");
                Route::post("header", [Homepage3SettingsController::class, "homeThreeHeaderPageSave"]);

                Route::get("course-overview", [Homepage3SettingsController::class, "homeThreeCourseOverview"])->name("course-overview");
                Route::post("course-overview", [Homepage3SettingsController::class, "homeThreeCourseOverviewSave"]);

                Route::get("welcome-message", [Homepage3SettingsController::class, "homeThreeWelcomeMessagePage"])->name("welcome-message");
                Route::post("welcome-message", [Homepage3SettingsController::class, "homeThreeWelcomeMessagePageSave"]);

                Route::get("about", [Homepage3SettingsController::class, "homeThreeAboutPage"])->name("about");
                Route::post("about", [Homepage3SettingsController::class, "homeThreeAboutPageSave"]);
                
                Route::get("stats", [Homepage3SettingsController::class, "homeThreeStatsPage"])->name("stats");
                Route::post("stats", [Homepage3SettingsController::class, "homeThreeStatsPageSave"]);

                Route::get("insta-images-more-titles", [Homepage3SettingsController::class, "homeThreeInstaImagesTitlesPage"])->name("insta-images-more-titles");
                Route::post("insta-images-more-titles", [Homepage3SettingsController::class, "homeThreeInstaImagesTitlesPageSave"]);

                Route::get("course", [Homepage3SettingsController::class, "homeThreeCoursePage"])->name("course");
                Route::post("course", [Homepage3SettingsController::class, "homeThreeCoursePageSave"]);
            });
        });
    });

   // Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

   // Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
      //          ->name('logout');
});

require __DIR__.'/auth.php';
