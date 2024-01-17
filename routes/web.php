<?php

use App\Events\TestEvent;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminFilterController;
use App\Http\Controllers\Admin\AStudentController;
use App\Http\Controllers\Admin\DrivingSchoolController;
use App\Http\Controllers\Admin\PrivacyPolicyController;
use App\Http\Controllers\Admin\TermsController;
use App\Http\Controllers\Api\School\PaymongoController;
use App\Http\Controllers\MakeOrder\MakeOrderController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\Schoo\ProfileController;
use App\Http\Controllers\School\AvailedCoursesController;
use App\Http\Controllers\School\CoursesController;
use App\Http\Controllers\School\InstructorController;
use App\Http\Controllers\School\OrderController;
use App\Http\Controllers\School\ProgressController;
use App\Http\Controllers\School\PromoController;
use App\Http\Controllers\School\QuestionController;
use App\Http\Controllers\School\ReportedController;
use App\Http\Controllers\School\ReportsController;
use App\Http\Controllers\School\ScheduleController;
use App\Http\Controllers\School\SchoolController;
use App\Http\Controllers\School\StaffController;
use App\Http\Controllers\School\StudentController;
use App\Http\Controllers\School\TheoriticalController;
use App\Http\Controllers\School\TrackingController;
use App\Http\Controllers\School\VehicleController;
use App\Http\Controllers\Validator\ValidateAccountController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Stichoza\GoogleTranslate\GoogleTranslate;
use GuzzleHttp\Client;

use App\Http\Controllers\School\ExportPDFController;
use App\Http\Controllers\School\SchoolFilterController;
use App\Http\Controllers\Admin\IdentificationCardController;
use App\Http\Controllers\School\LogController;
use App\Http\Controllers\Admin\AdminLogsController;
use App\Http\Controllers\School\ScheduleReportController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::POST('/webhook-paymongo', function (Request $request) {
    try {
        Storage::disk('public')->put('images.json', json_encode(['asd   ']));
    } catch (Exception $th) {
        Storage::disk('public')->put('images.json', json_encode([
            'msg' => $th->getMessage(),
        ]));
    }
});

// Route::get('/cancel', function () {
//     return view('cancel');
// });

// Route::get('/school', function () {
//     return view(SchoolFileHelper::$dashboard);
// });
Route::get('/', function () {

    if (!Auth::user()) {
        return redirect('/login');
    }
    if (in_array(auth()->user()->type, [1, 4])) {
        return redirect()->route('schoolDashboard');
    } else {
        return redirect()->route('admin.dashboard');
    }
});

Route::get('/dashboard', function () {

    if (in_array(auth()->user()->type, [1, 4])) {
        return redirect()->route('schoolDashboard');
    } else {
        return redirect()->route('admin.dashboard');
    }
})->name('dashboard');

Route::controller(SchoolController::class)->group(
    function () {
        Route::POST('/register/school', 'store')->name('register.school');
        Route::get('/school', 'index')->name('schoolDashboard');
        Route::get('/school/filterStudentGrowthPage', 'filterStudentGrowthPage')->name('school.filterStudentGrowthPage');
        Route::POST('/school/filterStudentGrowth', 'filterStudentGrowthGraph')->name('school.filter.studentGrowthGraph');
        Route::get('/school/filterOrderGrowthPage', 'filterOrderGrowthPage')->name('school.filterOrderGrowthPage');
        Route::POST('/school/filterOrderGrowth', 'filterOrderGrowthGraph')->name('school.filter.OrderGrowthGraph');
        Route::get('/school/filterRevenueGrowthPage', 'filterRevenueGrowthPage')->name('school.filterRevenueGrowthPage');
        Route::POST('/school/filterRevenueGrowth', 'filterRevenueGrowthGraph')->name('school.filter.RevenueGrowthGraph');

        Route::get('/school/accreditation/page', 'schoolAccreditationPage')->name('accreditation.page');
        Route::get('/school/accreditation', 'schoolAccreditation')->name('accreditation.index');
        Route::POST('/school/accreditation/validID', 'storeSchoolAccreditationValidID')->name('store.school.accreditation.validID');
        Route::POST('/school/accreditation/Business', 'storeSchoolAccreditationBusiness')->name('store.school.accreditation.business');

        ////////////////////////new saturday///////////////////////////////////////////////
        Route::get('/school/view/ratings', 'schoolRatings')->name('school.view.ratings');

        ////newest as in
        Route::POST('/school/accreditation/validID/update', 'updateSchoolAccreditationValidID')->name('update.school.accreditation.validID');
    }
);


