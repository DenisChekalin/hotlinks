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

Enjoy!



