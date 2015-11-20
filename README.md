# GymStatusInfo

Project for an informing website about gyms, according to the current refugee situation in Germany. Especially in south Germany.

## Development

### Set up the backend and Laravel

- Install VirtualBox or VMWare
- Install Vagrant
- Switch to this repo
- run `vagrant up` to start the VM and the server
- run `vagrant ssh` to login to the virtual machine
- run `PATH=$PATH:~/.composer/vendor/bin` to add Composer to the PATH
- run `cd /var/www/public/core` to change to the core directory
- run `composer install` to install the php dependencies
- create a `.env` file in the `public/core` folder with the contents below
- run `php artisan key:generate` to generate the application key

#### .env file

```
APP_ENV=local
APP_DEBUG=true
APP_KEY=SomeRandomString

DB_HOST=localhost
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

MAIL_DRIVER=smtp
MAIL_HOST=mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
```


### Frontend development

- change to project root with `cd /var/www`
- run `npm install` to install all the dependencies
- run `grunt` to start the watch task


### Connect to the MySQL database

Settings
```
Name:       AnyName
MySQL-Host: localhost
User:       root
Password:   root
Database:   scotchbox

SSH-Host:   192.168.33.10
SSH-User:   vagrant
SSH-Key:    *choose the private_key in the .vagrant folder`
```

#### Update the database tables

- change to the core directory with `cd /var/www/public/core`
- run `php artisan migrate` to create the tables
- run `php artisan migrate:rollback` to rollback the migration

#### Connect Laravel with the database

Edit the `/var/www/public/core/.env` file and set the following settings

```
DB_HOST=localhost
DB_DATABASE=scotchbox
DB_USERNAME=root
DB_PASSWORD=root
```


## Deployment

The gruntfile contains a deploy task to push the files to the deployment server. A .ftppass file is neccessary for deployment!

- create a `.ftpass` file in the project's root
- paste following contents

```json
{
  "user": {
    "username": "foo",
    "password": "bar"
  }
}
```

For the actual login informations, please ask :-)

Happy development!

