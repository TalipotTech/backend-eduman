## Welcome to Eduman LMS project

## 1. Install project
- Clone project from repository
- Run composer install or update
- Run php artisan migrate
- Run php artisan db:seed
- Run php artisan serve

## 2. Create Migration & Seeder
- php artisan make:seeder RegionSeeder
- php artisan make:migration create_classroom_table
- php artisan make:migration add_author_to_profile_users_table
- php artisan make:migration remove_profile_user_id_to_my_values_table

## 3. Gitflow important commands
- git flow feature start New-Follow-92
- git flow feature finish New-Follow-92

## 4. Create controller
- php artisan make:controller Admin/ClassroomController --resource

## 5. Clear cache
- php artisan cache:clear
- php artisan route:clear
- php artisan config:clear

## 6. Valet run
- valet link eduman
- valet secure eduman

## 7. Swagger documentation
- php artisan l5-swagger:generate