Route::controller(ReportsController::class)->group(
    function () {
        Route::get('/school/reports', 'index')->name('index.reports');
        Route::get('/school/reports/retreiveWeekly', 'retreiveWeeklyReport')->name('retrieve.WeeklyReport');

        ///////////////////////////////////new sunday//////////////////////////////////////////////////
        Route::get('/school/reports/course/viewStudents/{course_id}/{course_name}/{start}/{end}', 'viewCourseStudents')->name('view.course.students');
        Route::get('/school/reports/retreiveWeeklySales', 'retreiveWeeklyReportSales')->name('retrieve.WeeklyReportSales');
        Route::get('/school/reports/course/Sales/viewStudents/{course_id}/{course_name}/{start}/{end}', 'viewCourseSalesStudents')->name('view.course.sales.students');
    }
);

Route::controller(InstructorController::class)->group(
    function () {
        Route::get('/school/instructors', 'index')->name('index.instructor');
        Route::get('/school/instructors/create', 'create')->name('create.instructor');

        Route::POST('/school/instructors', 'store')->name('store.instructor');
        Route::POST('/school/instructors/retrieve', 'retrieveSchoolInstructors')->name('retrieve.instructor');
        Route::POST('/school/instructors/scheduled', 'getInstructorScheduleUsingId')->name('instrutor.schedule');
        Route::POST('/school/instructors/checkconflict', 'checkInstructorConflictSchedule')->name('instrutor.checkconflict');

        ////////chrissha dagdag   
        Route::get('/school/instructors/update/page/{id}', 'updateInstructor')->name('update.instructor.page');
        Route::POST('/school/instructors/update', 'update')->name('update.instructor');
        Route::get('/school/instructors/moreDetails/{id}', 'moreDetailsInstructor')->name('more.details.instructor');
        Route::POST('/school/instructors/deleteInstructor', 'deleteInstructor')->name('delete.instructor');
        Route::get('/school/instructors/{id}/promote', 'promote')->name('promote.instructor');
        Route::POST('/school/instructors/{id}/viewStudents', 'retreiveScheduledStudents')->name('retrieve.scheduledStudents');
        Route::POST('/school/instructors/import', 'import')->name('import.instructor');
    }
);
Route::controller(VehicleController::class)->group(
    function () {
        Route::get('/school/vehicles', 'index')->name('index.vehicles');
        Route::POST('/school/vehicles/store', 'store')->name('store.vehicle');
        Route::POST('/school/vehicles', 'retrieveAll')->name('retrieve.vehicles');
        Route::POST('/school/vehicles/{id}/update', 'update')->name('update.vehicle');
        Route::POST('/school/vehicles/plate_number', 'uniquePlateNumber')->name('unique.plate_number');
        Route::POST('/school/vehicles/deleteVehicle', 'deleteVehicle')->name('delete.vehicle');
        Route::get('/school/view/{id}', 'viewVehicle')->name('view.vehicles');

        ///revision
        Route::get('/school/vehicle/view/Report/{id}/{name}', 'viewVehicleReport')->name('view.vehicle.report');
        Route::POST('/school/vehicle/report/retrieve/{id}', 'retrieveVehicleReport')->name('retrieve.vehicle.report');
        Route::get('/school/vehicle/schedulesreport/{id}/view', 'viewVehicleReportDetails');
    }
);
Route::controller(ScheduleReportController::class)->group(
    function () {
        Route::get('/school/schedulesreport', 'index')->name('index.sreport');
        Route::POST('/school/schedulesreport', 'getReportedData')->name('index.sreport');
        Route::get('/school/schedulesreport/{id}/view', 'view');
    }
);
Route::controller(CoursesController::class)->group(
    function () {
        Route::get('/school/courses', 'index')->name('index.courses');
        Route::POST('/school/courses/store', 'store')->name('store.course');
        Route::get('/school/courses/create', 'create')->name('create.course');
        Route::POST('/school/courses', 'retrieveAll')->name('retrieve.course');
        Route::POST('/school/courses/createnewcourse', 'storeFromWeb')->name('storeFromWeb.course');
        Route::get('/school/courses/{id}/view', 'show')->name('show.courses');
        Route::POST('/school/courses/{id}/view', 'createVariant')->name('create.variant');

        ////////chrissha dagdag  
        Route::get('/school/courses/{id}/updateView', 'updateView')->name('update.view');
        Route::POST('/school/courses/updatecourse', 'updateFromWeb')->name('updateFromWeb.course');
        Route::POST('/school/courses/update/variant', 'updateVariant')->name('update.variant');
        Route::POST('/school/courses/totalcoursegraph', 'filterCourseGraph')->name('school.course.filter.graph');
        Route::POST('/school/courses/deleteCourse', 'deleteCourse')->name('delete.course');

        ///new as in
        Route::POST('/school/courses/delete/variant', 'deleteVariant')->name('delete.variant');
    }
);
Route::controller(MessageController::class)->group(
    function () {
        Route::get('/school/messages/{id?}', 'viewAdminMessages')->name('school.messages');
        Route::POST('/school/messages/{id}', 'sentMessage');
        Route::POST('/school/messages/user/getconvo', 'getConvoIdWithUser');
        Route::POST('/school/messages/{id}/retrieve', 'getConversationMessages');
        Route::post('/school/conversation/retrieve', 'getConversation')->name('get.convo');
    }
);


