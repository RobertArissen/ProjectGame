ProjectGame for Minor 'Vernieuwend leren met ICT & Games' at Hogeschool Utrecht - University of Applied Sciences

Contributers: @RobertArissen and @ericb97

**Set up project**

`git clone https://github.com/RobertArissen/ProjectGame.git`

setup Laravel Valet development as described on https://laravel.com/docs/5.7/valet

**After clone/new checkout**

`composer install`
`npm install`
`mysql.server start`

**After clone**

`php artisan passport:install`
`php artisan db:seed`

**To run migrations + database seeder (`DatabaseSeeder.php`)**

`php artisan migrate:refresh --seed`

**To develop**

`npm run watch`