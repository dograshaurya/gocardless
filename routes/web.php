<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Services\NordigenService;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/test', [HomeController::class, 'index']);
Route::get('/nord', [HomeController::class, 'nordigen']);

Route::get('/', function (NordigenService $nordigen) {
    $country = "LV";
    $institutions = json_encode($nordigen->getListOfInstitutions($country));
    return view('home', compact('institutions'));
});

Route::get('/agreements/{id}', function (NordigenService $nordigen) {
    $id = request()->route()->parameter('id');
    $redirectUrl = 'http://127.0.0.1:8000/results';
    $data = $nordigen->getSessionData($redirectUrl, 'SANDBOXFINANCE_SFIN0000');
    session(['requisitionId' => $data["requisition_id"]]);
    return redirect()->away($data["link"]);
});


Route::get('/results', function (NordigenService $nordigen) {
    $requisitionId = request()->session()->get('requisitionId');
    if(!$requisitionId) throw new Exception('Requisition id not found.');

    $data = $nordigen->getAccountData($requisitionId);
    return response()->json($data, 200, [], JSON_PRETTY_PRINT)
        ->withHeaders([
            'Accept'=> 'application/json'
        ]);
});