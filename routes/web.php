<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {  
    return view('auth.login');
});


Route::get('clear', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('storage:link');
    return 'DONE'; //Return anything
});



Auth::routes();

/////////////////Backend Route////////////////////
Route::group(['middleware' => ['web','auth']], function()
{

	Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');


	    Route::group(['prefix'=>'user'], function(){
            Route::get('index','UserController@index')->name('user.index');
            Route::get('create','UserController@create')->name('user.create');
            Route::post('store','UserController@store')->name('user.store');
            Route::get('edit/{id}','UserController@edit')->name('user.edit');
            Route::post('update/{id}','UserController@update')->name('user.update');
            Route::get('destroy/{id}','UserController@destroy')->name('user.destroy');
        });


/*        attendance */

          Route::group(['prefix'=>'attendance'], function(){
            Route::get('index','AttendanceController@index')->name('attendance.index');
            Route::get('create','AttendanceController@create')->name('attendance.create');
            Route::post('store','AttendanceController@store')->name('attendance.store');
            Route::get('edit/{id}','AttendanceController@edit')->name('attendance.edit');
            Route::post('update/{id}','AttendanceController@update')->name('attendance.update');
            Route::get('destroy/{id}','AttendanceController@destroy')->name('attendance.destroy');

            Route::get('reports','AttendanceController@reports')->name('attendance.reports');
        });


        // reference
        Route::group(['prefix'=>'reference'], function(){
            Route::get('index','ReferenceController@index')->name('reference.index');
            Route::get('create','ReferenceController@create')->name('reference.create');
            Route::post('store','ReferenceController@store')->name('reference.store');
            Route::get('edit/{id}','ReferenceController@edit')->name('reference.edit');
            Route::get('show/{id}','ReferenceController@show')->name('reference.show');
            Route::post('update/{id}','ReferenceController@update')->name('reference.update');
            Route::get('destroy/{id}','ReferenceController@destroy')->name('reference.destroy');

            Route::get('reports','ReferenceController@reports')->name('reference.reports');
        });















        // Damage
         Route::group(['prefix'=>'damage'], function(){
            Route::get('index','DamageController@index')->name('damage.index');
            Route::get('create','DamageController@create')->name('damage.create');
            Route::post('store','DamageController@store')->name('damage.store');
            Route::get('edit/{id}','DamageController@edit')->name('damage.edit');
            Route::get('show/{id}','DamageController@show')->name('damage.show');
            Route::post('update/{id}','DamageController@update')->name('damage.update');
            Route::get('destroy/{id}','DamageController@destroy')->name('damage.destroy');

            Route::get('reports','DamageController@reports')->name('damage.reports');


            Route::get('supplier/product','DamageController@findsupplierproduct')->name('find.supplier.product');

        });




        /// Reports
        Route::group(['prefix'=>'report'], function(){
            Route::get('daily/summery','ReportController@dailysummery')->name('report.daily.summery');

        });












	    /// setting
        Route::group(['prefix'=>'setting'], function(){
            Route::get('index','SettingController@index')->name('setting.index');
            Route::get('create','SettingController@create')->name('setting.create');
            Route::post('store','SettingController@store')->name('setting.store');
            Route::get('edit/{id}','SettingController@edit')->name('setting.edit');
            Route::post('update/{id}','SettingController@update')->name('setting.update');
            Route::get('destroy/{id}','SettingController@destroy')->name('setting.destroy');
        });

        // Business Type
        Route::group(['prefix'=>'businesstype'], function(){
            Route::get('index','BusinessTypeController@index')->name('businesstype.index');
            Route::get('create','BusinessTypeController@create')->name('businesstype.create');
            Route::post('store','BusinessTypeController@store')->name('businesstype.store');
            Route::get('edit/{id}','BusinessTypeController@edit')->name('businesstype.edit');
            Route::post('update/{id}','BusinessTypeController@update')->name('businesstype.update');
            Route::get('destroy/{id}','BusinessTypeController@destroy')->name('businesstype.destroy');
        });


        /// Brunch
        Route::group(['prefix'=>'brunch'], function(){
            Route::get('index','BrunchController@index')->name('brunch.index');
            Route::get('create','BrunchController@create')->name('brunch.create');
            Route::post('store','BrunchController@store')->name('brunch.store');
            Route::get('edit/{id}','BrunchController@edit')->name('brunch.edit');
            Route::post('update/{id}','BrunchController@update')->name('brunch.update');
            Route::get('destroy/{id}','BrunchController@destroy')->name('brunch.destroy');
        });



         /// Brand
        Route::group(['prefix'=>'group'], function(){
            Route::get('index','GroupController@index')->name('group.index');
            Route::get('create','GroupController@create')->name('group.create');
            Route::post('store','GroupController@store')->name('group.store');
            Route::get('edit/{id}','GroupController@edit')->name('group.edit');
            Route::post('update/{id}','GroupController@update')->name('group.update');
            Route::get('destroy/{id}','GroupController@destroy')->name('group.destroy');


             /**Unit PDF  */
            Route::get('pdf/download','GroupController@groupPdfDownload')->name('groupPdfDownload');
            /**Unit PDF  */

        });


        /// Brand
        Route::group(['prefix'=>'brand'], function(){
            Route::get('index','BrandController@index')->name('brand.index');
            Route::get('create','BrandController@create')->name('brand.create');
            Route::post('store','BrandController@store')->name('brand.store');
            Route::get('edit/{id}','BrandController@edit')->name('brand.edit');
            Route::post('update/{id}','BrandController@update')->name('brand.update');
            Route::get('destroy/{id}','BrandController@destroy')->name('brand.destroy');

            /**Unit PDF  */
            Route::get('pdf/download','BrandController@brandPdfDownload')->name('brandPdfDownload');
            /**Unit PDF  */
        });




        // category
        Route::group(['prefix'=>'category'], function(){
            Route::get('index','CategoryController@index')->name('category.index');
            Route::get('create','CategoryController@create')->name('category.create');
            Route::post('store','CategoryController@store')->name('category.store');
            Route::get('edit/{id}','CategoryController@edit')->name('category.edit');
            Route::post('update/{id}','CategoryController@update')->name('category.update');
            Route::get('destroy/{id}','CategoryController@destroy')->name('category.destroy');

            /**Unit PDF  */
            Route::get('pdf/download','CategoryController@categoryPdfDownload')->name('categoryPdfDownload');
            /**Unit PDF  */
        });


        /// Color
        Route::group(['prefix'=>'color'], function(){
            Route::get('index','ColorController@index')->name('color.index');
            Route::get('create','ColorController@create')->name('color.create');
            Route::post('store','ColorController@store')->name('color.store');
            Route::get('edit/{id}','ColorController@edit')->name('color.edit');
            Route::post('update/{id}','ColorController@update')->name('color.update');
            Route::get('destroy/{id}','ColorController@destroy')->name('color.destroy');
        });


        /// setting
        Route::group(['prefix'=>'weight'], function(){
            Route::get('index','WeightController@index')->name('weight.index');
            Route::get('create','WeightController@create')->name('weight.create');
            Route::post('store','WeightController@store')->name('weight.store');
            Route::get('edit/{id}','WeightController@edit')->name('weight.edit');
            Route::post('update/{id}','WeightController@update')->name('weight.update');
            Route::get('destroy/{id}','WeightController@destroy')->name('weight.destroy');
        });


        //size
        Route::group(['prefix'=>'size'], function(){
            Route::get('index','SizeController@index')->name('size.index');
            Route::get('create','SizeController@create')->name('size.create');
            Route::post('store','SizeController@store')->name('size.store');
            Route::get('edit/{id}','SizeController@edit')->name('size.edit');
            Route::post('update/{id}','SizeController@update')->name('size.update');
            Route::get('destroy/{id}','SizeController@destroy')->name('size.destroy');
        });

        // unit
        Route::group(['prefix'=>'unit'], function(){
            Route::get('index','UnitController@index')->name('unit.index');
            Route::get('create','UnitController@create')->name('unit.create');
            Route::post('store','UnitController@store')->name('unit.store');
            Route::get('edit/{id}','UnitController@edit')->name('unit.edit');
            Route::post('update/{id}','UnitController@update')->name('unit.update');
            Route::get('destroy/{id}','UnitController@destroy')->name('unit.destroy');

            /**Unit PDF  */
            Route::get('pdf/download','UnitController@unitPdfDownload')->name('unitPdfDownload');
            /**Unit PDF  */
        });

        // Proudcts
        Route::group(['prefix'=>'product'], function(){
            Route::get('index','ProductController@index')->name('product.index');
            Route::get('create','ProductController@create')->name('product.create');
            Route::post('store','ProductController@store')->name('product.store');
            Route::get('edit/{id}','ProductController@edit')->name('product.edit');
            Route::post('update/{id}','ProductController@update')->name('product.update');
            Route::get('destroy/{id}','ProductController@destroy')->name('product.destroy');
            Route::get('show/{id}','ProductController@show')->name('product.show');
            
            
            
           // multiple product upload
            
            Route::get('multiple/create/{supplier_id}','ProductController@multipleproduct')->name('product.multiple.create');
            Route::post('multiple/store','ProductController@multipleproductstore')->name('product.multiple.store');


            
            


            Route::get('product/supplier/{id}','ProductController@supplierproduct')->name('product.supplier');
            Route::post('product/supplier/update','ProductController@supplierupdateproduct')->name('product.supplier.update');

            /**Product Excel Fle upload */
            Route::get('upload/button/for/excel/file','ProductController@excel_file_uploadable_modal')->name('excel_file_uploadable_modal');


            Route::post('upload/excel/file','ProductController@excel_file_upload')->name('product_excel_file_upload');

            /**export */
            Route::post('list/export','ProductController@product_list_export')->name('product_list_export');
            /**update price */
            Route::get('update/price/{id}','ProductController@updatePrice')->name('updatePrice');
            Route::post('price/update/{id}','ProductController@updatePriceStore')->name('updatePriceStore');
        });

        // Proudcts/Ajax
        Route::group(['prefix'=>'product','namespace'=> 'Product'], function(){
            Route::post('create/supplier','AjaxController@supplierCreateByAjax')->name('supplierCreateByAjax');
            Route::post('create/category','AjaxController@categoryCreateByAjax')->name('categoryCreateByAjax');
            Route::post('create/brand','AjaxController@breandCreateByAjax')->name('breandCreateByAjax');
            Route::post('create/unit','AjaxController@unitCreateByAjax')->name('unitCreateByAjax');
        });


        // ProudctImage
        Route::group(['prefix'=>'product'], function(){
            Route::get('index','ProductController@index')->name('product.index');
            Route::get('create','ProductController@create')->name('product.create');
            Route::post('store','ProductController@store')->name('product.store');
            Route::get('edit/{id}','ProductController@edit')->name('product.edit');
            Route::post('update/{id}','ProductController@update')->name('product.update');
            Route::get('destroy/{id}','ProductController@destroy')->name('product.destroy');
        });


        /*Customer & Supplier*/
        Route::group(['as'=>'customer.supplier.','prefix'=>'customerSupplier'], function(){
            Route::get('/view','CustomerSupplierController@index')->name('index');
            Route::get('/create','CustomerSupplierController@create')->name('create');
            Route::post('/store','CustomerSupplierController@store')->name('store');
            Route::get('/edit/{id}','CustomerSupplierController@edit')->name('edit');
            Route::post('/update/{id}','CustomerSupplierController@update')->name('update');
            Route::get('/destroy/{id}','CustomerSupplierController@destroy')->name('destroy');
        });


           // Supplier
        Route::group(['prefix'=>'supplier'], function(){
            Route::get('index','SupplierController@index')->name('supplier.index');
            Route::get('create','SupplierController@create')->name('supplier.create');
            Route::post('store','SupplierController@store')->name('supplier.store');
            Route::get('edit/{id}','SupplierController@edit')->name('supplier.edit');
            Route::get('show/{id}','SupplierController@show')->name('supplier.show');
            Route::post('update/{id}','SupplierController@update')->name('supplier.update');
            Route::get('destroy/{id}','SupplierController@destroy')->name('supplier.destroy');

            //supplier report
            Route::get('list/export','SupplierController@supplierListExport')->name('supplierListExport');

            Route::get('purchase/report','SupplierController@supplierPurchaseReport')->name('supplierPurchaseReport');
            Route::get('purchase/report/export','SupplierController@supplierPurchaseReportexport')->name('supplierPurchaseReportexport');


            /*for demand order and damage and payment */

            Route::get('damage/{id}','SupplierController@damage')->name('supplier.damage');
            Route::get('demand/order/{id}','SupplierController@demandorder')->name('supplier.demand.order');
            Route::get('paymenthistory/{id}','SupplierController@paymenthistory')->name('supplier.paymenthistory');


        });


    // Customer
        Route::group(['prefix'=>'customer'], function(){

            Route::get('index','CustomerController@index')->name('customer.index');
            Route::get('walk/customer','CustomerController@walkindex')->name('customer.walk.index');


            Route::get('create','CustomerController@create')->name('customer.create');
            Route::post('store','CustomerController@store')->name('customer.store');
            Route::get('edit/{id}','CustomerController@edit')->name('customer.edit');
            Route::get('show/{id}','CustomerController@show')->name('customer.show');
            Route::post('update/{id}','CustomerController@update')->name('customer.update');
            Route::get('destroy/{id}','CustomerController@destroy')->name('customer.destroy');

            Route::get('export','CustomerController@customerexport')->name('customer.export');

            //customer report
            Route::get('sale/report','CustomerController@saleReport')->name('customer.saleReport');
            Route::get('sale/report/export','CustomerController@customerSaleReportexport')->name('customerSaleReportexport');

            /**create customer by ajax */
            Route::post('create/by/ajax','CustomerController@createCustomerByAjax')->name('createCustomerByAjax');
            /**create customer by ajax */

                 
             Route::get('payment/history/{id}','CustomerController@paymenthistory')->name('customer.payment.history'); 


             Route::post('payment/history/export/{id}','CustomerController@paymenthistoryexport')->name('customer.payment.history.export');





        });

        /*  =====================        account  ==========================================*/
        Route::group(['as'=>'admin.','prefix'=>'order/by','namespace'=>'Backend'], function(){
            Route::resource('reference', 'ReferenceController');
        });




        Route::group(['as'=>'customer.loan.','prefix'=>'customer/loan'],function(){

            Route::get('/view','LoanController@index')->name('index');
            Route::get('/create','LoanController@create')->name('create');
            Route::post('/store','LoanController@store')->name('store');
            Route::get('/edit/{id}','LoanController@edit')->name('edit');
            Route::post('/update/{id}','LoanController@update')->name('update');
            Route::get('/destroy/{id}','LoanController@destroy')->name('destroy');


            Route::get('receive','LoanController@loanrecived')->name('receive');

        });


















        /*Sales*/
        Route::group(['as'=>'sale.','prefix'=>'sale','namespace'=>'Sale'], function(){
            Route::get('/view/sale','SaleController@index')->name('index');
            Route::get('/create','SaleController@create')->name('create');

            //ajax route
            Route::get('/show/product/detail/for/adding/cart/by/modal','Ajax\AjaxController@showProductDetailsByModalForAddingCart')->name('showProductDetailsByModalForAddingCart');
            Route::post('/add/to/cart/from/modal','Ajax\AjaxController@addToCartFromModal')->name('addToCartFromModal');
            Route::get('show/cart/if/existing','Ajax\AjaxController@showCartIfExisting')->name('showCartIfExisting');
            Route::get('remove/single/cart','Ajax\AjaxController@removeSingleCart')->name('removeSingleCart');
            Route::get('remove/all/data/from/cart','Ajax\AjaxController@removeAllDataFromCart')->name('removeAllDataFromCart');
            Route::get('change/quantity/from/cart','Ajax\AjaxController@changeQuantityFromCart')->name('changeQuantityFromCart');

            // Edit
            Route::get('/show/product/detail/for/editing/cart/by/modal','Ajax\AjaxController@showProductDetailsByModalForEditingCart')->name('showProductDetailsByModalForEditingCart');
            Route::post('edit/add/to/cart/from/modal','Ajax\AjaxController@editAddToCartFromModal')->name('editAddToCartFromModal');
            //payment
            Route::get('/show/payment/modal/for/submiting/cart','Ajax\AjaxController@showPaymentModalForSubmitingCart')->name('showPaymentModalForSubmitingCart');

            Route::post('store/add/to/cart/with/payment','Ajax\AjaxController@storeAddToCartWithPayment')->name('storeAddToCartWithPayment');
        });



        /**Sale Pos */
        Route::group(['as'=>'sale.','prefix'=>'sale','namespace'=>'Backend\Sale'], function(){
            //19.02.2021
            Route::get('/view/index','SaleController@index')->name('saleView');
            //ajax
            Route::get('/view/single/show','SaleController@saleSingleShow')->name('saleSingleShow');
            Route::get('/view/single/invoice/print','SaleController@saleSingleInvoicePrint')->name('saleSingleInvoicePrint');

            Route::get('/create/pos','SaleController@createPos')->name('createPos');
            Route::post('store/from/add/to/cart/with/payment','SaleController@storeFromAddToCartWithPayment')->name('storeFromAddToCartWithPayment');

            /**product list is shown by ajax and infinity scrolling*/
            Route::get('create/product/list','SaleController@productListByAjax')->name('productListByAjax');
            /**product list is shown by ajax and infinity scrolling*/

            /**search product by product name,sku ,barcode when pos create */
            Route::get('create/search/product/by/sku/barcode/when/sale/create','SaleController@searchProductByNameSkuBarCodeForAddToCartWhenSaleCreate')->name('searchProductByNameSkuBarCodeForAddToCartWhenSaleCreate');
            Route::get('create/search/result/for/single/add/to/cart','SaleController@addToCartSingleProductByResultOfSearchingByAjaxWhenSaleCreate')->name('addToCartSingleProductByResultOfSearchingByAjaxWhenSaleCreate');
            /**search product by product name,sku ,barcode when pos create */

            Route::get('/create/show/modal','AddToCartController@createShowModal')->name('createShowModal');
            //edit modal
            Route::get('/create/show/edit/modal','AddToCartController@createShowEditModal')->name('createShowEditModal');

            Route::get('/check/qty/available/or/not','AddToCartController@checkQtyAvailableByStockIdPvId')->name('checkQtyAvailableByStockIdPvId');

            /* Add To cart */
            Route::post('/add/to/cart/from/modal','AddToCartController@addToCartWhenSubmitingFromModal')->name('addToCartWhenSubmitingFromModal');
            /* Edit Add To Cart */
            Route::post('/edit/add/to/cart/from/modal','AddToCartController@addToCartWhenSubmitingEditFromModal')->name('addToCartWhenSubmitingEditFromModal');

            Route::get('when/cart/is/exist','AddToCartController@whenCartIsExist')->name('whenCartIsExist');
            Route::get('change/quantity/from/cart/list','AddToCartController@changeQuantityFromCartList')->name('changeQuantityFromCartList');


            Route::get('remove/single/data/from/cart','AddToCartController@removeSingleDataFromCart')->name('removeSingleDataFromCart');
            Route::get('remove/all/data/from/create/cart','AddToCartController@removeAllDataFromCreateCart')->name('removeAllDataFromCreateCart');
            //payment
            Route::get('/popup/payment/modal/before/submiting/from/cart','AddToCartController@popupPaymentModalBeforeSubmitingFromCart')->name('popupPaymentModalBeforeSubmitingFromCart');

            Route::get('/make/sale/quotation','AddToCartController@makeSaleQuotation')->name('makeSaleQuotation');

            /* Route::post('store/from/add/to/cart/with/payment','AddToCartController@storeFromAddToCartWithPayment')->name('storeFromAddToCartWithPayment'); */
           /* Add To cart */

            /** Sale Edit*/
            Route::get('/edit/pos/{id}','SaleController@editPos')->name('editPos');
            /*search by sku barcode pname*/
            Route::get('edit/search/product/by/sku/barcode/when/sale/edit','SaleEditCartController@searchProductBySkyBarCodeForAddToCartWhenSaleEdit')->name('searchProductBySkyBarCodeForAddToCartWhenSaleEdit');
            Route::get('edit/search/result/for/single/add/to/cart','SaleEditCartController@addToCartSingleProductByResultOfSearchingByAjax')->name('addToCartSingleProductByResultOfSearchingByAjax');
            //exit edit cart
            Route::get('sale/edit/cart/is/exist','SaleEditCartController@saleEditWhenEditCartExit')->name('saleEditWhenEditCartExit');
            Route::get('sale/edit/cart/remove/single/data','SaleEditCartController@removeSingleDataFromEditSaleCart')->name('removeSingleDataFromEditSaleCart');
            Route::get('sale/edit/cart/remove/all/data','SaleEditCartController@removeAllDataFromEditSaleCart')->name('removeAllDataFromEditSaleCart');
            Route::get('changing/quantity/from/sale/edit/cart/list','SaleEditCartController@changingQuantityFromSaleEditCartList')->name('changingQuantityFromSaleEditCartList');
             //edit modal
            Route::get('/edit/show/edit/modal','SaleEditCartController@editSaleEditModal')->name('editSaleEditModal');
            Route::post('/edit/update/edit/cart/from/modal','SaleEditCartController@editSaleUpdateCartFromModal')->name('editSaleUpdateCartFromModal');

            //store/edit
            Route::post('/edit/store/cart/from/edit/sale/cart','SaleController@storeFromSaleUpdateFromSaleEditCart')->name('storeFromSaleUpdateFromSaleEditCart');

            //delete sale
            Route::get('/delete/single','SaleController@deleteSale')->name('deleteSale');

            /**duplicate sale */
            Route::get('duplicate/{id}','SaleController@duplicateSale')->name('duplicateSale');

            /** Sale Return , ReturnSaleController*/
            Route::get('/return/pos/{id}','ReturnSaleController@returnSaleCreate')->name('returnSaleCreate');
            Route::post('/return/pos/store','ReturnSaleController@returnSaleStore')->name('returnSaleStore');
            
            
            
              /*sales return view */

            Route::get('return/index','ReturnSaleController@index')->name('return.index');
            Route::get('return/show/{id}','ReturnSaleController@show')->name('return.show');

            /* //sales return view */


            //add single payment
            Route::get('/add/single/payment','SaleController@addSinglePayment')->name('addSinglePayment');
            Route::get('/view/single/payment','SaleController@viewSinglePayment')->name('viewSinglePayment');
            //delete single payment
            Route::get('/delete/single/payment','SaleController@saleSinglePaymentDelete')->name('saleSinglePaymentDelete');

            /**quotation */
            Route::get('quotation/list','QuotationController@index')->name('saleQuotationList');
            Route::get('quotation/view/single/show','QuotationController@quotationSaleSingleShow')->name('quotationSaleSingleShow');
            Route::get('quotation/single/delete','QuotationController@quotationDeleteSale')->name('quotationDeleteSale');
            Route::get('quotation/single/edit/{id}','QuotationController@edit')->name('quotationEdit');
            Route::post('quotation/single/update/{id}','QuotationController@update')->name('quotationUpdate');
            /**invoice wise profti loss */
            Route::get('quotation/invoice/wise/profit/loss','InvoiceWiseProfitLossReportController@quotationInvoiceWiseProfitLoss')->name('quotationInvoiceWiseProfitLoss');
            /**invoice wise profti loss */
            /**Quotation */

            /**invoice wise profti loss */
            Route::get('/invoice/wise/profit/loss','InvoiceWiseProfitLossReportController@invoiceWiseProfitLoss')->name('invoiceWiseProfitLoss');
            /**invoice wise profti loss */
        });


        Route::group(['as'=>'admin.','prefix'=>'payment','namespace'=>'Backend\Payment'], function(){
            Route::post('purchase/bill','PaymentAllBillController@purchaseBill')->name('purchaseBill');
            Route::post('sale/receive/bill','PaymentAllBillController@saleReceiveBill')->name('saleReceiveBill');

            /**receive previous due from customer */
            Route::get('receive/list/previous/bill','PaymentAllBillController@receiveListPreviousBill')->name('receiveListPreviousBill');
            Route::get('receive/previous/bill','PaymentAllBillController@receivePreviousBill')->name('receivePreviousBill');
            Route::get('sale/previous/due/amount','PaymentAllBillController@salePreviousDueAmount')->name('salePreviousDueAmount');
            Route::post('store/receive/previous/bill','PaymentAllBillController@storeReceivePreviousBill')->name('storeReceivePreviousBill');
            /**receive previous due from customer */

            /**receive previous due from supplier */
            Route::get('pay/previous/bill/list','PaymentAllBillController@payPreviousPurchaseBillList')->name('payPreviousPurchaseBillList');
            Route::get('pay/previous/bill','PaymentAllBillController@payPreviousPurchaseBill')->name('payPreviousPurchaseBill');
            Route::get('purchase/previous/due/amount','PaymentAllBillController@purchasePreviousDueAmount')->name('purchasePreviousDueAmount');
            Route::post('store/pay/previous/bill','PaymentAllBillController@storePayPreviousPurchaseBill')->name('storePayPreviousPurchaseBill');
            /**receive previous due from supplier */
        });


        /*Purchae Product*/
        Route::group(['as'=>'admin.','prefix'=>'purchase','namespace'=>'Backend\Purchase'], function(){
            Route::resource('purchase','PurchaseController');
            /**by pass purchase */
            Route::get('bypass/create','PurchaseController@createBypassPurchase')->name('bypass.purchase.create');
            /**by pass purchase */
            Route::get('single/show','PurchaseController@showSingle')->name('showSingle');
            Route::get('single/show/print','PurchaseController@showSinglePrint')->name('showSinglePrint');
                //get stock by stock type id
            Route::get('get/stock/by/stock/id','PurchaseController@getStockByStockId')->name('purchase.product.getStockByStockId');
            

            //add to cart controller
            Route::get('card/if/exist','AddToCartController@purchaseCartIfExist')->name('purchase.product.purchaseCartIfExist');

            Route::get('search/for/add/to/cart','AddToCartController@searchingProductByAjax')->name('purchase.product.searchingProductByAjax');
            /**Bypass purchase */
            Route::get('search/for/add/to/cart/bypass','AddToCartController@searchingProductByAjaxBypass')->name('purchase.product.searchingProductByAjaxBypass');
            /**Bypass purchase */
            
            Route::get('add/to/cart/search/result/for/single','AddToCartController@addToCartSingleProductByResultOfSearchingByAjax')->name('purchase.product.addToCartSingleProductByResultOfSearchingByAjax');

            Route::get('pull/for/add/to/cart','AddToCartController@pullingProductByAjax')->name('purchase.product.pullingProductByAjax');
            Route::get('update/single/cart/','AddToCartController@updateSinglePurchaseCartByAjax')->name('purchase.product.updateSinglePurchaseCartByAjax');


            // remove cart
            Route::get('remove/single/purchase/cart','AddToCartController@removeSinglePurchaseCart')->name('purchase.product.removeSinglePurchaseCart');
            Route::get('remove/all/purchase/cart','AddToCartController@removeAllPurchaseCart')->name('purchase.product.removeAllPurchaseCart');


            /**Salim vai */
            Route::get('/receive/{id}', 'PurchaseController@receive')->name('purchase.receive');
            Route::get('/return/{id}', 'PurchaseController@return')->name('purchase.return');
            Route::get('/duplicate/{id}', 'PurchaseController@duplicate')->name('purchase.duplicate');

            /***** Return***/
            Route::post('return/store','ReturnPurchaseController@returnPurchaseStore')->name('returnPurchaseStore');

            //delete sale
            Route::get('/delete/single','PurchaseController@deleteSinglePurchase')->name('deleteSinglePurchase');

            //add single payment
            Route::get('/add/single/payment','PurchaseController@addSinglePayment')->name('purchase.addSinglePayment');
            Route::get('/view/single/payment','PurchaseController@viewSinglePayment')->name('purchase.viewSinglePayment');

            /**Delete single payment */
            Route::get('/delete/single/payment','PurchaseController@purchaseSinglePaymentDelete')->name('purchaseSinglePaymentDelete');





          /*  for purchase quotation route */
            Route::get('/quotation/index','QuotationController@index')->name('purchase.quotation.index');
            Route::get('/quotation/create','QuotationController@create')->name('purchase.quotation.create');
            Route::get('/quotation/edit/for/final/purchase/{id}','QuotationController@edit')->name('purchase.quotation.edit');
            Route::post('/quotation/update/for/final/purchase/{id}','QuotationController@update')->name('purchase.quotation.update');
            //add to cart controller
            Route::get('quotation/card/if/exist','QuotationAddToCartController@purchaseCartIfExist')->name('quotation.purchase.product.purchaseCartIfExist');
            Route::get('quotation/search/for/add/to/cart','QuotationAddToCartController@searchingProductByAjax')->name('quotation.purchase.product.searchingProductByAjax');
            Route::get('quotation/add/to/cart/search/result/for/single','QuotationAddToCartController@addToCartSingleProductByResultOfSearchingByAjax')->name('quotation.purchase.product.addToCartSingleProductByResultOfSearchingByAjax');
            Route::get('quotation/pull/for/add/to/cart','QuotationAddToCartController@pullingProductByAjax')->name('quotation.purchase.product.pullingProductByAjax');
            Route::get('quotation/update/single/cart/','QuotationAddToCartController@updateSinglePurchaseCartByAjax')->name('quotation.purchase.product.updateSinglePurchaseCartByAjax');
            Route::get('quotation/update/single/cart/','QuotationAddToCartController@updateSinglePurchaseCartByAjax')->name('quotation.purchase.product.updateSinglePurchaseCartByAjax');


            // remove cart
            Route::get('quotation/remove/single/purchase/cart','QuotationAddToCartController@removeSinglePurchaseCart')->name('quotation.purchase.product.removeSinglePurchaseCart');
            Route::get('quotation/remove/all/purchase/cart','QuotationAddToCartController@removeAllPurchaseCart')->name('quotation.purchase.product.removeAllPurchaseCart');


            Route::get('/quotation/delete/{id}','QuotationController@destroy')->name('purchase.quotation.destroy');

        });

        /*Received Purchae Product*/
        Route::group(['as'=>'admin.purchase.product.','prefix'=>'purchase/product','namespace'=>'Backend\ReceivedPurchaseProduct'], function(){
            Route::resource('receive','ReceivedPurchaseProductController');

            //add to cart controller
            Route::get('receive/card/if/exist','AddToCartController@purchaseProductReceiveCartIfExist')->name('receive.purchaseProductReceiveCartIfExist');
            Route::get('receive/search/for/add/to/cart','AddToCartController@searchAndAddToCart')->name('receive.searchAndAddToCart');
            Route::get('receive/search/for/update/add/to/cart','AddToCartController@updatePurchaseReceiveAddToCart')->name('receive.updatePurchaseReceiveAddToCart');

            // remove cart
            Route::get('receive/remove/single/purchase/cart','AddToCartController@removeSinglepurchaseProductReceiveCart')->name('receive.removeSinglepurchaseProductReceiveCart');
            Route::get('receive/remove/all/purchase/cart','AddToCartController@removeAllpurchaseProductReceiveCart')->name('receive.removeAllpurchaseProductReceiveCart');
        });




        /*Stock Manage*/
        Route::group(['as'=>'admin.','prefix'=>'admin/stock','namespace'=>'Backend\Stock'], function(){
            Route::resource('main-stock','MainStockController');
            Route::get('main/stock/pdf/list','MainStockController@main_stock_pdf_list')->name('main_stock_pdf_list');

            Route::resource('primary-stock','PrimaryStockController');
            Route::get('primary/stock/pdf/list','PrimaryStockController@primary_stock_pdf_list')->name('primary_stock_pdf_list');

            Route::resource('secondary-stock','SecondaryStockController');
            Route::get('secondary/stock/pdf/list','SecondaryStockController@seconday_stock_pdf_list')->name('seconday_stock_pdf_list');
        });

        /**Account Payment Cash Flow & report*/
        Route::group(['as'=>'admin.','prefix'=>'admin/account/payment','namespace'=>'Backend\Payment'], function(){
            Route::get('/report','AccountPaymentReportController@paymentAccountReport')->name('paymentAccountReport');
            Route::get('/cash/flow','AccountPaymentReportController@paymentAccountCashFlow')->name('paymentAccountCashFlow');
        });
        /**Account Payment Cash Flow & report*/

        /* Payment Method */
        Route::group(['as'=>'admin.','prefix'=>'admin/payment','namespace'=>'Backend\Payment'], function(){
            Route::resource('paymentMethod','PaymentMethodController');
        });
        /* Account */
        Route::group(['as'=>'admin.','prefix'=>'admin/payment','namespace'=>'Backend\Payment'], function(){
            Route::resource('account','AccountController');
            //by ajax
            Route::get('get/account/by/payment/method','AccountController@getAccountByPaymentMethod')->name('getAccountByPaymentMethod');
        });


        /* Bank */ //           //"payment_method_id" => "required|exists:payment_methods,id",
        Route::group(['as'=>'admin.','prefix'=>'admin','namespace'=>'Backend\Payment'], function(){
            Route::resource('bank','BankController');
        });

        /* Payment History */
        Route::group(['as'=>'admin.','prefix'=>'admin','namespace'=>'Backend\Payment'], function(){
            Route::resource('payment','PaymentHistoryController');
        });

        /* Expense Category */
        Route::group(['as'=>'admin.','prefix'=>'admin/expense','namespace'=>'Backend\Expense'], function(){
            Route::resource('category','ExpenseCategoryController');
        });

        /* Expense Final */
        Route::group(['as'=>'admin.','prefix'=>'admin','namespace'=>'Backend\Expense'], function(){
            Route::resource('expense-final','ExpenseFinalController');
        });

        /* Expense Detail */
        Route::group(['as'=>'admin.','prefix'=>'admin','namespace'=>'Backend\Expense'], function(){
            Route::resource('expense-detail','ExpenseDetailController');
        });


     

    Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Backend\Transaction'], function () {
        Route::resource('transaction-type', 'TransactionTypeController');
        Route::resource('transaction-category', 'TransactionCategoryController');
        Route::resource('transaction-detail', 'TransactionDetailController');
        Route::get("transaction-detail/transaction-categories/{transactionType}", "TransactionDetailController@getTransactionCategory")->name("transaction-categories");
    });

    Route::group(['as' => "admin.", "prefix" => "admin", "namespace" => "Backend\Stock"], function () {
        Route::get("transfer/stock/modal", "StockTransferController@stockTransferModal")->name('stockTransferModal');
        Route::get("get/stock/by/stock/id/ajax/for/transfer", "StockTransferController@getStockByStockId")->name('stock.transfer.getStockByStockId');
        Route::post("transfer/quantity", "StockTransferController@transferStockQuantity")->name('transferStockQuantity');
    });


   


});




