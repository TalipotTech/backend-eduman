<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private $developmentSeeders = [
        UserSeeder::class,
        CategorySeeder::class,
        AuthorSeeder::class,
        BlogSeeder::class,
        KeyValueSeeder::class,
        MenusSeeder::class,
        EventSeeder::class,
        EventAuthorSeeder::class,
        EventAttendeeSeeder::class,
        CourseSeeder::class,
        CourseCategorySeeder::class,
        CourseUserSeeder::class,
        CourseAuthorSeeder::class,
        CourseReviewSeeder::class,
        QuestionSeeder::class,
        QuizSeeder::class,
        LessonSeeder::class,
        TopicSeeder::class,
        ClassroomSeeder::class,
        FaqSeeder::class, 
        PricePlanSeeder::class,
        RoleSeeder::class, 
        PermissionTableSeeder::class,
        StudentSeeder::class,
        CreateSuperAdminUserSeeder::class,
        AssetSeeder::class,
        PageSeeder::class,
        OrderSeeder::class,
        OrderItemSeeder::class,
        OrderBillingSeeder::class,
        PaymentSeeder::class,
    ];

    private $testingSeeders = [
        UserSeeder::class,
        CategorySeeder::class,
        AuthorSeeder::class,
        BlogSeeder::class,
        KeyValueSeeder::class,
        MenusSeeder::class,
        EventSeeder::class,
        EventAuthorSeeder::class,
        EventAttendeeSeeder::class,
        CourseSeeder::class,
        CourseCategorySeeder::class,
        CourseUserSeeder::class,
        CourseAuthorSeeder::class,
        CourseReviewSeeder::class,
        QuestionSeeder::class,
        QuizSeeder::class,
        LessonSeeder::class,
        TopicSeeder::class,
        ClassroomSeeder::class,
        FaqSeeder::class, 
        PricePlanSeeder::class,
        RoleSeeder::class, 
        PermissionTableSeeder::class,
        StudentSeeder::class,
        CreateSuperAdminUserSeeder::class,
        AssetSeeder::class,
        PageSeeder::class,
        OrderSeeder::class,
        OrderItemSeeder::class,
        OrderBillingSeeder::class,
        PaymentSeeder::class,
    ];
    
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Don't send out actual emails during seeder
        config(['mail.default' => 'log']);

        if (config('app.env') == 'testing') {
            $this->call($this->testingSeeders);
        } 
        else {
            $this->call($this->developmentSeeders);
        }
    }
}
