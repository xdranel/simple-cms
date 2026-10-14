# CMS

A simple Content Management System (CMS) built with Laravel 13, Filament 5.x, and MySQL  

---  

## Features  

### Admin Features
- Manage Categories
- Manage Tags
- Manage Users
- Manage Posts  

### Author Features
- Create Posts
- Edit Posts
- Delete Posts

### General Features
- View Posts
- Search Posts
- Filter Posts  

--- 

## Prerequisites  
- PHP 8.3 or higher
- Laravel 13
- MySQL 8.0  

make sure you have installed all of the above prerequisites.  

## Installation and Setup   
1. **Clone and Navigate**
```bash
git clone https://github.com/xdranel/simple-cms
```
and then
```bash
cd simple-cms
```  
---

2. **Configure Environment**

Copy & paste file `.env.example` and change the file name to `.env` and fill in the required values

or you can do it on terminal
```bash
cp .env.example .env
```  

Required changes in `.env`:  
uncomment the line below
and fill it with your database credentials
```
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```
---

3. **Create Database**

If you using a mysql panel/tools you might want to make it from the panel  
and make database with the name of `value_of_DB_DATABASE`

If you using a cli, you can just use
```bash
mysql -u value_of_DB_USERNAME -p -e "CREATE DATABASE value_of_DB_DATABASE;"
```  
---

4. **Setup Application**

Open Terminal and run:
```bash
composer install
npm install
```
and then
```bash
php artisan key:generate
php artisan migrate:fresh --seed
```
---

5. **Run Application**
```bash
composer run dev
```  
---

6. **Access Application**
```bash
http://localhost:8000/admin
or
http://127.0.0.1:8000/admin
```  
---  

### Existing Account for Testing
you can check on Database/Seeders/DatabaseSeeder.php
- Admin:  
  admin@email.com / password  


- Author :  
  andi@email.com / password  
  siti@email.com / password  
  budi@email.com / password  

