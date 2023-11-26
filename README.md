# Setup Instructions

1. Run the following command to install dependencies:
   
   composer install
   
2. Update the following variables in your .env file:

SECRET_ID=XXXXXX
SECRET_KEY=XXXXX
   
Currently, I have generated these keys from your account. If you want to use another account then follow these steps: https://tinyurl.com/ynwedt3f

3. Update the `REDIRECT_URL` variable with the URL of your website. 


REDIRECT_URL=http://127.0.0.1:8000/

Note: It will not work in a local environment.

4. Set `SANDBOX_MODE` to 1 to enable sandbox mode. To disable sandbox mode, replace 1 with 0.

   SANDBOX_MODE=1

5. If you are running this project on a local server, use the following command:
   
   php artisan serve

   This will start the local development server.
