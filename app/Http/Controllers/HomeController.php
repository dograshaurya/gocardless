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

    public function nordigen(){

        $secretId  = "27d0213e-f623-47a6-8ecf-636a95865c1e";
        $secretKey = "0790b3f15a0e6362fdab1bfb193e7a177c72d702aa21444823cb0c4aa04468097ef51e4711d93bd720e9ebf4d461370b85f33fcee3e063cf342a33f7bd9bff09";
        
        $client = new NordigenClient($secretId,$secretKey);

        $token = $client->createAccessToken();
        // Get access token
        $accessToken = $client->getAccessToken();
        // Get refresh token
        $refreshToken = $client->getRefreshToken();

        // Exchange refresh token for new access token
        $newToken = $client->refreshAccessToken($refreshToken);

        // Get list of institutions by country. Country should be in ISO 3166 standard.
        $institutions = $client->institution->getInstitutionsByCountry("LV");
        //dd($institutions);
        // Institution id can be gathered from getInstitutions response.
        // Example Revolut ID
        $institutionId = "AIRWALLEX_AIPTAU32";
        $redirectUri = "https://nordigen.com";

        // Initialize new bank connection session
        $session = $client->initSession($institutionId, $redirectUri);

        // Get link to authorize in the bank
        // Authorize with your bank via this link, to gain access to account data
        $link = $session["link"];
        // requisition id is needed to get accountId in the next step
        $requisitionId = $session["requisition_id"];

        $requisitionData = $client->requisition->getRequisition($requisitionId);

        dd($requisitionData);
        // Get account id from the array of accounts
        $accountId = $requisitionData["accounts"][0];

        // Instantiate account object
        $account = $client->account($accountId);

        // Fetch account metadata
        $metadata = $account->getAccountMetaData();
        // Fetch account balances
        $balances = $account->getAccountBalances();
        // Fetch account details
        $details = $account->getAccountDetails();
        
                //dd($customerBankAccounts,$customer,$transactions);
    }
}
