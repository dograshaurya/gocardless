# Setup Instructions

1. Run the following command to install dependencies:
   
   composer install
   
2. If not already present, update the following variables in your .env file:

SECRET_ID=8a9472be-0de3-4431-a46b-27aeb1d2609d
   SECRET_KEY=1f0f764a5deeeef7fd582c8286fdca214e2bad127d52fe06eb1323e9f6cf8e637a54741acb1c2e7a25693e8e6445ee840327dc7d0b0a76d120e5d27bf3c64e88
   
Currently, I have generated these keys from your account. If you want to use another account then follow these steps: https://tinyurl.com/ynwedt3f

3. Update the `REDIRECT_URL` variable with the URL of your website. 


REDIRECT_URL=http://127.0.0.1:8000/

Note: It will not work with a local environment.


4. Set `SANDBOX_MODE` to 1 to enable sandbox mode. To disable sandbox mode, replace 1 with 0.

   SANDBOX_MODE=1

5. If you are running this project on a local server, use the following command:
   
   php artisan serve

   This will start the local development server.
