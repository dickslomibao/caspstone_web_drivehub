<?php

namespace App\Providers;


use App\Repositories\CourseVehicleRepository;
use App\Repositories\EmailVerifyRepository;
use App\Repositories\InstructorReportRepository;
use App\Repositories\Interfaces\AvailCourseRepositoryInterface;
use App\Repositories\Interfaces\CashPaymentRepositoryInterface;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\CourseVehicleRepositoryInterface;
use App\Repositories\Interfaces\EmailVerifyRepositoryInterface;
use App\Repositories\Interfaces\InstructorReportRepositoryInterface;
use App\Repositories\Interfaces\InstructorRepositoryInterface;
use App\Repositories\Interfaces\MockExamRepositoryInterface;
use App\Repositories\Interfaces\OrderCheckoutUrlRepositoryInterface;
use App\Repositories\Interfaces\OrderListRepositoryInterface;
use App\Repositories\Interfaces\OrderReasonRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\PracticalSchedulesRepositoryInterface;
use App\Repositories\Interfaces\ProgressRepositoryInterface;
use App\Repositories\Interfaces\QuestionRepositoryInterface;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Repositories\Interfaces\ScheduleInstructorRepositoryInterface;
use App\Repositories\Interfaces\ScheduleLogsRepositoryInterface;
use App\Repositories\Interfaces\ScheduleSessionsRepositoryInterface;
use App\Repositories\Interfaces\SchedulesRepositoryInterface;
use App\Repositories\Interfaces\ScheduleStudentsRepositoryInterface;
use App\Repositories\Interfaces\ScheduleVehicleRepositoryInterface;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use App\Repositories\Interfaces\StaffRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Repositories\Interfaces\TheoreticalSchdulesRepositoryInterface;
use App\Repositories\Interfaces\VehicleRepositoryInterface;

use App\Repositories\AvailCourseRepository;
use App\Repositories\CashPaymentRepository;
use App\Repositories\CourseRepository;
use App\Repositories\CourseVariantRepository;
use App\Repositories\InstructorRepository;
use App\Repositories\Interfaces\CourseVariantRepositoryInterface;
use App\Repositories\Interfaces\PromoItemRepositoryInterface;
use App\Repositories\Interfaces\PromoRepositoryInterface;
use App\Repositories\MockExamRepository;
use App\Repositories\OrderCheckoutUrlRepository;
use App\Repositories\OrderListRepository;
use App\Repositories\OrderReasonRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PracticalSchedulesRepository;
use App\Repositories\ProgressRepository;
use App\Repositories\PromoItemRepository;
use App\Repositories\PromoRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\ScheduleInstructorRepository;
use App\Repositories\ScheduleLogsRepository;
use App\Repositories\ScheduleSessionsRepository;
use App\Repositories\SchedulesRepository;
use App\Repositories\ScheduleStudentsRepository;
use App\Repositories\ScheduleVehicleRepository;
use App\Repositories\SchoolRepository;
use App\Repositories\StaffRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TheoreticalSchdulesRepository;
use App\Repositories\VehicleRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    
        $this->app->bind(SchoolRepositoryInterface::class, SchoolRepository::class);
        $this->app->bind(VehicleRepositoryInterface::class, VehicleRepository::class);
        $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);
        $this->app->bind(InstructorRepositoryInterface::class, InstructorRepository::class);
        $this->app->bind(ProgressRepositoryInterface::class, ProgressRepository::class);
        $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
        $this->app->bind(AvailCourseRepositoryInterface::class, AvailCourseRepository::class);
        $this->app->bind(PracticalSchedulesRepositoryInterface::class, PracticalSchedulesRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderListRepositoryInterface::class, OrderListRepository::class);
        $this->app->bind(TheoreticalSchdulesRepositoryInterface::class, TheoreticalSchdulesRepository::class);
        $this->app->bind(StaffRepositoryInterface::class, StaffRepository::class);
        $this->app->bind(CashPaymentRepositoryInterface::class, CashPaymentRepository::class);
        $this->app->bind(ScheduleSessionsRepositoryInterface::class, ScheduleSessionsRepository::class);
        $this->app->bind(SchedulesRepositoryInterface::class, SchedulesRepository::class);
        $this->app->bind(ScheduleInstructorRepositoryInterface::class, ScheduleInstructorRepository::class);
        $this->app->bind(ScheduleVehicleRepositoryInterface::class, ScheduleVehicleRepository::class);
        $this->app->bind(ScheduleStudentsRepositoryInterface::class, ScheduleStudentsRepository::class);
        $this->app->bind(PromoRepositoryInterface::class, PromoRepository::class);
        $this->app->bind(PromoItemRepositoryInterface::class, PromoItemRepository::class);
        $this->app->bind(CourseVariantRepositoryInterface::class, CourseVariantRepository::class);
        $this->app->bind(QuestionRepositoryInterface::class, QuestionRepository::class);
        $this->app->bind(ScheduleLogsRepositoryInterface::class, ScheduleLogsRepository::class);
        $this->app->bind(MockExamRepositoryInterface::class, MockExamRepository::class);
        $this->app->bind(OrderCheckoutUrlRepositoryInterface::class, OrderCheckoutUrlRepository::class);
        $this->app->bind(EmailVerifyRepositoryInterface::class, EmailVerifyRepository::class);
        $this->app->bind(InstructorReportRepositoryInterface::class, InstructorReportRepository::class);
        $this->app->bind(ReviewRepositoryInterface::class, ReviewRepository::class);
        $this->app->bind(OrderReasonRepositoryInterface::class, OrderReasonRepository::class);
        $this->app->bind(CourseVehicleRepositoryInterface::class, CourseVehicleRepository::class);

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