Route::controller(ProgressController::class)->group(
    function () {
        Route::get('/school/progress', 'index')->name('progress.index');
        Route::POST('/school/progress', 'store')->name('progress.create');
        Route::POST('/school/progress/retrieve', 'retrieveAll')->name('retrieve.progress');
        Route::POST('/school/progress/{id}/update', 'updateProgress')->name('update.progress');
        Route::POST('/school/progress/{id}/subprogress', 'retreiveSubProgress')->name('retrieve.subprogress');
        Route::POST('/school/progress/{id}/subprogress/create', 'storeSubCategory')->name('store.subprogress');

        Route::POST('/school/progress/deleteProgress', 'deleteProgress')->name('delete.progress');
        Route::POST('/school/progress/deleteSubProgress', 'deleteSubProgress')->name('delete.sub_progress');
        Route::POST('/school/progress/updateSubProgress', 'updateSubProgress')->name('update.sub_progress');
    }
);
Route::controller(StudentController::class)->group(
    function () {
        Route::get('/school/student', 'index')->name('index.student');
        Route::POST('/school/student/create', 'store')->name('store.student');
        Route::get('/school/student/create', 'create')->name('create.student');
        Route::POST('/school/student/retrieve', 'retrieveAll')->name('retrieve.student');
        Route::get('/school/student/{id}/profile', 'show')->name('show.student');
    }
);
Route::controller(MakeOrderController::class)->group(
    function () {
        Route::get('/school/student/{student_id}/makeorder', 'index')->name('makeorder.index');
        Route::POST('/school/student/{student_id}/makeorder', 'create')->name('create.makeorder');
    }
);
Route::controller(AvailedCoursesController::class)->group(function () {

    Route::POST('/availed/courses/{id}/view/checkall', 'checkAllProgress')->name('checkallprogress.availedcourse');

    Route::get('/availed/courses', 'index')->name('index.availedcourse');
    Route::get('/availed/courses/{id}/view', 'availedCourseView')->name('view.availedcourse');
    Route::get('/availed/courses/{id}/view/progress', 'practicalProgressView')->name('progress.availedcourse');
    Route::POST('/availed/courses/viewsession', 'viewSession')->name('view.sessions');
    Route::POST('/availed/courses/{id}/create', 'createSesssion')->name('create.session');
    Route::get('/availed/courses/{id}/view/addsession', 'addSession')->name('add.session');
    Route::POST('/availed/courses/{id}/view/setcompleted', 'setAsCompleted')->name('set.completed');
    Route::get('/availed/courses/{order_list_id}/view/{session_id}/removesession', 'removeSession')->name('remove.session');
});
Route::controller(ReportedController::class)->group(function () {
    Route::get('/school/reportedinstructor', 'index')->name('index.reported');
    Route::get('/school/reportedinstructor/{id}/view', 'view')->name('view.reported');
    Route::POST('/school/reportedinstructor/get', 'getReportedData')->name('get.reported');
});
Route::controller(ScheduleController::class)->group(function () {
    Route::get('/school/calendar', "calendar")->name('index.calendar');
    Route::post('/school/schedule/view', 'viewShedule')->name('view.sched');
    Route::POST('/schedules/getconflict', "getInstructorAndVehicleNotAvailableWithSelectedTime")->name('schedule.conflict');
    Route::get('/availed/courses/{oderlist_id}/view/{session_id}/create', 'viewPractical')->name('create.practicalschedule');
    Route::POST('/availed/courses/{oderlist_id}/view/{session_id}/create', 'storePractical')->name('store.practicalschedule');
    Route::get('/availed/courses/{order_list_id}/session/{session_id}/update', 'updatePractical')->name('update.practical');
    Route::POST('/availed/courses/{order_list_id}/session/{session_id}/update', 'updateActionPractical')->name('actionupdate.practical');

    ///revision
    Route::post('/school/schedule/view/vehicle', 'viewScheduleVehicle')->name('view.sched.vehicle');
});


