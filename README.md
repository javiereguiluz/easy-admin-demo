EasyAdmin Demo
==============

A Symfony demo backend to show [EasyAdmin](https://github.com/javiereguiluz/EasyAdminBundle) features.

How to install this project
---------------------------

  1. `git clone https://github.com/javiereguiluz/easy-admin-demo`
  2. `composer install`
  3. Edit `easy-admin-demo/app/config/parameters.yml` and configure
     credentials to acces a database for this demo.
  4. `php app/console doctrine:database:create`
  5. `php app/console doctrine:schema:create`
  6. `php app/console server:run`
  7. Browse `http://127.0.0.1:8000/admin/`

**The backend is still empty because we haven't prepared the data fixtures yet**.
