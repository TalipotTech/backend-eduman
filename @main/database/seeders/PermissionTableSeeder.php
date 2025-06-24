<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
  
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
           'asset-list',
           'asset-create',
           'asset-edit',
           'asset-delete',
           'user-list',
           'user-create',
           'user-edit',
           'user-delete',
           'student-list',
           'student-create',
           'student-edit',
           'student-delete',
           'author-list',
           'author-create',
           'author-edit',
           'author-delete',
           'blog-list',
           'blog-create',
           'blog-edit',
           'blog-delete',
           'category-list',
           'category-create',
           'category-edit',
           'category-delete',
           'classroom-list',
           'classroom-create',
           'classroom-edit',
           'classroom-delete',
           'course-list',
           'course-create',
           'course-edit',
           'course-delete',
           'event-list',
           'event-create',
           'event-edit',
           'event-delete',
           'faq-list',
           'faq-create',
           'faq-edit',
           'faq-delete',
           'invoice-list',
           'invoice-create',
           'invoice-edit',
           'invoice-delete',
           'key_value-list',
           'key_value-create',
           'key_value-edit',
           'key_value-delete',
           'lesson-list',
           'lesson-create',
           'lesson-edit',
           'lesson-delete',
           'menu-list',
           'menu-create',
           'menu-edit',
           'menu-delete',
           'organization-list',
           'organization-create',
           'organization-edit',
           'organization-delete',
           'page-list',
           'page-create',
           'page-edit',
           'page-delete',
           'permission-list',
           'permission-create',
           'permission-edit',
           'permission-delete',
           'price_plan-list',
           'price_plan-create',
           'price_plan-edit',
           'price_plan-delete',
           'quiz-list',
           'quiz-create',
           'quiz-edit',
           'quiz-delete',
           'question-list',
           'question-create',
           'question-edit',
           'question-delete',
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',
           'slider-list',
           'slider-create',
           'slider-edit',
           'slider-delete',
           'testimonial-list',
           'testimonial-create',
           'testimonial-edit',
           'testimonial-delete',
           'topic-list',
           'topic-create',
           'topic-edit',
           'topic-delete'
        ];
     
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
