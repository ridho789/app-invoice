<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\shipmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ShipperController;
use App\Http\Controllers\ShipController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\DescController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AirBillRecapController;
use App\Http\Controllers\AirController;
use App\Http\Controllers\AirShipmentController;
use App\Http\Controllers\BankerController;
use App\Http\Controllers\OriginController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\UomController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\BillRecapController;
use App\Http\Controllers\PricelistController;
use App\Http\Controllers\CasController;
use App\Http\Controllers\HistoryController;

use App\Http\Controllers\LoginController;

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

// Route::get('/', [LoginController::class, 'index'])->name('/');
Route::get('/', function () {
    return view('auth.login');
});

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login-auth', [LoginController::class, 'authenticate']);
Route::get('logout', [LoginController::class, 'logout']);

// Route::get('/dashboard', [DashboardController::class, 'index']);

Route::group(['middleware' => ['auth', 'check.role.user:0']], function () {
    // history
    Route::get('/history', [HistoryController::class, 'index']);
});

Route::group(['middleware' => ['auth', 'check.role.user:0,1']], function () {
    // shipment
    Route::get('/list_shipments', [shipmentController::class, 'index']);

    // sea shipment
    Route::get('/form_sea_shipment', [shipmentController::class, 'createSeaShipment']);
    Route::get('/list_sea_shipment', [shipmentController::class, 'listSeaShipment']);
    Route::get('sea_shipment-edit/{id_sea_shipment}', [shipmentController::class, 'editSeaShipment']);
    Route::post('sea_shipment-store', [shipmentController::class, 'storeSeaShipment']);
    Route::get('sea_shipment-delete/{id_sea_shipment}', [shipmentController::class, 'deleteSeaShipment']);
    Route::post('sea_shipment-multi_delete', [shipmentController::class, 'deleteMultiSeaShipment']);
    Route::post('sea_shipment-update', [shipmentController::class, 'updateSeaShipment']);
    Route::post('import-sea-shipment', [shipmentController::class, 'importSeaShipment']);
    Route::post('print-sea-shipment', [shipmentController::class, 'printSeaShipment']);
    Route::get('/sea_shipment/delete-file/{id}', [shipmentController::class, 'deleteFile'])->name('sea_shipment.delete_file');

    // sea shipment line
    Route::get('sea_shipment_line-delete/{id_sea_shipment_line}', [shipmentController::class, 'deleteSeaShipmentLine']);

    // bill recaps
    Route::get('/list_bill_recap', [BillRecapController::class, 'index']);
    Route::get('/form_bill_recap', [BillRecapController::class, 'create']);
    Route::post('bill_recap-store', [BillRecapController::class, 'store']);
    Route::get('bill_recap-edit/{id_bill_recap}', [BillRecapController::class, 'edit']);
    Route::post('bill_recap-update', [BillRecapController::class, 'update']);

    // company
    Route::get('/company', [CompanyController::class, 'index']);
    Route::post('company-store', [CompanyController::class, 'store']);
    Route::post('company-update', [CompanyController::class, 'update']);

    // customer
    Route::get('/customer', [CustomerController::class, 'index']);
    Route::post('customer-store', [CustomerController::class, 'store']);
    Route::post('customer-update', [CustomerController::class, 'update']);

    // shipper
    Route::get('/shipper', [ShipperController::class, 'index']);
    Route::post('shipper-store', [ShipperController::class, 'store']);
    Route::post('shipper-update', [ShipperController::class, 'update']);

    // ship
    Route::get('/ship', [ShipController::class, 'index']);
    Route::post('ship-store', [ShipController::class, 'store']);
    Route::post('ship-update', [ShipController::class, 'update']);

    // unit
    Route::get('/unit', [UnitController::class, 'index']);
    Route::post('unit-store', [UnitController::class, 'store']);
    Route::post('unit-update', [UnitController::class, 'update']);

    // Desc
    Route::get('/desc', [DescController::class, 'index']);
    Route::post('desc-store', [DescController::class, 'store']);
    Route::post('desc-update', [DescController::class, 'update']);

    // Account
    Route::get('/account', [AccountController::class, 'index']);
    Route::post('account-store', [AccountController::class, 'store']);
    Route::post('account-update', [AccountController::class, 'update']);

    // Banker
    Route::get('/banker', [BankerController::class, 'index']);
    Route::post('banker-store', [BankerController::class, 'store']);
    Route::post('banker-update', [BankerController::class, 'update']);

    // Origin
    Route::get('/origin', [OriginController::class, 'index']);
    Route::post('origin-store', [OriginController::class, 'store']);
    Route::post('origin-update', [OriginController::class, 'update']);

    // State
    Route::get('/state', [StateController::class, 'index']);
    Route::post('state-store', [StateController::class, 'store']);
    Route::post('state-update', [StateController::class, 'update']);

    // Uom
    Route::get('/uom', [UomController::class, 'index']);
    Route::post('uom-store', [UomController::class, 'store']);
    Route::post('uom-update', [UomController::class, 'update']);

    // insurance
    Route::get('/insurance', [InsuranceController::class, 'index']);
    Route::post('insurance-update', [InsuranceController::class, 'update']);
    Route::post('import-insurances', [InsuranceController::class, 'importInsurances']);

    // pricelist
    Route::get('/pricelist', [PricelistController::class, 'index']);
    Route::post('pricelist-store', [PricelistController::class, 'store']);
    Route::post('pricelist-update', [PricelistController::class, 'update']);
    Route::post('import-pricelist', [PricelistController::class, 'importPricelist']);

    // cas
    Route::get('/cas', [CasController::class, 'index']);
    Route::post('cas-store', [CasController::class, 'store']);
    Route::post('cas-update', [CasController::class, 'update']);
    Route::post('import-cas', [CasController::class, 'importCas']);
});


//air shipment
Route::get('/list_shipments', [AirController::class, 'index']);
Route::get('/form_air_shipment', [AirController::class, 'createAirShipment']);
Route::get('/list_air_shipment', [AirController::class, 'listAirShipment']);
Route::post('air_shipment-store', [AirController::class, 'storeAirShipment']);
Route::get('air_shipment-edit/{id_air_shipment}', [AirController::class, 'editAirShipment']);
Route::post('air_shipment-update', [AirController::class, 'updateAirShipment']);
Route::get('air_shipment-delete/{id_air_shipment}', [AirController::class, 'deleteAirShipment']);
Route::post('air_shipment-multi_delete', [AirController::class, 'deleteMultiAirShipment']);
Route::get('/air_shipment/delete-file/{id}', [AirController::class, 'deleteFile'])->name('air_shipment.delete_file');

//Air Shipment Line
Route::get('air_shipment_line-delete/{id_air_shipment_line}', [AirController::class, 'deleteAirShipmentLine']);


Route::get('/list', [AirShipmentController::class, 'index']);
Route::post('import-air-shipment', [AirShipmentController::class, 'importAirShipment']);
Route::post('print-air-shipment', [AirShipmentController::class, 'printAirShipment']);

// air bill recaps
Route::get('/form_bill_recap', [AirBillRecapController::class, 'create']);
Route::post('bill_recap-store', [AirBillRecapController::class, 'store']);
Route::get('bill_recap-editair/{id_air_bill_recap}', [AirBillRecapController::class, 'edit']);
Route::post('air_bill_recap-update', [AirBillRecapController::class, 'update']);