Route::controller(TheoriticalController::class)->group(
    function () {
        Route::get('/school/theoritical', 'index')->name('index.theoritical');
        Route::get('/school/theoritical/create', 'create')->name('create.theoritical');
        Route::POST('/school/theoritical/create', 'store')->name('create.theoritical');
        Route::get('/school/theoritical/{id}/view', 'showView')->name('theoritical.view');
        Route::post('/school/theoritical', 'retrieveSchoolTheoriticalSchedules')->name('get.theoritical');
        Route::POST('/school/theoritical/{id}/view/addstudents', 'addStudentList')->name('theoritical.addstudents');
        Route::get('/school/theoritical/{id}/update', 'updateView')->name('update.theoritical');
        Route::POST('/school/theoritical/{id}/updateaction', 'updateAction')->name('updateAction.theoritical');
        Route::get('/school/theoritical/{id}/view/{schedule_id}/schedule/{instructor_id}/removeinstructor', 'removeTheoriticalInstructor')->name('theoritical.remove_i');
        Route::POST('/school/theoritical/{theoritical_id}/view/addinstructor', 'addInstructor')->name('theoritical.addinstructor');
        Route::get('/school/theoritical/{id}/view/{order_list_id}/schedule/{student_id}/remove_student', 'removeTheoriticalStudent')->name('theoritical.remove_s');
    }
);
Route::controller(PromoController::class)->group(
    function () {
        Route::get('/school/promo', 'index')->name('index.promo');
        Route::get('/school/promo/create', 'create')->name('create.promo');
        Route::POST('/school/promo/create', 'store')->name('store.promo');
        Route::get('/school/promo/{promo_id}/view', 'show')->name('show.promo');
        ////////chrissha dagdag
        Route::get('/school/promo/{id}/updateView', 'updateView')->name('updatePromo.view');
        Route::POST('/school/promo/updatePromo', 'updatePromo')->name('update.promo');
        Route::POST('/school/promo/deletePromo', 'deletePromo')->name('delete.promo');
        Route::POST('/school/promo/filterOrders', 'promoFilterOrderGraph')->name('promo.filter.OrderGraph');
    }
);
Route::controller(OrderController::class)->group(function () {
    Route::get('/school/orders', 'index')->name('index.order');
    Route::get('/school/orders/{id}/view', 'orderDetailsView')->name('view.order');
    Route::get('/school/orders/{id}/view/logs', 'orderlogs')->name('logs.order');
    Route::get('/school/orders/{id}/view/accept', 'acceptOrder')->name('accept.order');
    Route::get('/school/orders/{id}/view/acceptRequirements', 'acceptRequiremet')->name('accept.req');
    Route::POST('/school/orders/{id}/view/cancelOrder', 'cancelOrder')->name('cancel.order');
    Route::POST('/school/orders/{id}/view/refundOrder', 'refundOrder')->name('refund.order');
    Route::POST('/school/get/orders', 'getSchoolOrders')->name('school.orders');
    Route::POST('/school/orders/{order_id}/makecashpayment', 'makeCashPayment')->name('create.cashpayment');
});

Route::controller(StaffController::class)->group(
    function () {
        Route::get('/school/staff', 'index')->name('index.staff');
        Route::get('/school/staff/create', 'create')->name('create.staff');
        Route::get('/school/staff/{staff_id}/update', 'update')->name('update.staff');
        Route::POST('/school/staff/create/store', 'store')->name('store.staff');
        Route::POST('/school/staff/{staff_id}/save', 'saveUpdate')->name('save.staff');
        Route::get('/school/staff/{staff_id}/promote', 'promote')->name('promote.staff');


        Route::POST('/school/staff/deleteStaff', 'deleteStaff')->name('delete.staff');
    }
);
Route::controller(QuestionController::class)->group(
    function () {
        Route::get('/school/question', 'index')->name('index.question');
        Route::get('/school/question/create', 'create')->name('create.question');
        Route::POST('/school/question/create', 'store')->name('store.question');
        Route::POST('/school/question/deleteQuestion', 'deleteQuestion')->name('delete.question');
        Route::POST('/school/question/getall', 'getSchoolQuestion')->name('get.question');


        Route::get('/school/question/update/page/{id}', 'updateQuestion')->name('update.question.page');
        Route::POST('/school/question/update', 'update')->name('update.question');
    }
);

