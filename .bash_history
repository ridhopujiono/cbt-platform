exit
ls
php artisan config:clear
php artisan cache:clear
exit
php artisan config:clear
php artisan cache:clear
exit
cat .env
php artisan config:clear
php artisan optimize:clear
exit
php artisan tinker
php artisan migrate
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=UserAdminSeeder
php artisan db:seed --class=AdminUserSeeder
exit
php artisan migrate:fresh
clear
php artisan db:seed --class=AdminUserSeeder
php artisan tinker
exit
clear
php artisan migrate:fresh
php artisan db:seed --class=AdminUserSeeder
exit
