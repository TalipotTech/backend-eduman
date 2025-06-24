<x-app-layout>
<div class="eduman-dashboard-main">
@include('layouts.navigation')
  <div class="eduman-breadcrumb-area px-7 py-9 bg-white mb-5 hidden">
    <div class="eduman-breadcrumb-area-inner px-0.5">
      <h5 class="text-[20px] text-heading font-bold mb-3 leading-none">{{ __('Dashboard') }}</h5>
      <span class="text-[14px] text-bodyText font-normal leading-none">{{ __('Dashboard') }}</span>
    </div>
  </div>
  <div class="eduman-content-area mt-[30px] px-7">
    <div class="grid grid-cols-12 gap-x-5">
      <div class="col-span-12 xxl:col-span-9 xl:col-span-8">
        <div class="invention-quickreport-area pl-0.5">
          <div class="eduman-quickview-area p-7 pt-5 pb-2 bg-white rounded-lg mb-5">
            <div class="eduman-dashboard-supplier-header flex flex-wrap items-center justify-between mb-6 m-0.5">
              <h5 class="text-[18px] text-heading font-bold maxSm:mb-2 maxSm:text-[16px]">
              {{ __('Eduman Report') }}</h5>
              <a href="#"
                class="text-[15px] font-semibold text-bodyText maxSm:mb-2 maxSm:text-[14px]">{{ __('View Report') }} <i class="far fa-arrow-right inline-block ml-1"></i></a>
            </div>
            <div class="eduman-quickview-wrapper flex items-center justify-between gap-x-5 maxXs:gap-x-0">
              <div class="eduman-quickview bg-[#EEF0F8] mb-5 rounded-lg">
                <a href="#" class="p-[30px] inline-block">
                  <div class="eduman-quickview-box">
                    <div class="eduman-quickview-box-icon mb-5">
                      <img src="{{asset('assets/admin/img/icon/quick-1.png')}}" alt="icon not found"
                        class="inline-block rounded-[15px]">
                    </div>
                    <h4 class="text-[22px] font-extrabold text-heading">{{$moneySign}}@money($totalIncome)</h4>
                    <span class="block text-[15px] font-semibold text-bodyText mb-8">{{ __('Total Income') }}</span>
                  </div>
                </a>
              </div>
              <div class="eduman-quickview bg-[#F8F0E7] mb-5 rounded-lg">
                <a href="#" class="p-[30px] inline-block">
                  <div class="eduman-quickview-box">
                    <div class="eduman-quickview-box-icon mb-5">
                      <img src="{{asset('assets/admin/img/icon/quick-2.png')}}" alt="icon not found"
                        class="inline-block rounded-[15px]">
                    </div>
                    <h4 class="text-[22px] font-extrabold text-heading">{{$totalCourses}}</h4>
                    <span class="block text-[15px] font-semibold text-bodyText mb-8">{{ __('Total Courses') }} </span>
                  </div>
                </a>
              </div>

              <div class="eduman-quickview bg-[#F9E8E8] mb-5 rounded-lg">
                <a href="#" class="p-[30px] inline-block">
                  <div class="eduman-quickview-box">
                    <div class="eduman-quickview-box-icon mb-5">
                      <img src="{{asset('assets/admin/img/icon/quick-3.png')}}" alt="icon not found"
                        class="inline-block rounded-[15px]">
                    </div>
                    <h4 class="text-[22px] font-extrabold text-heading">{{$totalStudents}}</h4>
                    <span class="block text-[15px] font-semibold text-bodyText mb-8">{{ __('Total Students') }}</span>
                  </div>
                </a>
              </div>

              <div class="eduman-quickview bg-[#E6F2E2] mb-5 rounded-lg">
                <a href="#" class="p-[30px] inline-block">
                  <div class="eduman-quickview-box">
                    <div class="eduman-quickview-box-icon mb-5">
                      <img src="{{asset('assets/admin/img/icon/quick-4.png')}}" alt="icon not found"
                        class="inline-block rounded-[15px]">
                    </div>
                    <h4 class="text-[22px] font-extrabold text-heading">{{$totalAuthors}}</h4>
                    <span class="block text-[15px] font-semibold text-bodyText mb-8">{{ __('Total Instructors') }}</span>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="grid grid-cols-12 gap-x-5">
          <div class="col-span-12 xl:col-span-7">
          <div class="eduman-dashboard-transaction-area">
              <div class="eduman-dashboard-transaction-wrapper p-7 pt-5 bg-white rounded-lg mb-5">
                <div
                  class="eduman-dashboard-supplier-header flex flex-wrap items-center justify-between mb-6 m-0.5">
                  <h5 class="text-[18px] text-bold font-bold maxSm:mb-2 text-heading">
                  {{ __('Our Courses') }}</h5>
                  <span class="common-blue-badge maxSm:mb-2">{{ __('List') }}</span>
                </div>
                <div class="eduman-dashboard-transaction">
                  <div class="eduman-dashboard-transaction-row-heading">
                    <div class="eduman-dashboard-transaction-referenceR">
                      <h5>{{ __('Title') }}</h5>
                    </div>
                    <div class="eduman-dashboard-transaction-customerR">
                      <h5>{{ __('Lessons') }}</h5>
                    </div>
                    <div class="eduman-dashboard-transaction-duedateR">
                      <h5>{{ __('Amount') }}</h5>
                    </div>
                  </div>
                  @foreach ($courses as $course)
                  <div class="eduman-dashboard-transaction-row">
                    <div class="eduman-dashboard-transaction-referenceR">
                      <span>{{ Str::limit($course->title, 38) }}</span>
                    </div>
                    <div class="eduman-dashboard-transaction-customerR">
                      <span>{{ count($course->lessons) }}</span>
                    </div>
                    <div class="eduman-dashboard-transaction-priceR">
                      <span>{{$course->money_sign}}{{$course->price}}</span>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
          <div class="col-span-12 xl:col-span-5 lg:col-span-6">
            <div class="eduman-dashboard-supplier-area">
              <div class="eduman-balance-area p-7 pt-5 bg-white rounded-lg mb-5">
                <div
                  class="eduman-dashboard-supplier-header flex flex-wrap items-center justify-between mb-6 m-0.5">
                  <h5 class="text-[18px] text-bold font-bold maxSm:mb-2 text-heading">{{ __('Recent Orders') }}</h5>
                  <span class="common-blue-badge maxSm:mb-2">{{ __('List') }}</span>
                </div>
                <div class="eduman-dashboard-supplier border border-solid border-grayBorder m-0.5 border-b-0 ">
                  <div
                    class="eduman-dashboard-supplier-list h-10 flex justify-between items-center border-b-[1px] border-solid border-grayBorder">
                    <div class="eduman-dashboard-supplier-list-name pl-7">
                      <h5 class="text-[15px] font-semibold text-heading">{{ __('Category') }}</h5>
                    </div>
                    <div
                      class="eduman-dashboard-supplier-list-amount border-l-[1px] border-solid border-grayBorder pl-7">
                      <h5 class="text-[15px] font-semibold text-heading">{{ __('Amount') }}</h5>
                    </div>
                  </div>
                  @foreach ($orders as $order)
                  <div
                    class="eduman-dashboard-supplier-list h-20 flex justify-between items-center border-b-[1px] border-solid border-grayBorder">
                    <div class="eduman-dashboard-supplier-list-name pl-7">
                      <span class="text-[14px] font-normal text-bodyText block mb-1">{{$order->description}}</span>
                      <span class="text-[14px] font-normal text-bodyText block">{{$order->mollie_payment_status}}, {{ __('qty:') }} {{$order->quantity}}</span>
                    </div>
                    <div
                      class="eduman-dashboard-supplier-list-amount border-l-[1px] border-solid border-grayBorder pl-7">
                      <span class="text-[14px] font-normal text-bodyText">{{!empty($order->currency && $order->currency == __('EUR') ) ? '€' : '$'}}@money( round($order->total/100, 2))</span>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-span-12 xxl:col-span-3 xl:col-span-4">
        <div class="grid grid-cols-12 gap-x-5 maxSm:gap-x-0">
          <div class="col-span-12 xl:col-span-12 lg:col-span-6 maxLg:hidden">
            <div class="eduman-dashboard-user-area">
              <div class="eduman-dashboard-user-wrapper p-7 pt-5 bg-white rounded-lg mb-5">
                <div class="eduman-dashboard-user mb-6 m-0.5">
                  <h5 class="text-[18px] text-heading font-bold">{{ __('Recent Enroll') }}</h5>
                </div>
                <div class="eduman-dashboard-user">
                @foreach ($students as $student)
                  <div class="eduman-dashboard-user-list flex flex-wrap justify-between items-center mb-5">
                    <div class="eduman-dashboard-user-list-left flex flex-wrap items-center">
                      <div class="eduman-dashboard-user-list-left-img min-w-[60px] mr-4">
                        <a href="#"><img width="85" src="{{ uploaded_asset($student->image_url) }}" alt="image"></a>
                      </div>
                      <div class="eduman-dashboard-user-list-left-text">
                        <h5 class="text-[16px] text-heading font-semibold mb-1">
                          <a href="#"></a>
                        </h5>
                        <span class="text-[14px] text-bodyText font-normal block">{{ $student->first_name }} {{ $student->last_name }}</span>
                        <span class="text-[12px] text-themeBlue font-normal block">{{ __('qty:') }}Created at {{ Carbon\Carbon::parse($student->created_at)->format('d M, Y') }}</span>
                      </div>
                    </div>

                    <div class="eduman-dashboard-user-list-right">
                      @if($student->city)
                      <span
                        class="h-5 px-1.5 border border-solid border-themeGreenDark text-[12px] leading-18 text-themeGreenDark inline-block">{{ $student->city }}</span>
                      @endif
                    </div>
                  </div>
                @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="eduman-copyright-area">
    <div class="eduman-copyright text-center bg-themeBlue h-20 leading-[80px] mt-20">
      <span class="text-[15px] text-white font-normal">{{ __('© Copyright at BDevs -2023') }}</span>
    </div>
  </div>
</div>
</x-app-layout>
