<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GoCardlessPro\Client;
use GoCardlessPro\Services;
use App\Services\NordigenService;
use Nordigen\NordigenPHP\API\NordigenClient;


class HomeController extends Controller
{
    public function index(){

        $access_token = 'sandbox_jJVQ2nnBLOPzf-JZSj3l-Nxyf4e89AyiVgQunq5k';
        $client = new \GoCardlessPro\Client([
          'access_token' => $access_token,
          'environment'  => \GoCardlessPro\Environment::SANDBOX
        ]);
        

        $list = $client->customers()->list();
        //dd($list);
        $customerId = 'CU0011JY696NYQ';
        //$creditor = $client->customer_bank_accounts()->get($creditorId);
        $customerBankAccounts = $client->customerBankAccounts()->get('',[
            'params' => ['customer' => $customerId],
        ]);
        $customer = $client->customers()->get($customerId);
        //$address = $customer->address;
        $transactions = $client->payments()->get('',['params' => ['customer' => $customerId]]);
        
        

        dd($customerBankAccounts,$customer,$transactions);
    }
}
