1-Composer install
2-php artisan migrate
3-php artisan db:seed --class=AdminUserSeeder

Admin user Credenitals 
admin@admin.com
pass:123456

1-User can register
2-Admin will aprove
3-Only approved users can upload zip files
4-After uploading zip file admin will aprove or reject with comments
5-if admin will approve then user can install
6-Modular Package making an issue on composer but you can install by command

composer require nwidart/laravel-modules

Register the Laravel Modules Service Provider (Nwidart\Modules\LaravelModulesServiceProvider::class,)

php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"

