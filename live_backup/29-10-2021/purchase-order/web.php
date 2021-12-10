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
    Route::get('main/dashboard','DashboardController@mainDashboard');
    Route::get('/chart','DashboardController@chart')->name('admin.chart');
    Route::post('stockitemdata','DashboardController@stockitemdata')->name('stockitem.data');
    Route::get('/pdf/1/download', 'DashboardController@downloadPdf1')->name('admin.download.pdf1');
    Route::get('/pdf/2/download', 'DashboardController@downloadPdf2')->name('admin.download.pdf2');

    // Users
    Route::resource('users', 'UserController');

    // Company
    Route::resource('companies', 'CompanyController');

    // Department
    Route::resource('departments', 'DepartmentController');

    //Series
    //Route::resource('series','SeriesController');
    Route::get('allseries','SeriesController@allseries')->name('allseries');
    // Warehouse
    Route::group(['prefix' => 'series'], function(){
        //Route::resource('purchasereciept','PurchaseRecieptSeriesController')->except('show');
        Route::resource('material','SeriesController');
        Route::resource('purchaseorder','PurchaseorderseriesController');
        Route::get('purchaseorderseriesdata/{id}','PurchaseorderseriesController@getdata');
        Route::resource('purchasereciept','PurchaseRecieptSeriesController');
        Route::get('purchasereceiptdata/{id}','PurchaseRecieptSeriesController@getdata');
        Route::resource('purchaseinvoice','PurchaseInvoiceSeriesController');
        Route::get('purchaseinvoiceseriesdata/{id}','PurchaseInvoiceSeriesController@getdata');
        Route::resource('purchasereturn','PurchaseReturnSeriesController');
        Route::get('purchasereturnseriesdata/{id}','PurchaseReturnSeriesController@getdata');
        Route::resource('quotation-series','QuotationSeriesController');
        Route::get('quotationseriesdata/{id}','QuotationSeriesController@getdata');
        Route::resource('salesorder','SalesOrderSeriesController');

        Route::get('salesorderseriesdata/{id}','SalesOrderSeriesController@getdata');

        Route::resource('deliveryseries','DeliveryNoteSeriesController');

        Route::get('deliveryseriesdata/{id}','DeliveryNoteSeriesController@getdata');

        Route::resource('salesinvoice','SalesInvoiceSeriesController');
        Route::get('salesinvoiceseriesdata/{id}','SalesInvoiceSeriesController@getdata');
        Route::resource('salesreturn','SalesReturnSeriesController');
        Route::get('salesreturnseriesdata/{id}','SalesReturnSeriesController@getdata');
        Route::resource('productionplan','ProductionPlanSeriesController');
        Route::get('productionplanseries/{id}','ProductionPlanSeriesController@getdata');
        Route::resource('workorder','WorkOrderSeriesController');
        Route::get('workorderseries/{id}','WorkOrderSeriesController@getdata');
        Route::resource('stocktransfer','StockSeriesController');
        Route::get('stockseriesdata/{id}','StockSeriesController@getdata');
        Route::resource('customer','CustomerSeriesController');
        Route::get('getdata/{id}','CustomerSeriesController@getdata');
        Route::resource('supplier','SupplierSeriesController');
        Route::get('supplierdata/{id}','SupplierSeriesController@getdata');
        Route::get('materialseriesdata/{id}','SeriesController@getdata');
    });

    Route::resource('warehouses', 'WarehouseController');
    Route::post('/warehouse/insert','WarehouseController@insert')->name('warehouse.insert');

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
    Route::get('warehouse_stock/{stock_id}/{warehouse_id}/batches', 'StockController@getBatch')->name('stock.warehouse_stock.batches');

    // Stock Quantity Management
    Route::get('warehouse_stock_available_qty/{stock_id}/{warehouse_id}/{batch_id}/qty', 'StockController@getAvailableQty')->name('stock.warehouse_stock.batches');
    Route::get('stock_bom/{id}', 'ProductionPlanController@stockBom')->name('production-plan.stock_bom');
    //Route::get('bom_items/{id}', 'ProductionPlanController@bomItems')->name('production-plan.bom_items');
    Route::get('bom_items/{id}', 'ProductionPlanController@bomItems')->name('production-plan.bom_items');
    Route::get('plan_quantity_calc/{bom_id}/{quantity}', 'ProductionPlanController@planQuantityCalc')->name('production-plan.plan_quantity_calc');
    Route::get('production_plan_items/{id}', 'WorkOrderController@planItems')->name('work-order.production_plan_items');
    Route::get('sales_ledger_details/{id}', 'QuotationController@customerDetails')->name('quotation.sales_ledger_details');

    Route::get('stock_batch/{id}', 'ProductionPlanController@stockBatch')->name('production-plan.stock_batch');

    Route::resource('stocks', 'StockController');
    Route::get('stockdata/{id}','StockController@getdata');
    Route::get('stocksourceitemdata','StockController@stockSourceItemData');
    Route::get('stockaddmorevalue','StockController@addMoreValue');
});

