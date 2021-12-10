<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

//Auth routes
Route::group(['namespace' => 'Auth'], function()
{
	Route::get('/', 'LoginController@index')->name('login');
    Route::get('/admin', 'LoginController@index')->name('admin.login');
    Route::get('logout', 'LoginController@logout')->name('logout');
    Route::resource('login', 'LoginController');

    Route::group(['middleware' => ['admin', 'permission']], function()
    {
        // Role
        Route::resource('roles', 'RoleController');
    });
});

// Admin routes
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['admin', 'permission']], function()
{
    // Dashboard
    Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard');
    Route::get('/pdf/1/download', 'DashboardController@downloadPdf1')->name('admin.download.pdf1');
    Route::get('/pdf/2/download', 'DashboardController@downloadPdf2')->name('admin.download.pdf2');

    // Users
    Route::resource('users', 'UserController');

    // Company
    Route::resource('companies', 'CompanyController');

    // Department
    Route::resource('departments', 'DepartmentController');

    // Warehouse
    Route::resource('warehouses', 'WarehouseController');

    // Custom Module
    Route::get('module/{slug}', 'CustomModuleController@index')->name('custom-module.list');
    Route::get('module/{slug}/create', 'CustomModuleController@create')->name('custom-module.create');
    Route::post('module/{slug}/store', 'CustomModuleController@store')->name('custom-module.store');
    //Route::resource('custom-module', 'CustomModuleController');

    // Module
    Route::get('table/{table_name}/fields', 'ModuleController@getRealtedTableColumns')->name('relation-table.fields');
    Route::resource('modules', 'ModuleController');

    // Module Relationship
    Route::resource('module-relationship', 'ModuleRelationController');

    // Stock
    Route::get('item/{id}/units', 'StockController@getUnits')->name('stock.item.units');
    Route::resource('stocks', 'StockController');
});

Route::group(['prefix' => 'admin/masters', 'namespace' => 'Admin', 'middleware' => 'admin'], function() {

    Route::get('/customer-groups/get-groups-type/{id}', 'CustomerGroupController@getGroupType')->name('customer-groups.groups-type');
    Route::resource('customer-groups', 'CustomerGroupController');

    Route::get('/supplier-groups/get-groups-type/{id}', 'SupplierGroupController@getGroupType')->name('supplier-groups.groups-type');
    Route::resource('supplier-groups', 'SupplierGroupController');

    Route::group(['prefix' => 'account'], function(){
        Route::get('/get-groups-type/{id}', 'GroupController@getGroupType')->name('account.groups-type');
        Route::get('/', 'GroupController@account')->name('masters.account');
        Route::resource('groups', 'GroupController')->except('show');
    });

    Route::group(['prefix' => 'ledger'], function(){
        Route::get('/', 'GroupController@ledger')->name('masters.ledger');

        Route::group(['prefix' => 'sales'], function(){
            Route::get('/delete-consignee-address/{address_id}/{ledger_id}', 'SalesController@delete_consignee_address')->name('sales.delete_consignee_address');
        });
        Route::resource('sales', 'SalesController')->except('show');

        Route::group(['prefix' => 'purchase'], function(){
            Route::get('/delete-consignee-address/{address_id}/{ledger_id}', 'PurchaseController@delete_consignee_address')->name('purchase.delete_consignee_address');
        });
        Route::resource('purchase', 'PurchaseController')->except('show');

        Route::group(['prefix' => 'general'], function(){
            Route::get('/delete-consignee-address/{address_id}/{ledger_id}', 'GeneralController@delete_consignee_address')->name('general.delete_consignee_address');
        });
        Route::resource('general', 'GeneralController')->except('show');

    });

    Route::resource('inventory', 'InventoryController');
    Route::resource('stock-groups', 'StockGroupController');
    Route::resource('stock-categories', 'StockCategoriesController');
    Route::resource('stock-items', 'StockItemController');
    Route::resource('qc-tests', 'QcController');
    Route::resource('batches', 'BatchController');
    Route::resource('bom', 'BomController');
    Route::resource('transporter', 'TransporterController');

});

Route::group(['prefix' => 'admin/transactions', 'namespace' => 'Admin', 'middleware' => 'admin'], function() {
    
    Route::group(['prefix' => 'purchase'], function(){
        Route::get('/', 'TransactionPurchaseController@purchase')->name('transactions.purchase');
        
        Route::get('item_by_id/{id}', 'MaterialController@getStockdetailsById')->name('material.item_by_id');
        Route::get('item_by_pack_code/{pack_code}', 'MaterialController@getStockdetailsByPackcode')->name('material.item_by_pack_code');
        
        Route::group(['prefix' => 'materials'], function(){
            Route::get('/getUnitFronItemId/{item_id}', 'MaterialController@getUnitFronItemId')->name('materials.getUnitFronItemId');
        });

        /*Route::group(['prefix' => 'stockAjax'], function(){
            Route::post('GetStockDetails', 'PurchaseOrderController@GetStockDetails');
        });*/
        
        Route::post('GetStockDetails', 'PurchaseOrderController@GetStockDetails')->name('purchase.stock-details');
        Route::post('getSupplierDetails', 'PurchaseOrderController@getSupplierDetails')->name('purchase.supplier-details');
        Route::post('getPoItemsDetails', 'PurchaseReceiptController@getPoItemsDetails')->name('purchase.poitems-details');
        Route::post('getStockItems', 'PurchaseReceiptController@getStockItems');
        Route::post('getBatchDetails', 'QcReportController@getBatchDetails');
        
        Route::resource('materials', 'MaterialController');
        Route::resource('purchase-order', 'PurchaseOrderController')->except('show');
        Route::resource('purchase-receipt', 'PurchaseReceiptController')->except('show');
        Route::resource('purchase-invoice', 'PurchaseInvoiceController')->except('show');
        Route::resource('purchase-return', 'PurchaseReturnController')->except('show');
        Route::resource('qc-report', 'QcReportController');

        Route::group(['prefix' => 'qc-report'], function(){
            Route::get('/add/{id}/{stock_item_id}', 'QcReportController@add')->name('qc-report.add');
            Route::post('/insert', 'QcReportController@insert')->name('qc-report.insert');
            //Route::get('/reports/{id}', 'QcReportController@reports')->name('qc-report.reports');
        });
       
    });

    Route::group(['prefix' => 'sales'], function(){
        Route::get('/', 'TransactionSalesController@sales')->name('transactions.sales');
        
        Route::resource('quotation', 'QuotationController')->except('show');
        Route::resource('delivery-note', 'DeliveryNoteController')->except('show');
        Route::resource('sales-order', 'SalesOrderController')->except('show');
        Route::resource('sales-invoice', 'SalesInvoiceController')->except('show');
        Route::resource('sales-return', 'SalesReturnController')->except('show');
    });
   
    Route::resource('units', 'InventoryUnitController');
});

Route::group(['prefix' => 'admin/settings', 'namespace' => 'Admin', 'middleware' => 'admin'], function() {

    //Route::get('settings', 'SettingController@index')->name('settings');
    Route::resource('settings-listing', 'SettingController');
    Route::resource('terretory', 'TerretoryController');
    Route::resource('grades', 'GradesController');
});