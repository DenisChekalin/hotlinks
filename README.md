#hotlinks
There is a simple hotlink service. Use redis as a main storage.
Laravel version: 8.83.18
Form for creating new hotlink is located by route
http://yourlocalhost/link/create

Running tests command: php artisan test

Docker containers your need from Laradock:
workspace
php-fpm
php-worker
nginx
mysql
redis

Don't forget about 
git clone https://github.com/DenisChekalin/hotlinks.git
composer install
php artisan key:generate

Please set correct REDIS_HOST in your .env file. For ex. for it is:
REDIS_HOST=redis

Enjoy!



