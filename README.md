### Cropofil

Share photos in original quality and resolution with your folks :)


#### Installation

`docker-compose up -d`

`./run cropofil-php-fpm composer install`

`./nodejs yarn install`

##### Frontend

`./nodejs yarn watch`

##### Backend

`./php bin/console doctr:migr:migr`

#### Other

`sudo find . -type d -exec chmod a+rwx {} \; && sudo find . -type f -exec chmod a+rw {} \;`

##### Production Notes

`./php composer install`

`./php bin/console doctr:migr:migr`

`./nodejs yarn install`

`./nodejs yarn build`

`./nodejs yarn encore prod`

`cp .env .env.local`

`cp phpdocker/.env phpdocker/.env.local`

`eval `ssh-agent` && ssh-add ~/.ssh/id_rsa_root_github`