Route::controller(ValidateAccountController::class)->group(
    function () {
        Route::POST(
            '/validate/checkEmailOrUsername',
            'validateUsernameOrEmail'
        )->name('check.unique');
    }
);
Route::controller(PaymongoController::class)->group(
    function () {
        Route::get('/success/{order_id}', 'success');
        Route::get('/cancel', 'cancel');
    }
);
Route::controller(TrackingController::class)->group(
    function () {
        Route::GET('/school/tracking', 'index')->name('index.tracking');
    }
);

Route::controller(ProfileController::class)->group(
    function () {
        Route::GET('/school/profile', 'index')->name('index.profile');
        Route::POST('/school/profile/addterms', 'addtermsAndConditon')->name('add.terms');
        Route::POST('/school/profile/addbout', 'addAbout')->name('add.about');
        Route::POST('/school/profile/update/{id}', 'updatetermsAndConditon')->name('update.termsconditon');
        Route::POST('/school/profile/update/{id}/about', 'updateAbout')->name('update.updateAbout');

        ///revision 
        Route::POST('/school/profile', 'updateOpenHours')->name('update.openHours');
    }
);




Route::controller(AdminDashboardController::class)->group(
    function () {
        Route::get('/admin', 'index')->name('admin.dashboard');
        // pending operations go here
        Route::get('/admin/pendingRequest', 'pendingRequest')->name('admin.pendingSchool');
        Route::get('/admin/pendingSchoolDetails/{id}', 'pendingSchoolDetails')->name('admin.pending.schools.details');
        Route::POST('/admin/school/approveAccreditation', 'approveAccreditation')->name('admin.school.approve.accreditation');


        ///////admin management
        Route::get('/admin/adminManagement', 'retreiveAdmin')->name('admin.retreive.adminAccounts');
        Route::get('/admin/admin/create', 'createAdmin')->name('create.admin');
        Route::POST('/admin/admin/create/store', 'storeAdmin')->name('store.admin');
        Route::get('/admin/admin/{admin_id}/update', 'updateAdmin')->name('update.admin');
        Route::POST('/admin/admin/saveUpdate', 'saveUpdateAdmin')->name('save.update.admin');
        Route::POST('/admin/admin/deleteAdmin', 'deleteAdmin')->name('delete.admin');
    }
);

Route::controller(DrivingSchoolController::class)->group(
    function () {

        Route::get('/admin/drivingschool', 'index')->name('admin.drivingschool');
        Route::POST('/admin/school/retrieve', 'retrieveDrivingSchools')->name('retrieve.schools');
        Route::get('/admin/registerSchool', 'redirectRegisterSchoolPage')->name('admin.registerSchool');
        Route::POST('/admin/regschool', 'store')->name('admin.register.school');
        Route::get('/admin/schoolDetails/{id}', 'schoolDetails')->name('admin.schools.details');
        Route::get('/admin/schoolCourses/{id}', 'schoolCourses')->name('admin.schools.courses');
        //Route::get('/admin/coursesDetails/{schoolID}/{courseID}','courseDetails')->name(' admin.schools.courseDetails');
        Route::get('/admin/courseDetails/{schoolID}/{courseID}', 'courseDetails')->name('admin.schools.courseDetails');
        Route::get('/admin/schoolStudents/{schoolID}', 'schoolStudentsDetails')->name('admin.schools.students');
        Route::POST('/admin/drivingschool/{id}/notify', 'notifySchool')->name('notify.drivingschool');
        /////new/////
        Route::get('/admin/school/reports/{schoolID}', 'schoolReportsDetails')->name('admin.school.reports');
        Route::get('/admin/reports/retreiveWeekly/{schoolID}', 'adminRetreiveWeeklyReport')->name('admin.retrieve.WeeklyReport');
        Route::get('/admin/reports/retreiveWeeklySales/{schoolID}', 'adminRetreiveWeeklyReportSales')->name('admin.retrieve.WeeklyReportSales');
        Route::get('/admin/school/reviews/{schoolID}', 'schoolReviewsDetails')->name('admin.school.reviews');
    }
);