Route::group(['prefix' => 'admin/masters', 'namespace' => 'Admin', 'middleware' => 'admin'], function() {

    Route::get('/customer-groups/get-groups-type/{id}', 'CustomerGroupController@getGroupType')->name('customer-groups.groups-type');
    Route::resource('customer-groups', 'CustomerGroupController');

    Route::post('customer/groups/save', 'CustomerGroupController@insert')->name('customer-groups.insert');    


    Route::get('/supplier-groups/get-groups-type/{id}', 'SupplierGroupController@getGroupType')->name('supplier-groups.groups-type');
    Route::post('supplierimport','SupplierGroupController@postImport')->name('supplier.import');
    Route::resource('supplier-groups', 'SupplierGroupController');
    
    Route::post('/insert', 'SupplierGroupController@insert')->name('supplier-groups.insert');    

    Route::group(['prefix' => 'account'], function(){
        Route::get('/get-groups-type/{id}', 'GroupController@getGroupType')->name('account.groups-type');
        Route::get('/', 'GroupController@account')->name('masters.account');
        Route::resource('groups', 'GroupController')->except('show');
        Route::post('groups/insert', 'GroupController@insert')->name('groups.insert');
        Route::post('api/fetch-groups','GroupController@fetchgroup');
    });

    Route::group(['prefix' => 'ledger'], function(){
        Route::get('/', 'GroupController@ledger')->name('masters.ledger');

        Route::group(['prefix' => 'sales'], function(){
            Route::get('/delete-consignee-address/{address_id}/{ledger_id}', 'SalesController@delete_consignee_address')->name('sales.delete_consignee_address');
        });
        Route::resource('sales', 'SalesController')->except('show');
        Route::post('sales/import','SalesController@import')->name('sales.import');
        Route::post('api/fetch-cities','SalesController@fetchcity');
        

        Route::group(['prefix' => 'purchase'], function(){
            Route::get('/delete-consignee-address/{address_id}/{ledger_id}', 'PurchaseController@delete_consignee_address')->name('purchase.delete_consignee_address');
        });
        Route::resource('purchase', 'PurchaseController')->except('show');
        Route::post('purchase/import','PurchaseController@import')->name('purchase.import');

        Route::group(['prefix' => 'general'], function(){
            Route::get('/delete-consignee-address/{address_id}/{ledger_id}', 'GeneralController@delete_consignee_address')->name('general.delete_consignee_address');
        });
        Route::resource('general', 'GeneralController')->except('show');
        Route::post('general/import', 'GeneralController@import')->name('general.import');

    });

    Route::resource('inventory', 'InventoryController');
    Route::resource('stock-groups', 'StockGroupController');
    Route::post('stockgroup/import','StockGroupController@import')->name('stock-groups.import');
    Route::resource('stock-categories', 'StockCategoriesController');
    Route::post('stockcategories/import','StockCategoriesController@import')->name('stock-categories.import');
    Route::resource('stock-items', 'StockItemController');
    Route::post('stockitem/import','StockItemController@import')->name('stock-items.import');
    Route::resource('batches', 'BatchController');
    Route::post('/batches/import','BatchController@import')->name('batches.import');
    Route::resource('bom', 'BomController');
    Route::post('bom/import','BomController@import')->name('bom.import');
    Route::resource('transporter', 'TransporterController');
    Route::post('/transporter/insert','TransporterController@insert')->name('transporter.insert');

});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'admin'], function() {
    Route::resource('qc-tests', 'QcController');

    Route::resource('qc-report', 'QcReportController');
    Route::group(['prefix' => 'qc-report'], function(){
        Route::get('/add/{id}/{stock_item_id}', 'QcReportController@add')->name('qc-report.add');
        Route::post('/insert', 'QcReportController@insert')->name('qc-report.insert');
        Route::get('/view/{id}', 'QcReportController@view')->name('qc-report.view');
        Route::put('/reset_purchase_receipt_basic_info/{id}', 'QcReportController@reset_purchase_receipt_basic_info')->name('qc-report.reset_purchase_receipt_basic_info');
        Route::get('/{qc_report_id}/print', 'QcReportController@print')->name('qc-report.print');
         //Route::get('/reports/{id}', 'QcReportController@reports')->name('qc-report.reports');

        Route::get('workorder/{id}', 'QcReportController@showWorkOrders')->name('qc-report.workorder.show');
        Route::get('/add-workorder/{id}/{stock_item_id}', 'QcReportController@addWorkOrdersQc')->name('qc-report.add.work-order');
        Route::post('/add-workorder/insert', 'QcReportController@insertWorkOrdersQc')->name('qc-report.work-order.insert');
        Route::get('/workorder/view/{id}', 'QcReportController@viewWorkOrderQc')->name('qc-report.workorder.view');
        Route::delete('/workorder/{id}/destroy', 'QcReportController@destroyWorkOrderQc')->name('qc-report.work-order.destroy');
        Route::get('/workorder/{id}/print', 'QcReportController@printWorkOrder')->name('qc-report.workorder.print');
    });

    Route::resource('payments', 'PaymentController');
    Route::get('get_payment_invoice/{voucher_id}/{against}', 'PaymentController@getInvoice')->name('payments.get_payment_invoice');
    Route::get('get_payment_voucher/{invoice_id}/{against}', 'PaymentController@getVoucher')->name('payments.get_payment_voucher');
    Route::get('get_agaist_dropdown_value/{party_type}/{party}', 'PaymentController@getAgaistDropdownValue')->name('payments.get_agaist_dropdown_value');
    Route::get('get_payment_invoice_details/{invoice_no}/{party_type}/{party}', 'PaymentController@getPaymentInvoiceDetails')->name('payments.get_payment_invoice_details');
    Route::get('show_user_balance/{party_type}/{party}', 'PaymentController@showUserBalance')->name('payments.show_user_balance');
    
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
        Route::post('getMaterialItemDetails', 'PurchaseOrderController@getMaterialItemDetails')->name('purchase.material-item-details');
        Route::post('GetStockDetails', 'PurchaseOrderController@GetStockDetails')->name('purchase.stock-details');
        Route::post('getSupplierDetails', 'PurchaseOrderController@getSupplierDetails')->name('purchase.supplier-details');
        Route::post('getAddressDetails','PurchaseOrderController@getAddressDetails');
        Route::post('getPoItemsDetails', 'PurchaseReceiptController@getPoItemsDetails')->name('purchase.poitems-details');
        Route::post('getReceiptDetails', 'PurchaseReceiptController@getReceiptDetails');
        Route::post('getOrderDetails', 'PurchaseInvoiceController@getPurchaseOrderDetails');
        Route::post('getInvoiceDetails', 'PurchaseReturnController@getPurchaseReturnDetails');
        Route::post('getStockItems', 'PurchaseReceiptController@getStockItems');
        Route::post('getBatchDetails', 'QcReportController@getBatchDetails');
        Route::post('getDetailsFromGrade', 'QcReportController@getDetailsFromGrade');

        Route::resource('materials', 'MaterialController');
        Route::get('materials/getdata/{id}/','MaterialController@getdata');
        Route::get('materials/createPurchaseOrder/{id}','MaterialController@createPurchaseOrder');
        Route::get('getstatus','MaterialController@testdata');

        Route::get('purchase-order/{id}/print', 'PurchaseOrderController@print')->name('purchase-order.print');
        Route::resource('purchase-order', 'PurchaseOrderController');
        Route::get('export','PurchaseOrderController@export');
        Route::get('purchase-order/getdata/{id}/','PurchaseOrderController@getdata');
        Route::get('purchase-receipt/{id}/print', 'PurchaseReceiptController@print')->name('purchase-receipt.print');
        Route::resource('purchase-receipt', 'PurchaseReceiptController');
        Route::get('purchase-receipt/getdata/{id}/','PurchaseReceiptController@getdata');
        Route::get('purchase-invoice/{id}/print', 'PurchaseInvoiceController@print')->name('purchase-invoice.print');
        Route::resource('purchase-invoice', 'PurchaseInvoiceController');
        Route::get('purchase-invoice/getdata/{id}/','PurchaseInvoiceController@getdata');
        Route::resource('purchase-return', 'PurchaseReturnController');
        Route::get('purchase-return.print/{id}/print','PurchaseReturnController@print')->name('purchase-return.print');
        Route::get('purchase-return/getdata/{id}/','PurchaseReturnController@getdata');

    });

    Route::group(['prefix' => 'sales'], function(){
        Route::get('/', 'TransactionSalesController@sales')->name('transactions.sales');

        Route::get('quotation/{id}/print', 'QuotationController@print')->name('quotation.print');
        Route::resource('quotation', 'QuotationController');
        Route::get('quotation/getdata/{id}/','QuotationController@getdata');
        Route::post('getSalesAddressDetails','QuotationController@getSalesAddressDetails');
        Route::resource('delivery-note', 'DeliveryNoteController');
        Route::post('getNoteSalesOrderDetails', 'DeliveryNoteController@getNoteSalesOrderDetails');
        Route::get('delivery-note.print/{id}/print','DeliveryNoteController@print')->name('delivery-note.print');
        

        Route::post('getQuotationDetails', 'SalesOrderController@getQuotationDetails');
        Route::get('sales-order/{id}/print', 'SalesOrderController@print')->name('sales-order.print');
        Route::resource('sales-order', 'SalesOrderController');

        Route::get('salesorder/getdata/{id}/','SalesOrderController@getdata');
        
        Route::get('sales-invoice/{id}/print', 'SalesInvoiceController@print')->name('sales-invoice.print');
        Route::resource('sales-invoice', 'SalesInvoiceController');
        Route::get('salesinvoice/getdata/{id}/','SalesInvoiceController@getdata');
        Route::resource('sales-return', 'SalesReturnController');
        Route::get('salesreturn/getdata/{id}/','SalesReturnController@getdata');
        Route::get('sales-return.print/{id}/print','SalesReturnController@print')->name('sales-return.print');
        Route::post('getSalesOrderDetails', 'SalesInvoiceController@getSalesOrderDetails');

        Route::post('getSalesInvoiceDetails', 'SalesReturnController@getSalesReturnDetails')->name('sales.invoice-details');
    });

    Route::resource('units', 'InventoryUnitController');
    Route::post('units/import','InventoryUnitController@import')->name('units.import');
});

