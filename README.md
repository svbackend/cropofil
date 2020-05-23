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

##### Production Notes

I switched default 80 and 443 ports to 8080 & 1443:
https://www.tecmint.com/change-nginx-port-in-linux/
