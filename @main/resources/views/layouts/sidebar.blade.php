<div class="eduman-dashboard-sidebar">
    <div class=" eduman-menu-wrapper bg-white border-r border-b border-solid border-grayBorder py-6 px-7 maxLg:px-5 maxLg:py-6">
        <div>
            <div class="eduman-header-profile relative pl-5 flex flex-wrap items-center maxMd:pr-0 mb-7">
                <div class="eduman-header-profile-img w-12 maxSm:mr-0 md:mr-0 cursor-pointer">
                    <a href="{{ url('/dashboard/users/edit/'. Auth::user()->id) }}" class="rounded-[50%] overflow-hidden block">
                        <img src="{{ asset('assets/admin/img/icon/watson.png') }}" class="object-cover" alt="profile not found" />
                    </a>
                </div>
                <div class="eduman-header-profile-info pl-2.5 cursor-pointer">
                    <div>
                        <a class="text-[15px] font-bold text-heading cursor-pointer" href="{{ url('/dashboard/users/edit/'. Auth::user()->id) }}">
                            {{ Auth::user()->first_name }} <span class="text-[10px] font-bold leading-none pt-0.5 pb-[1px] px-1 border border-solid border-[#FFC403] text-[#FFC403] inline-block ml-2 uppercase rounded-[3px]">{{ __('Pro') }}</span>
                        </a>
                    </div>
                    <span class="text-[13px] font-normal text-bodyText cursor-pointer">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                </div>
            </div>
            <div class="eduman-menu px-0.5">
                <ul id="metismenu">
                    <li class="@if (request()->is("dashboard")) mm-active @endif">
                        <a href="{{ route('dashboard') }}">
                            <i class="far fa-home"></i>{{ __("Dashboard") }}
                        </a>
                    </li>
    
                    <li class="@if (request()->is("dashboard/assets")) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="far fa-image-polaroid"></i>{{ __('Media') }}
                        </a>
                        <ul class="@if (request()->is("dashboard/assets")) mm-show @endif">
                            <li class="@if (request()->is("dashboard/assets")) child-mm-active @endif">
                                <a href="{{ route('dashboard.assets.list') }}">{{ __('media Files') }}</a>
                            </li>
                        </ul>
                    </li>
                    <li class="@if (request()->is(["dashboard/categories", "dashboard/categories/*" ])) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="far fa-books"></i>{{ __("Categories") }}
                        </a>
                        <ul class="@if (request()->is(["dashboard/categories", "dashboard/categories/*" ])) mm-show @endif">
                            <li class="@if (request()->is("dashboard/categories")) child-mm-active @endif">
                                <a href="{{ route('dashboard.category.list') }}">{{ __('All Categories') }}</a>
                            </li>
                        </ul>
                    </li>
                    <li class="@if (request()->is(["dashboard/courses", "dashboard/courses/*", "dashboard/course/*"])) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="far fa-book"></i>{{ __("Courses") }}
                        </a>
                        <ul class="@if (request()->is(["dashboard/courses", "dashboard/courses/*",  "dashboard/course/*"])) mm-show @endif">
                            <li class="@if (request()->is("dashboard/courses/list")) child-mm-active @endif">
                                <a href="{{ route('dashboard.courses.list') }}">{{ __('All Courses') }}</a>
                            </li>
                            <li class="@if (request()->is("dashboard/course/add")) child-mm-active @endif">
                                <a href="{{ route('dashboard.course.add') }}">{{ __('New Course') }}</a>
                            </li>
                        </ul>
                    </li>

                    <li class="@if (request()->is(["dashboard/course-reviews", "dashboard/course-reviews/*"])) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="far fa-comment-alt"></i>{{ __("Course Reviews") }}
                        </a>
                        <ul class="@if (request()->is(["dashboard/course-reviews", "dashboard/course-reviews/*" ])) mm-show @endif">
                            <li class="@if (request()->is("dashboard/course-reviews")) child-mm-active @endif">
                                <a href="{{ route('dashboard.courseReview.list') }}">{{ __('All Course Reviews') }}</a>
                            </li>
                            <li class="@if (request()->is("dashboard/course-reviews/new")) child-mm-active @endif">
                                <a href="{{ route('dashboard.courseReview.new') }}">{{ __('New Course Reviews') }}</a>
                            </li>
                        </ul>
                    </li>

                    <li class="@if (request()->is(["dashboard/course-authors", "dashboard/course-authors/*" ])) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="far fa-user-graduate"></i>{{ __("Course Authors") }}
                        </a>
                        <ul class="@if (request()->is(["dashboard/course-authors", "dashboard/course-authors/*" ])) mm-show @endif">
                            <li class="@if (request()->is("dashboard/course-authors")) child-mm-active @endif">
                                <a href="{{ route('dashboard.courseAuthor.list') }}">{{ __('All Course Authors') }}</a>
                            </li>
                            <li class="@if (request()->is("dashboard/course-authors/new")) child-mm-active @endif">
                                <a href="{{ route('dashboard.courseAuthor.new') }}">{{ __('Add Course Author') }}</a>
                            </li>
                        </ul>
                    </li>

                    <li class="@if (request()->is(["dashboard/course-category", "dashboard/course-category/*" ])) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="far fa-books"></i>{{ __("Course Category") }}
                        </a>
                        <ul class="@if (request()->is(["dashboard/course-category", "dashboard/course-category/*" ])) mm-show @endif">
                            <li class="@if (request()->is("dashboard/course-category")) child-mm-active @endif">
                                <a href="{{ route('dashboard.courseCategory.list') }}">{{ __('All Course Category') }}</a>
                            </li>
                            <li class="@if (request()->is("dashboard/course-category/new")) child-mm-active @endif">
                                <a href="{{ route('dashboard.courseCategory.new') }}">{{ __('New Course Category') }}</a>
                            </li>
                        </ul>
                    </li>

                    <li class="@if (request()->is(["dashboard/authors", "dashboard/authors/*"])) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="far fa-user-graduate"></i>{{ __('Author') }}
                        </a>
                        <ul class="@if (request()->is([" dashboard/authors", "dashboard/authors/*" ])) mm-show @endif">
                            <li class="@if (request()->is("dashboard/authors")) child-mm-active @endif">
                                <a href="{{ route('dashboard.authors.list') }}">{{ __('All Authors') }}</a>
                            </li>
                        </ul>
                    </li>
                    <li class="@if (request()->is(["dashboard/users", "dashboard/users/*" ])) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="far fa-user"></i>{{ __('User') }}
                        </a>
                        <ul class="@if (request()->is(["dashboard/users/*", "dashboard/users" ])) mm-show @endif">
                            <li class="@if (request()->is("dashboard/users")) child-mm-active @endif">
                                <a href="{{ route('dashboard.users.list') }}">{{ __('All Users') }}</a>
                            </li>
                        </ul>
                    </li>
                    <li class="@if (request()->is(["dashboard/students", "dashboard/students/*" ])) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="far fa-users-class"></i>{{ __('Student') }}
                        </a>
                        <ul class="@if (request()->is(["dashboard/students/*", "dashboard/students" ])) mm-show @endif">
                            <li class="@if (request()->is("dashboard/students")) child-mm-active @endif">
                                <a href="{{ route('dashboard.students.list') }}">{{ __('All Students') }}</a>
                            </li>
                        </ul>
                    </li>

                    <li class="@if (request()->is(["dashboard/order", "dashboard/order/*" ])) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="fab fa-first-order"></i>{{ __('Orders') }}
                        </a>
                        <ul class="@if (request()->is(["dashboard/order", "dashboard/order/*" ])) mm-show @endif">
                            <li class="@if (request()->is("dashboard/order")) child-mm-active @endif">
                                <a href="{{ route('dashboard.order.list') }}">{{ __('All Orders') }}</a>
                            </li>
                        </ul>
                    </li>

                    <li class="@if (request()->is(["dashboard/lessons", "dashboard/lessons/*" ])) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="far fa-file-pdf"></i>{{ __('Lesson') }}
                        </a>
                        <ul class="@if (request()->is([" dashboard/lessons", "dashboard/lessons/*" ])) mm-show @endif">
                            <li class="@if (request()->is("dashboard/lessons")) child-mm-active @endif">
                                <a href="{{ route('dashboard.lessons.list') }}">{{ __('All Lessons') }}</a>
                            </li>
                            <li class="@if (request()->is("dashboard/lessons/new")) child-mm-active @endif">
                                <a href="{{ route('dashboard.lessons.new') }}">{{ __('New Lesson') }}</a>
                            </li>
                        </ul>
                    </li>

                    <li class="@if (request()->is(["dashboard/questions", "dashboard/questions/*" ])) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="far fa-question-square"></i>{{ __('Question') }}
                        </a>
                        <ul class="@if (request()->is(["dashboard/questions", "dashboard/questions/*" ])) mm-show @endif">
                            <li class="@if (request()->is("dashboard/questions")) child-mm-active @endif">
                                <a href="{{ route('dashboard.questions.list') }}">{{ __('All Question') }}</a>
                            </li>
                            <li class="@if (request()->is("dashboard/questions/new")) child-mm-active @endif">
                                <a href="{{ route('dashboard.questions.new') }}">{{ __('New Question') }}</a>
                            </li>
                        </ul>
                    </li>

                    <li class="@if (request()->is(["dashboard/quiz", "dashboard/quiz/*" ])) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="far fa-question-circle"></i>{{ __('Quizzes') }}
                        </a>
                        <ul class="@if (request()->is(["dashboard/quiz", "dashboard/quiz/*" ])) mm-show @endif">
                            <li class="@if (request()->is("dashboard/quiz")) child-mm-active @endif">
                                <a href="{{ route('dashboard.quiz.list') }}">{{ __('All Quizzes') }}</a>
                            </li>
                            <li class="@if (request()->is("dashboard/quiz/new")) child-mm-active @endif">
                                <a href="{{ route('dashboard.quiz.new') }}">{{ __('New Quiz') }}</a>
                            </li>
                            <li class="@if (request()->is("dashboard/quiz/import")) child-mm-active @endif">
                                <a href="{{ route('dashboard.quiz.import') }}">{{ __('Import Quiz') }}</a>
                            </li>
                        </ul>
                    </li>

                    <li class="@if (request()->is(["dashboard/quiz-results", "dashboard/quiz-results/*" ])) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="far fa-award"></i>{{ __('Quiz results') }}
                        </a>
                        <ul class="@if (request()->is([" dashboard/quiz-results", "dashboard/quiz-results/*" ])) mm-show @endif">
                            <li class="@if (request()->is("dashboard/quiz-results")) child-mm-active @endif">
                                <a href="{{ route('dashboard.quizResult.list') }}">{{ __('All Quiz results') }}</a>
                            </li>
                        </ul>
                    </li>

                    <li class="@if (request()->is(["dashboard/classrooms", "dashboard/classrooms/*" ])) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="far fa-users-class"></i>{{ __('Classroom') }}
                        </a>
                        <ul class="@if (request()->is(["dashboard/classrooms", "dashboard/classrooms/*" ])) mm-show @endif">
                            <li class="@if (request()->is("dashboard/classrooms")) child-mm-active @endif">
                                <a href="{{ route('dashboard.classrooms.list') }}">{{ __('All Classrooms') }}</a>
                            </li>
                            <li class="@if (request()->is("dashboard/classrooms/new")) child-mm-active @endif">
                                <a href="{{ route('dashboard.classrooms.new') }}">{{ __('New Classroom') }}</a>
                            </li>
                        </ul>
                    </li>

                    <li class="@if (request()->is(["dashboard/topics", "dashboard/topics/*" ])) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="fab fa-readme"></i>{{ __('Topics') }}
                        </a>
                        <ul class="@if (request()->is(["dashboard/topics", "dashboard/topics/*" ])) mm-show @endif">
                            <li class="@if (request()->is("dashboard/topics")) child-mm-active @endif">
                                <a href="{{ route('dashboard.topics.list') }}">{{ __('All Topics') }}</a>
                            </li>
                            <li class="@if (request()->is("dashboard/topics/new")) child-mm-active @endif">
                                <a href="{{ route('dashboard.topics.new') }}">{{ __('New Topics') }}</a>
                            </li>
                        </ul>
                    </li>
                    <li class="@if (request()->is("dashboard/settings/menus")) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="far fa-street-view"></i>{{ __('Menu') }}
                        </a>
                        <ul class="@if (request()->is("dashboard/settings/menus")) mm-show @endif">
                            <li class="@if (request()->is("dashboard/settings/menus")) child-mm-active @endif">
                                <a href="{{ route('dashboard.settings.menus.list') }}">{{ __('All Menus') }}</a>
                            </li>
                        </ul>
                    </li>
                    <li class="@if (request()->is("dashboard/faqs")) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="far fa-question-square"></i>{{ __('FAQ') }}
                        </a>
                        <ul class="@if (request()->is("dashboard/faqs")) mm-show @endif">
                            <li class="@if (request()->is("dashboard/faqs")) child-mm-active @endif">
                                <a href="{{ route('dashboard.faqs.list') }}">{{ __('All FAQs') }}</a>
                            </li>
                        </ul>
                    </li>
                    <li class="@if (request()->is(["dashboard/blogs", "dashboard/blogs/*" , "dashboard/blog-categories"])) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="far fa-newspaper"></i>{{ __('Blog') }}
                        </a>
                        <ul class="@if (request()->is(["dashboard/blogs", "dashboard/blogs/*" , "dashboard/blog-categories"])) mm-show @endif">
                            <li class="@if (request()->is("dashboard/blogs")) child-mm-active @endif">
                                <a href="{{ route('dashboard.blogs.list') }}">{{ __('All Blogs') }}</a>
                            </li>
                            <li class="@if (request()->is("dashboard/blogs-cat")) child-mm-active @endif">
                                <a href="{{ route('dashboard.category.list') }}">{{ __('All Categories') }}</a>
                            </li>
                        </ul>
                    </li>
                    <li class="@if (request()->is("dashboard/price-plans")) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="far fa-usd-square"></i>{{ __('Price Plan') }}
                        </a>
                        <ul class="@if (request()->is("dashboard/price-plans")) mm-show @endif">
                            <li class="@if (request()->is("dashboard/price-plans")) child-mm-active @endif">
                                <a href="{{ route('dashboard.price_plans.list') }}">{{ __('All Price Plans') }}</a>
                            </li>
                        </ul>
                    </li>
                    <li class="@if (request()->is(["dashboard/pages", "dashboard/pages/*"])) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="far fa-pager"></i>{{ __('Page') }}
                        </a>
                        <ul class="@if (request()->is("dashboard/pages")) mm-show @endif">
                            <li class="@if (request()->is("dashboard/pages")) child-mm-active @endif">
                                <a href="{{ route('dashboard.pages.list') }}">{{ __('All Pages') }}</a>
                            </li>
                        </ul>
                    </li>

                    <li class="@if (request()->is("dashboard/events", "dashboard/events/*" )) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="far fa-calendar-star"></i>{{ __('Event') }}
                        </a>
                        <ul class="@if (request()->is("dashboard/events", "dashboard/events/*" )) mm-show @endif">
                            <li class="@if (request()->is("dashboard/events")) child-mm-active @endif">
                                <a href="{{ route('dashboard.event.list') }}">{{ __('All Events') }}</a>
                            </li>
                            <li class="@if (request()->is("dashboard/events/cat")) child-mm-active @endif">
                                <a href="{{ route('dashboard.category.list') }}">{{ __('All Categories') }}</a>
                            </li>
                        </ul>
                    </li>

                    {{-- page settings --}}
                    <li class="@if (request()->is("dashboard/settings/page", "dashboard/settings/page/*" )) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="far fa-pager"></i>{{ __('Page Settings') }}
                        </a>
                        <ul class="@if (request()->is("dashboard/settings/page/home-01", "dashboard/settings/page/home-01/*" )) mm-show @endif">
                            <li class="@if (request()->is("dashboard/settings/page/home-01", "dashboard/settings/page/home-01/*" )) mm-active @endif">
                                <a href="javascript:void(0)" class="has-arrow">
                                    {{ __('Home Page 01') }}
                                </a>
                                <ul class="@if (request()->is(" dashboard/settings/page/home-01", "dashboard/settings/page/home-01/*" )) mm-show @endif">
                                    <li class="@if (request()->is("dashboard/settings/page/home-01/header")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-01.header") }}">{{ __("Header") }}</a></li>
                                    <li class="@if (request()->is("dashboard/settings/page/home-01/categories")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-01.categories") }}">{{ __("Categories") }}</a></li>
                                    <li class="@if (request()->is("dashboard/settings/page/home-01/course")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-01.course") }}">{{ __("Course") }}</a></li>
                                    <li class="@if (request()->is("dashboard/settings/page/home-01/features")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-01.features") }}">{{ __("Features") }}</a></li>
                                    <li class="@if (request()->is("dashboard/settings/page/home-01/about-us")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-01.about-us") }}">{{ __("About Us") }}</a></li>
                                    <li class="@if (request()->is("dashboard/settings/page/home-01/testimonial")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-01.testimonial") }}">{{ __("Testimonial") }}</a></li>
                                    <li class="@if (request()->is("dashboard/settings/page/home-01/cta-01")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-01.cta-01") }}">{{ __("Call-to-Action 01") }}</a></li>
                                    <li class="@if (request()->is("dashboard/settings/page/home-01/cta-02")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-01.cta-02") }}">{{ __("Call-to-Action 02") }}</a></li>
                                    <li class="@if (request()->is("dashboard/settings/page/home-01/brand")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-01.brand") }}">{{ __("Brand") }}</a></li>
                                </ul>
                            </li>
                            <li class="@if (request()->is("dashboard/settings/page/home-02", "dashboard/settings/page/home-02/*" )) mm-active @endif">
                                <a href="javascript:void(0)" class="has-arrow">
                                    {{ __('Home Page 02') }}
                                </a>
                                <ul class="@if (request()->is("dashboard/settings/page/home-02", "dashboard/settings/page/home-02/*" )) mm-show @endif">
                                    <li class="@if (request()->is("dashboard/settings/page/home-02/header")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-02.header") }}">{{ __("Header") }}</a></li>
                                    <li class="@if (request()->is("dashboard/settings/page/home-02/stats")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-02.stats") }}">{{ __("Stats") }}</a></li>
                                    <li class="@if (request()->is("dashboard/settings/page/home-02/cta_01")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-02.cta_01") }}">{{ __("Call-to-Action 01") }}</a></li>
                                    <li class="@if (request()->is("dashboard/settings/page/home-02/categories")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-02.categories") }}">{{ __("Categories") }}</a></li>
                                    <li class="@if (request()->is("dashboard/settings/page/home-02/course")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-02.course") }}">{{ __("Course") }}</a></li>
                                    <li class="@if (request()->is("dashboard/settings/page/home-02/partners")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-02.partners") }}">{{ __("Partners") }}</a></li>
                                    <li class="@if (request()->is("dashboard/settings/page/home-02/features")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-02.features") }}">{{ __("Features") }}</a></li>
                                    <li class="@if (request()->is("dashboard/settings/page/home-02/cta_02")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-02.cta_02") }}">{{ __("Call-to-Action 02") }}</a></li>
                                    <li class="@if (request()->is("dashboard/settings/page/home-02/cta_03")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-02.cta_03") }}">{{ __("Call-to-Action 03") }}</a></li>
                                    <li class="@if (request()->is("dashboard/settings/page/home-02/cta_04")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-02.cta_04") }}">{{ __("Call-to-Action 04") }}</a></li>
                                </ul>
                            </li>
                            <li class="@if (request()->is("dashboard/settings/page/home-03", "dashboard/settings/page/home-03/*" )) mm-active @endif">
                                <a href="javascript:void(0)" class="has-arrow">
                                    {{ __('Home Page 03') }}
                                </a>
                                <ul class="@if (request()->is("dashboard/settings/page/home-03", "dashboard/settings/page/home-03/*" )) mm-show @endif">
                                    <li class="@if (request()->is("dashboard/settings/page/home-03/header")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-03.header") }}">{{ __("Header") }}</a></li>
                                    <li class="@if (request()->is("dashboard/settings/page/home-03/course-overview")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-03.course-overview") }}">{{ __("Course Overview") }}</a></li>
                                    <li class="@if (request()->is("dashboard/settings/page/home-03/welcome-message")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-03.welcome-message") }}">{{ __("Welcome Messages") }}</a></li>
                                    <li class="@if (request()->is("dashboard/settings/page/home-03/stats")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-03.stats") }}">{{ __("Stats") }}</a></li>
                                    <li class="@if (request()->is("dashboard/settings/page/home-03/course")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-03.course") }}">{{ __("Course") }}</a></li>
                                    <li class="@if (request()->is("dashboard/settings/page/home-03/about")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-03.about") }}">{{ __("About Info") }}</a></li>
                                    <li class="@if (request()->is("dashboard/settings/page/home-03/insta-images-more-titles")) child-mm-active @endif"><a href="{{ route("dashboard.settings.page.home-03.insta-images-more-titles") }}">{{ __("Insta. Images & More Titles") }}</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    {{-- Site settings --}}
                    <li class="@if (request()->is("dashboard/site-settings", "dashboard/site-settings/*" )) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="far fa-pager"></i>{{ __('Site Settings') }}
                        </a>
                        <ul class="@if (request()->is("dashboard/site-settings", "dashboard/site-settings/*" )) mm-show @endif">
                            <li class="@if (request()->is("dashboard/site-settings", "dashboard/site-settings/*" )) mm-active @endif">
                                <a href="javascript:void(0)" class="has-arrow">
                                    {{ __('Entire Website') }}
                                </a>
                                <ul class="@if (request()->is("dashboard/site-settings", "dashboard/site-settings/*" )) mm-show @endif">
                                    <li class="@if (request()->is("dashboard/site-settings/header")) child-mm-active @endif"><a href="{{ route("dashboard.site_settings.header") }}">{{ __("Header") }}</a></li>
                                    <li class="@if (request()->is("dashboard/site-settings/footer")) child-mm-active @endif"><a href="{{ route("dashboard.site_settings.footer") }}">{{ __("Footer") }}</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    {{-- Inner page settings --}}
                    <li class="@if (request()->is("dashboard/inner-page-settings", "dashboard/inner-page-settings/*" )) mm-active @endif">
                        <a href="javascript:void(0)" class="has-arrow">
                            <i class="far fa-pager"></i>{{ __('Inner page Settings') }}
                        </a>
                        <ul class="@if (request()->is("dashboard/inner-page-settings", "dashboard/inner-page-settings/*" )) mm-show @endif">
                            <li class="@if (request()->is("dashboard/inner-page-settings", "dashboard/inner-page-settings/*" )) mm-active @endif">
                                <a href="javascript:void(0)" class="has-arrow">
                                    {{ __('Inner page Settings') }}
                                </a>
                                <ul class="@if (request()->is("dashboard/inner-page-settings", "dashboard/inner-page-settings/*" )) mm-show @endif">
                                    <li class="@if (request()->is("dashboard/inner-page-settings/login")) child-mm-active @endif"><a href="{{ route("dashboard.inner_page_settings.login") }}">{{ __("Login page") }}</a></li>
                                    <li class="@if (request()->is("dashboard/inner-page-settings/forget-password")) child-mm-active @endif"><a href="{{ route("dashboard.inner_page_settings.forget_password") }}">{{ __("Forget Password page") }}</a></li>
                                    <li class="@if (request()->is("dashboard/inner-page-settings/signup")) child-mm-active @endif"><a href="{{ route("dashboard.inner_page_settings.signup") }}">{{ __("Sign Up page") }}</a></li>
                                    <li class="@if (request()->is("dashboard/inner-page-settings/contact")) child-mm-active @endif"><a href="{{ route("dashboard.inner_page_settings.contact") }}">{{ __("Contact page") }}</a></li>
                                    <li class="@if (request()->is("dashboard/inner-page-settings/student-profile")) child-mm-active @endif"><a href="{{ route("dashboard.inner_page_settings.student_profile") }}">{{ __("Student profile page") }}</a></li>
                                    <li class="@if (request()->is("dashboard/inner-page-settings/about")) child-mm-active @endif"><a href="{{ route("dashboard.inner_page_settings.about") }}">{{ __("About page") }}</a></li>
                                    <li class="@if (request()->is("dashboard/inner-page-settings/become-instructor")) child-mm-active @endif"><a href="{{ route("dashboard.inner_page_settings.become_instructor") }}">{{ __("Become Instructor page") }}</a></li>
                                    <li class="@if (request()->is("dashboard/inner-page-settings/instructors")) child-mm-active @endif"><a href="{{ route("dashboard.inner_page_settings.instructors_list") }}">{{ __("Instructors List page") }}</a></li>
                                    <li class="@if (request()->is("dashboard/inner-page-settings/instructor-details")) child-mm-active @endif"><a href="{{ route("dashboard.inner_page_settings.instructor_details") }}">{{ __("Instructor Details page") }}</a></li>
                                    <li class="@if (request()->is("dashboard/inner-page-settings/checkout")) child-mm-active @endif"><a href="{{ route("dashboard.inner_page_settings.checkout") }}">{{ __("Checkout page") }}</a></li>
                                    <li class="@if (request()->is("dashboard/inner-page-settings/cart")) child-mm-active @endif"><a href="{{ route("dashboard.inner_page_settings.cart") }}">{{ __("Cart page") }}</a></li>
                                    <li class="@if (request()->is("dashboard/inner-page-settings/courses")) child-mm-active @endif"><a href="{{ route("dashboard.inner_page_settings.courses") }}">{{ __("Courses page") }}</a></li>
                                    <li class="@if (request()->is("dashboard/inner-page-settings/course-details")) child-mm-active @endif"><a href="{{ route("dashboard.inner_page_settings.course_details") }}">{{ __("Course Details page") }}</a></li>
                                    <li class="@if (request()->is("dashboard/inner-page-settings/events")) child-mm-active @endif"><a href="{{ route("dashboard.inner_page_settings.events") }}">{{ __("Events page") }}</a></li>
                                    <li class="@if (request()->is("dashboard/inner-page-settings/event-details")) child-mm-active @endif"><a href="{{ route("dashboard.inner_page_settings.event_details") }}">{{ __("Event Details page") }}</a></li>
                                    <li class="@if (request()->is("dashboard/inner-page-settings/blogs")) child-mm-active @endif"><a href="{{ route("dashboard.inner_page_settings.blogs") }}">{{ __("Blogs page") }}</a></li>
                                    <li class="@if (request()->is("dashboard/inner-page-settings/blog-details")) child-mm-active @endif"><a href="{{ route("dashboard.inner_page_settings.blog_details") }}">{{ __("Blog Details page") }}</a></li>
                                    <li class="@if (request()->is("dashboard/inner-page-settings/faqs")) child-mm-active @endif"><a href="{{ route("dashboard.inner_page_settings.faqs") }}">{{ __("Faqs page") }}</a></li>
                                    <li class="@if (request()->is("dashboard/inner-page-settings/faq-details")) child-mm-active @endif"><a href="{{ route("dashboard.inner_page_settings.faq_details") }}">{{ __("Faq Details page") }}</a></li>
                                    <li class="@if (request()->is("dashboard/inner-page-settings/membership")) child-mm-active @endif"><a href="{{ route("dashboard.inner_page_settings.membership") }}">{{ __("Membership page") }}</a></li>
                                    <li class="@if (request()->is("dashboard/inner-page-settings/thankyou")) child-mm-active @endif"><a href="{{ route("dashboard.inner_page_settings.thankyou") }}">{{ __("Thank you page") }}</a></li>
                                    <li class="@if (request()->is("dashboard/inner-page-settings/failed-payment")) child-mm-active @endif"><a href="{{ route("dashboard.inner_page_settings.failed-payment") }}">{{ __("Failed Payment page") }}</a></li>
                                    <li class="@if (request()->is("dashboard/inner-page-settings/wishlist")) child-mm-active @endif"><a href="{{ route("dashboard.inner_page_settings.wishlist") }}">{{ __("Wishlist page") }}</a></li>
                                    <li class="@if (request()->is("dashboard/inner-page-settings/error-404")) child-mm-active @endif"><a href="{{ route("dashboard.inner_page_settings.error_404") }}">{{ __("404 page") }}</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    {{-- Administrative Tools --}}
                    <li class="@if (request()->is('dashboard/role-permission')) mm-active @endif">
                        <a href="{{ route("dashboard.role_permission.list") }}">
                            <i class="far fa-tools"></i>{{ __("Administrative Tools") }}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="eduman-logo text-center h-[200px] w-full flex flex-col justify-center items-center bg-[#F6F8FC] px-5 rounded-lg mt-[10px]">
                <a href="{{ route("dashboard") }}" class="inline-block"><img src="{{ asset('assets/admin/img/logo/logo.svg') }}" alt="{{ __('logo not found') }}"></a>
            </div>
        </div>
    </div>
    <div class="eduman-menu-overlay eduman-menu-overlay-dashboard"></div>
</div>