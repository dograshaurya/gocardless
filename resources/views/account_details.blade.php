<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- Styles -->
      
    </head>
    <body class="antialiased">

    <div class="container"> 
        <div class="row p-3 mt-5"> 
            <h2 class="border-bottom">Open Banking Information</h2>

                <div class="col-md-6"> 
                <span class="mt-5">Account holder name</span>:  <strong>{{$data[0]['details']['account']['ownerName']}}</strong><br/><br/>

                <span class="mt-5">Balance (funds available)</span>: <h2 >£ {{$data[0]['balances']['balances'][0]['balanceAmount']['amount']}}</h2><br/><br/>
                </div>
                <div class="col-md-6 "> 
                <span class="mt-5">Bank</span>:  <strong>{{$data[0]['bankData']['name']}}</strong><br/><br/>
    
                <span class="mt-5">Account holder address</span> : <strong>{{isset($data[0]['details']['account']['ownerAddressUnstructured']) ? $data[0]['details']['account']['ownerAddressUnstructured'] : ''}}</strong><br/>
                </div>

            </div>

           
            @php
                $totalBalance = $data[0]['balances']['balances'][0]['balanceAmount']['amount'];
                $totalIncome = 0;
                $totalOutcome = 0;
                $balance = 0;
            @endphp

                @if(isset($data[0]['transactions']['transactions']['booked']))
                    @foreach($data[0]['transactions']['transactions']['booked'] as $transaction)
                        @php
                            $amount = $transaction['transactionAmount']['amount'];
                            $currency = $transaction['transactionAmount']['currency'];
                        @endphp

                        @if($amount < 0)
                            @php
                                $totalOutcome += abs($amount);
                               
                            @endphp
                        @else
                            @php
                                $totalIncome += $amount;
                            @endphp
                        @endif
                    @endforeach
                    @php
                    $balance_l = $totalBalance + 15 ;
                    @endphp
                @endif
                <div class="row p-3 border-bottom border-top"> 
                    <div class="col-md-6"><span >Total Income </span>: <strong>£ {{ $totalIncome }}</strong></div>
                    <div class="col-md-6"><span>Total Outgoing </span>: <strong>£ {{ $totalOutcome }}</strong></div>
                </div>
            @if(isset($data[0]['transactions']['transactions']['booked']))
                <h2 class="mt-5">Transactions</h2>
                @php
                    $transactions = $data[0]['transactions']['transactions']['booked'];
                    $balances = $data[0]['balances']['balances'];
                    $currentBalance = $balances[0]['balanceAmount']['amount'];
                @endphp
                @if(isset($transactions))
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Date</th>
                                <th>Creditor/Debitor</th>
                                <th>Money In</th>
                                <th>Money Out</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                @php
                                    $transactionId = $transaction['transactionId'];
                                    $bookingDate = $transaction['bookingDate'];
                                    $transactionAmount = $transaction['transactionAmount']['amount'];
                                    $transactionCurrency = $transaction['transactionAmount']['currency'];
                                    
                                @endphp
                                <tr>
                                    <td>{{ $transactionId }}</td>
                                    <td>{{ $bookingDate }}</td>
                                    <td>@if(isset($transaction['debtorName'])){{ $transaction['debtorName'] }}@endif</td>
                                    <td>@if(isset($transaction['debtorName'])) {{ $transactionAmount }} {{ $transactionCurrency }}@endif</td>
                                    <td>@if(!isset($transaction['debtorName'])) {{ $transactionAmount }} {{ $transactionCurrency }}@endif</td>
                                    <td>
                                    
                                    {{ $currentBalance }} {{ $transactionCurrency }}</td>
                                </tr>
                                @php
                                    
                                    $currentBalance += $transactionAmount;
                                    @endphp 
                            
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No booked transactions found.</p>
                @endif
            @endif
            @if(isset($data[0]['transactions']['transactions']['pending']))
                <h2>Pending Transactions</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Value Date</th>
                            <th>Amount</th>
                            <th>Currency</th>
                            <th>Remittance Information</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data[0]['transactions']['transactions']['pending'] as $pendingTransaction)
                            <tr>
                                <td>{{ $pendingTransaction['valueDate'] }}</td>
                                <td>{{ $pendingTransaction['transactionAmount']['amount'] }}</td>
                                <td>{{ $pendingTransaction['transactionAmount']['currency'] }}</td>
                                <td>{{ $pendingTransaction['remittanceInformationUnstructured'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No pending transactions found.</p>
            @endif
          
        </div>
        

        </div>     
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</html>
