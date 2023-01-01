
## Laraword
 
Laraword is an open source project that helps to make an article publishing platform with useful features such as: likable comments and articles, followable authors and topics, category and tag for grouping, bookmarking articles and saving them into separate lists named Box and other management tools like user roles, special collections and etc. 

## Installation
***
### Prerequisites
* php  >= 8.0.2
* one of [databases that Laravel Supports](https://laravel.com/docs/9.x/database#introduction)

### Step 1: Clone project and install dependencies
For install, clone this repo and run composer and npm install commands to install project requirements.

```bash
git clone https://github.com/mojtaba-p/laraword.git
cd laraword
composer install
npm install
```

### Step 2: Config environment file
copy **.env.example** file to **.env** file and be sure to fill out information, especially **DB_** config values that you will need in the next step. After that, run this command:
```shell 
php artisan key:generate
```

### Step 3: Migrate tables
for creating database tables run 
```shell 
php artisan migrate
```

### Step 4: Make fake data
if you want to see the result with some fake data that includes users, articles, tags,
categories, collections, comments, likes, bookmarks, and boxes you can run this command:
```shell
php artisan db:seed
```

and if you like to set some thumbnail to articles run:
```shell
php artisan db:seed --class=ArticleThumbnailSeeder
```
But consider **it will take some time and use your internet to download images** 

### Step 5: Build assets
run npm commands
```shell
  npm run dev
```
 or
 ```shell
  npm run build
 ```

## Set Administrator
To set some user role as administrator put the email of the user in `config/laraword` file **admins** array

## License

The Laraword is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