Route::controller(AStudentController::class)->group(
    function () {
        Route::get('/admin/students', 'retreiveStudents')->name('admin.student');
        Route::get('/admin/
        /{id}', 'studentDetails')->name('admin.student.details');
    }
);


Route::controller(AdminFilterController::class)->group(
    function () {
        Route::post('/admin/filterSchoolGraph', 'yearSchoolGraph')->name('admin.filter.yearSchoolGraph');
        Route::post('/admin/filterCourseGraph', 'courseStudents')->name('admin.filter.courseStudent');
        Route::post('/admin/filterStudentGraph', 'studentGraph')->name('admin.filter.schoolStudent');
        Route::post('/admin/filterStudentTable', 'studentTable')->name('admin.filter.studentTable');
        Route::get('/admin/filterTopPerformingSchool', 'topSchool')->name('admin.filter.topSchool');

        ////////////////////////new saturday///////////////////////////////////////////////
        Route::get('/admin/filterTopPerformingSchool', 'topSchool')->name('admin.filter.topSchool');
        Route::post('/admin/filterTopPerformingTable', 'filterTopSchool')->name('admin.filter.topSchoolTable');
        Route::POST('/admin/filter/reports/courseViewStudents/withDate', 'adminFiltercourseViewStudents')->name('admin.school.filter.courseViewStudents.date');
        Route::POST('/admin/filter/reports/courseFilterSales/withDate', 'adminFilterReportSales')->name('admin.school.filter.reportsales.date');
        Route::POST('/admin/filter/school/ratings', 'adminSchoolReviewsFilter')->name('admin.school.filter.reviews');
        Route::POST('/admin/filter/schools/availablity', 'adminSchoolFilterAvailability')->name('admin.school.filter.availability');

        ///newest as in
        Route::POST('/admin/filter/logs', 'adminFilterLogs')->name('admin.filter.logs');

        ///revision
        Route::POST('/admin/filter/index', 'filterAdminDasboard')->name('admin.filter.dashboard');
    }
);


Route::controller(TermsController::class)->group(
    function () {
        Route::get('/admin/terms', 'index')->name('index.terms');
        Route::POST('/admin/terms/retrieve', 'retrieveAll')->name('retrieve.terms');
        Route::POST('/admin/terms', 'store')->name('terms.create');
        Route::POST('/admin/terms/{id}/update', 'updateTerms')->name('update.terms');
        Route::POST('/admin/terms/deleteTerms', 'deleteTerms')->name('delete.terms');
    }
);


Route::controller(PrivacyPolicyController::class)->group(
    function () {
        Route::get('/admin/privacy', 'index')->name('index.privacy');
        Route::POST('/admin/privacy/retrieve', 'retrieveAll')->name('retrieve.privacy');
        Route::POST('/admin/privacy', 'store')->name('privacy.create');
        Route::POST('/admin/privacy/{id}/update', 'updatePrivacy')->name('update.privacy');
        Route::POST('/admin/privacy/deletePrivacy', 'deletePrivacy')->name('delete.privacy');
    }
);

Route::controller(ExportPDFController::class)->group(
    function () {
        //Route::POST('/school/instructors/export_pdf', 'instructorExportPDF')->name('instructor.export.pdf');

        Route::get('/school/instructors/export_pdf', 'instructorExportPDF')->name('instructor.export.pdf');
        Route::get('/school/students/export_pdf', 'studentExportPDF')->name('student.export.pdf');
        Route::get('/school/vehicles/export_pdf', 'vehiclesExportPDF')->name('vehicles.export.pdf');
        Route::get('/school/courses/export_pdf', 'coursesExportPDF')->name('courses.export.pdf');
        Route::get('/school/promo/export_pdf', 'promoExportPDF')->name('promo.export.pdf');
        Route::get('/school/staff/export_pdf', 'staffExportPDF')->name('staff.export.pdf');
        Route::get('/school/progress/export_pdf', 'progressExportPDF')->name('progress.export.pdf');
        Route::get('/school/questions/export_pdf', 'questionExportPDF')->name('question.export.pdf');
        Route::get('/school/theoreticalSched/export_pdf', 'theoreticalSchedExportPDF')->name('theoreticalSched.export.pdf');
        Route::get('/school/ordersPayment/export_pdf', 'ordersPaymentExportPDF')->name('orders.payment.export.pdf');
        Route::get('/school/availedCourses/export_pdf', 'availedCoursesExportPDF')->name('availed.courses.export.pdf');


        // with filetrrrrrrrr
        Route::get('/school/availedCourses/{status}/{start_date}/{end_date}/export_pdf', 'filterAvailedCoursesExportPDF')->name('filtered.availed.courses.export.pdf');
        Route::get('/school/ordersPayment/{status}/{payment}/{start_date}/{end_date}/export_pdf', 'filterOrdersPaymentExportPDF')->name('filtered.orders.payment.export.pdf');
        Route::get('/school/courses/{status}/{start_date}/{end_date}/export_pdf', 'filterCoursesExportPDF')->name('filtered.courses.export.pdf');
        Route::get('/school/theoreticalSched/{status}/{start_date}/{end_date}/export_pdf', 'filterTheoreticalSchedExportPDF')->name('filtered.theoreticalSched.export.pdf');
        Route::get('/school/promo/{start_date}/{end_date}/export_pdf', 'filterPromoExportPDF')->name('filtered.promo.export.pdf');
        Route::get('/school/vehicles/{type}/{transmission}/{fuel}/export_pdf', 'filterVehiclesExportPDF')->name('filtered.vehicles.export.pdf');
        Route::get('/school/questions/{status}/{start_date}/{end_date}/export_pdf', 'filterQuestionsExportPDF')->name('filtered.questions.export.pdf');


        ////////////////////////new saturday///////////////////////////////////////////////
        Route::get('/school/reviews/export_pdf', 'reviewsExportPDF')->name('reviews.export.pdf');
        Route::get('/school/reviews/filter/{rating}/{start_date}/{end_date}/export_pdf', 'filterRatingExportPDF')->name('filtered.rating.export.pdf');

        //newest
        Route::get('/school/reports/totalSales/export_pdf', 'totalSalesExportPDF')->name('total.sales.export.pdf');
    }
);

Route::controller(SchoolFilterController::class)->group(
    function () {
        Route::POST('/school/filter/availedCourses', 'filterAvailedCourses')->name('school.filter.availedCourses');
        Route::POST('/school/filter/ordersPayment', 'filterOrdersPayment')->name('school.filter.ordersPayment');
        Route::POST('/school/filter/courses', 'filterCourses')->name('school.filter.courses');
        Route::POST('/school/filter/theoreticalSched', 'filterTheoreticalSched')->name('school.filter.theoreticalSched');
        Route::POST('/school/filter/promo', 'filterPromo')->name('school.filter.promo');
        Route::POST('/school/filter/vehicles', 'filterVehicles')->name('school.filter.vehicles');
        Route::POST('/school/filter/questions', 'filterQuestions')->name('school.filter.questions');


        ////////////////////////new saturday///////////////////////////////////////////////
        Route::POST('/school/filter/ratings', 'schoolReviewsFilter')->name('school.filter.reviews');
        Route::get('/school/reviews/filter/{rating}/{start_date}/{end_date}/export_pdf', 'filterRatingExportPDF')->name('filtered.rating.export.pdf');




        ///////////////////////////////////new sunday//////////////////////////////////////////////////
        Route::get('/school/reports/course/viewStudents/{course_id}/{course_name}/{start_date}/{end_date}/export_pdf', 'viewCourseStudentsExportPDF')->name('view.course.students.export.pdf');
        Route::get('/school/reports/course/viewStudents/{course_id}/{course_name}/{start_date}/{end_date}/{duration}/export_pdf', 'viewCourseStudentsDurationExportPDF')->name('view.course.students.duration.export.pdf');
        Route::get('/school/reports/course/totalOrder/export_pdf', 'courseTotalOrderExportPDF')->name('course.total.order.export.pdf');
        Route::get('/school/reports/course/filterTotalOrder/{start_date}/{end_date}/export_pdf', 'filterCourseTotalOrderExportPDF')->name('course.filter.total.order.export.pdf');


        Route::get('/school/reports/course/totalSales/export_pdf', 'courseTotalSalesExportPDF')->name('course.total.sales.export.pdf');
        Route::get('/school/reports/course/filterTotalSales/{start_date}/{end_date}/export_pdf', 'filterCourseTotalSalesExportPDF')->name('course.filter.total.sales.export.pdf');
        Route::get('/school/reports/course/Sales/viewStudents/{course_id}/{course_name}/{start_date}/{end_date}/export_pdf', 'viewCourseStudentsSalesExportPDF')->name('view.course.students.sales.export.pdf');
        Route::get('/school/reports/course/Sales/viewStudents/{course_id}/{course_name}/{start_date}/{end_date}/{duration}/export_pdf', 'viewSalesCourseStudentsDurationExportPDF')->name('view.sales.course.students.duration.export.pdf');

        Route::POST('/school/filter/reports/courseViewStudents/withDate', 'filtercourseViewStudents')->name('school.filter.courseViewStudents.date');
        Route::POST('/school/filter/reports/courseViewStudents', 'courseViewStudents')->name('school.filter.courseViewStudents');
        Route::POST('/school/filter/reports/courseFilterSales/withDate', 'filterReportSales')->name('school.filter.reportsales.date');
        Route::POST('/school/filter/reports/Sales/courseViewStudents', 'courseSalesViewStudents')->name('school.filter.sales.courseViewStudents');

        ///newest as in 
        Route::POST('/school/filter/index', 'filterSchoolDasboard')->name('school.filter.dashboard');
        Route::POST('/school/filter/reports/Sales/withDate', 'filterSalesReport')->name('school.filter.salesReport.date');
        Route::get('/school/reports/filter/total/sales/{start_date}/{end_date}/export_pdf', 'filterTotalNewSalesExportPDF')->name('filter.total.new.sales.export.pdf');
        Route::POST('/school/filter/logs', 'filterLogs')->name('school.filter.logs');
    }
);

Route::controller(IdentificationCardController::class)->group(
    function () {
        Route::get('/admin/identification', 'index')->name('index.identification');
        Route::POST('/admin/identification/retrieve', 'retrieveAll')->name('retrieve.identification');

        Route::POST('/admin/identification', 'store')->name('identification.create');
        Route::POST('/admin/identification/{id}/update', 'updateTerms')->name('update.identification');
        Route::POST('/admin/identification/deleteTerms', 'deleteTerms')->name('delete.identification');
    }
);
Route::controller(ResetPassword::class)->group(
    function () {
        Route::POST('/forgot-passwords', 'reset')->name('reset.password');
    }
);

///newest as in
Route::controller(LogController::class)->group(
    function () {
        Route::get('/school/log', 'index')->name('index.log');
    }
);

Route::controller(AdminLogsController::class)->group(
    function () {
        Route::get('/admin/log', 'index')->name('admin.log.index');
    }
);
// Route::get('/availed/courses', 'schoolView')->name('availed.schoolview');
// Route::POST('/availed/courses', 'schoolListAvailedServices')->name('retrieve.schoolorders');
// Route::get('/availed/courses/{id}/view', 'schoolOrderView')->name('view.schoolorders');
// Route::POST('/availed/courses/{id}/createpayment', 'createPayment')->name('createpayment.schoolorder');
// Route::POST('/availed/courses/{id}/updateSession', 'updateSession')->name('updatesession.schoolorder');
// Route::get('/availed/courses/{id}/view/{session_id}/setschedule', 'schoolViewSetSessionSchedule')->name('setschedule.schoolorders');
// Route::POST('/availed/courses/{id}/view/{session_id}/setschedule', 'updateSessionSchedule')->name('store.schoolorders');
// Route::controller(AvailCourseController::class)->group(function () {
//     Route::get('/availed/courses/{id}/view', 'availedCourseView')->name('view.availedcourse');
//     // Route::get('/availed/courses', 'schoolView')->name('availed.schoolview');
//     // Route::POST('/availed/courses', 'schoolListAvailedServices')->name('retrieve.schoolorders');
//     // Route::get('/availed/courses/{id}/view', 'schoolOrderView')->name('view.schoolorders');
//     // Route::POST('/availed/courses/{id}/createpayment', 'createPayment')->name('createpayment.schoolorder');
//     // Route::POST('/availed/courses/{id}/updateSession', 'updateSession')->name('updatesession.schoolorder');
//     // Route::get('/availed/courses/{id}/view/{session_id}/setschedule', 'schoolViewSetSessionSchedule')->name('setschedule.schoolorders');
//     // Route::POST('/availed/courses/{id}/view/{session_id}/setschedule', 'updateSessionSchedule')->name('store.schoolorders');
// });
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
