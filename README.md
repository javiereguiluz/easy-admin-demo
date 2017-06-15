EasyAdmin Demo
==============

A Symfony demo backend to show [EasyAdmin](https://github.com/javiereguiluz/EasyAdminBundle) features.

How to install this project
---------------------------

  1. `git clone https://github.com/javiereguiluz/easy-admin-demo`
  1. `cd easy-admin-demo`
  1. `composer install`
  1. Edit `app/config/parameters.yml` and configure
     credentials to acces a database for this demo.
  1. `php bin/console doctrine:database:create`
  1. `php bin/console doctrine:schema:create`
  1. `php bin/console doctrine:fixtures:load --append`
  1. `php bin/console assets:install --symlink`
  1. `php bin/console server:run`
  1. Browse `http://127.0.0.1:8000/admin/`
