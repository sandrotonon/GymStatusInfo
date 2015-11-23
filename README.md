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
- run `cd /var/www/htdocs/core` to change to the core directory
- run `composer install` to install the php dependencies
- create a `.env` file in the `htdocs/core` folder with the contents below
- run `php artisan key:generate` to generate the application key

#### `.env` file

```
APP_ENV=local
APP_DEBUG=true
APP_KEY=SomeRandomString

DB_HOST=localhost
DB_DATABASE=scotchbox
DB_USERNAME=root
DB_PASSWORD=root

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
- run `gulp` to compile the styles and the scripts
- run `gulp watch` to start the watch task


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
- run `php artisan migrate:refresh`to rollback and create everything clean

#### Fill the database with dummy data

- change to the core directory with `cd /var/www/public/core`
- run `php artisan db:seed` to insert the dummy data


## Deployment

The gruntfile contains a deploy task to push the files to the deployment server. A ftppass.json file is neccessary for deployment!

- create a `ftpass.json` file in the project's root
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

