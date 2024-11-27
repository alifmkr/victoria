# Victoria Family
## Anggota : 
- Muhammad Idris
- Ivanka Audy Ikhwan
- Alif Muhammad Karim

## Project :
Wep aplikasi kasir toko buah melon

## How to Run in Local :
- First Clone this repo
- Run "composer install" to install dependencies
- Create Database name "wf_victoria"
- Run Migration with "php artisan migrate"
- Run Seeder with "php artisan db:seed", and you can see 20 row in products
- Create file .env, and update the database and mail configuration
- And lastly you can run your project with "php artisan serve"

## Create .env
- Duplicate .env.example file and rename with .en
- Update database configuration, update DB_PORT with 3306 as default mysql port, username and your password dba account
- Update mail configuration with your email and password, use smtp.gmail.com, update port to 587, encryption with tls
- Before run the project, make sure your email account sudah mengaktifkan "Izinkan aplikasi yang kurang aman" atau "Allow acces application not secure".
