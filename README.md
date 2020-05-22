### Cropofil

Share photos in original quality and resolution with your folks :)


#### Installation

`docker-compose up -d`

`./run cropofil-php-fpm composer install`

`./nodejs yarn install`

##### Frontend

`./nodejs yarn watch`

##### Backend

`./php bin/console doctrine:migrate:migrate`

#### Other

`sudo find . -type d -exec chmod a+rwx {} \; && sudo find . -type f -exec chmod a+rw {} \;`
