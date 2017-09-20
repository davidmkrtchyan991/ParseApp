# ParseApp

1. Clone the project
    ```shell
    git clone https://github.com/davidmkrtchyan991/ParseApp.git
    ```
2. Enter into folder (Note: the folder name is Captalized)
    ```shell
    cd ParseApp
    ```
3. Copy .env.example and save as .env
4. Create Database and write the name and accesses into .env
5. Install the composer
    ```shell
    composer install
    ```
6. Install npm
    ```shell
    npm install
    ```
7. Migarate tables
    ```shell
    php artisan migrate
    ```
8. Note: sometimes fresh laravel needs to generate a key
    ```shell
    php artisan key:generate
    ```
9. Run the project. Enjoy)
    ```shell
    php artisan serve
    ```
Note: There are few structure issues and optimizations, that should be done such as
validating, checking url, curl status, asynchronous requests etc. I tryed to finish 
the task ASAP, so that cases and any input data I suppose to be correct. Thank You.