Route::group(['prefix' => 'admin/manufacturing', 'namespace' => 'Admin', 'middleware' => 'admin'], function() {
    Route::resource('production-plan', 'ProductionPlanController');
    Route::get('productionplan/getdata/{id}','ProductionPlanController@getdata');
    Route::resource('work-order', 'WorkOrderController');
    Route::get('workorder/getdata/{id}','WorkOrderController@getdata');

    Route::group(['prefix' => 'work-order'], function(){
        Route::get('order_to_execute/{work_order_id}/{plan_id}', 'WorkOrderController@OrdertoExecute')->name('work-order.order_to_execute');
        Route::get('order_to_process/{work_order_id}/{plan_id}', 'WorkOrderController@OrdertoProcess')->name('work-order.order_to_process');
    });

});

Route::group(['prefix' => 'admin/settings', 'namespace' => 'Admin', 'middleware' => 'admin'], function() {

    //Route::get('settings', 'SettingController@index')->name('settings');
    Route::resource('settings-listing', 'SettingController');
    Route::resource('terretory', 'TerretoryController');
    Route::resource('grades', 'GradesController');
});

Route::group(['prefix' => 'admin/reports', 'namespace' => 'Admin', 'middleware' => 'admin'], function() {
    Route::resource('stock-ledger', 'StockReportController');
    //Route::get('stock-ledger', 'StockReportController@index');
    Route::resource('payment-report', 'PaymentReportController');

    Route::resource('sales-report', 'SalesReportController');

    Route::resource('purchase-report', 'PurchaseReportController');
});
