<?php

use Illuminate\Support\Facades\Route;

Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login')->name('workshop.auth.login');
Route::post('logout', 'Auth\LoginController@logout')->name('workshop.auth.logout');

Route::get('', 'HomeController@index');
Route::get('home', 'HomeController@index')->name('workshop.home.index');

Route::get('test', function () {
  return '';
});

Route::get('/part-autocomplete', 'UtilityController@part_autocomplete')->name('workshop.utility.part-autocomplete');
Route::get('/equipment-autocomplete', 'UtilityController@equipmentAutoComplete')->name('workshop.utility.equipment-autocomplete');
Route::get('/tool-autocomplete', 'UtilityController@toolAutoComplete')->name('workshop.utility.tool-autocomplete');

Route::group(['prefix' => 'master-data', 'namespace' => 'MasterData', 'middleware' => 'auth'], function () {

  Route::group(['prefix' => 'equipment', 'middleware' => ['permission:super_admin|workshop-master_data.equipment.view']], function () {
    // Route::get('/autocomplete', 'EquipmentController@autocomplete')->name('workshop.master-data.equipment.autocomplete');
    Route::get('/add', 'EquipmentController@add')->name('workshop.master-data.equipment.add');
    // Route::get('/stock-card/{id}', 'EquipmentController@stockCard')->name('workshop.master-data.equipment.stock-card');
    // Route::get('/stock-card/{id}/print', 'EquipmentController@stockCardPrint')->name('workshop.master-data.equipment.stock-card-print');
    Route::get('{id}', 'EquipmentController@edit')->name('workshop.master-data.equipment.edit');
    Route::put('{id}', 'EquipmentController@update')->name('workshop.master-data.equipment.update');
    Route::delete('{id}', 'EquipmentController@destroy')->name('workshop.master-data.equipment.destroy');
    Route::get('/', 'EquipmentController@index')->name('workshop.master-data.equipment.index');
    Route::post('/', 'EquipmentController@store')->name('workshop.master-data.equipment.store');
  });

  Route::group(['prefix' => 'equipment-category', 'middleware' => ['permission:super_admin|workshop-master_data.equipment_category.view']], function () {
    Route::get('/', 'EquipmentCategoryController@index')->name('workshop.master-data.equipment-category.index');
    Route::post('/', 'EquipmentCategoryController@store')->name('workshop.master-data.equipment-category.store');
    Route::put('{id}', 'EquipmentCategoryController@update')->name('workshop.master-data.equipment-category.update');
    Route::delete('{id}', 'EquipmentCategoryController@destroy')->name('workshop.master-data.equipment-category.destroy');
  });

  Route::group(['prefix' => 'tools', 'middleware' => ['permission:super_admin|workshop-master_data.tools.view']], function () {
    Route::get('/', 'ToolsController@index')->name('workshop.master-data.tools.index');
    Route::post('/', 'ToolsController@store')->name('workshop.master-data.tools.store');
    Route::get('/history/{tools}', 'ToolsController@history')->name('workhsop.master-data.tools.history');
    Route::put('{id}', 'ToolsController@update')->name('workshop.master-data.tools.update');
    Route::delete('{id}', 'ToolsController@destroy')->name('workshop.master-data.tools.destroy');
  });

  Route::group(['prefix' => 'tools-category', 'middleware' => ['permission:super_admin|workshop-master_data.tool_category.view']], function () {
    Route::get('/', 'ToolsCategoryController@index')->name('workshop.master-data.tools-category.index');
    Route::post('/', 'ToolsCategoryController@store')->name('workshop.master-data.tools-category.store');
    Route::put('{id}', 'ToolsCategoryController@update')->name('workshop.master-data.tools-category.update');
    Route::delete('{id}', 'ToolsCategoryController@destroy')->name('workshop.master-data.tools-category.destroy');
  });

  Route::group(['prefix' => 'inspection-checklist', 'middleware' => ['permission:super_admin|workshop-master_data.inspection_checklist.view']], function () {
    Route::get('/', 'InspectionChecklistsController@index')->name('workshop.master-data.inspection-checklist.index');
    Route::post('/', 'InspectionChecklistsController@store')->name('workshop.master-data.inspection-checklist.store');
  });

  Route::group(['prefix' => 'settings', 'middleware' => ['permission:super_admin|workshop-master_data.setting.view']], function () {
    Route::get('/', 'SettingsController@index')->name('workshop.master-data.settings.index');
    Route::post('/', 'SettingsController@store')->name('workshop.master-data.settings.store');
    Route::put('{id}', 'SettingsController@update')->name('workshop.master-data.settings.update');
    Route::delete('{id}', 'SettingsController@destroy')->name('workshop.master-data.settings.destroy');
  });

  Route::group(['prefix' => 'uop', 'middleware' => 'permission:super_admin|warehouse-master_data.uop.view'], function () {
    Route::get('/', 'UopController@index')->name('warehouse.master-data.uop.index');
    Route::post('/', 'UopController@store')->name('warehouse.master-data.uop.store');
    Route::put('{id}', 'UopController@update')->name('warehouse.master-data.uop.update');
    Route::delete('{id}', 'UopController@destroy')->name('warehouse.master-data.uop.destroy');
  });

  Route::group(['prefix' => 'brand', 'middleware' => 'permission:super_admin|warehouse-master_data.brand.view'], function () {
    Route::get('/', 'BrandController@index')->name('warehouse.master-data.brand.index');
    Route::post('/', 'BrandController@store')->name('warehouse.master-data.brand.store');
    Route::put('{id}', 'BrandController@update')->name('warehouse.master-data.brand.update');
    Route::delete('{id}', 'BrandController@destroy')->name('warehouse.master-data.brand.destroy');
  });

  Route::group(['prefix' => 'supplier', 'middleware' => 'permission:super_admin|warehouse-master_data.supplier.view'], function () {
    Route::get('/', 'SupplierController@index')->name('warehouse.master-data.supplier.index');
    Route::post('/', 'SupplierController@store')->name('warehouse.master-data.supplier.store');
    Route::get('/add', 'SupplierController@add')->name('warehouse.master-data.supplier.add');
    Route::get('{id}', 'SupplierController@edit')->name('warehouse.master-data.supplier.edit');
    Route::put('{id}', 'SupplierController@update')->name('warehouse.master-data.supplier.update');
    Route::delete('{id}', 'SupplierController@destroy')->name('warehouse.master-data.supplier.destroy');
  });

  Route::group(['prefix' => 'category', 'middleware' => 'permission:super_admin|warehouse-master_data.category.view'], function () {
    Route::get('/', 'CategoryController@index')->name('warehouse.master-data.category.index');
    Route::post('/', 'CategoryController@store')->name('warehouse.master-data.category.store');
    Route::put('{id}', 'CategoryController@update')->name('warehouse.master-data.category.update');
    Route::delete('{id}', 'CategoryController@destroy')->name('warehouse.master-data.category.destroy');
  });

  Route::group(['prefix' => 'currency', 'middleware' => 'permission:super_admin|warehouse-master_data.currency.view'], function () {
    Route::get('/', 'CurrencyController@index')->name('warehouse.master-data.currency.index');
    Route::post('/', 'CurrencyController@store')->name('warehouse.master-data.currency.store');
    Route::put('{id}', 'CurrencyController@update')->name('warehouse.master-data.currency.update');
    Route::delete('{id}', 'CurrencyController@destroy')->name('warehouse.master-data.currency.destroy');
  });

  Route::group(['prefix' => 'division', 'middleware' => 'permission:super_admin|warehouse-master_data.division.view'], function () {
    Route::get('/', 'DivisionController@index')->name('warehouse.master-data.division.index');
    Route::post('/', 'DivisionController@store')->name('warehouse.master-data.division.store');
    Route::put('{id}', 'DivisionController@update')->name('warehouse.master-data.division.update');
    Route::delete('{id}', 'DivisionController@destroy')->name('warehouse.master-data.division.destroy');
  });

  Route::group(['prefix' => 'component'], function () {
    Route::get('/', 'ComponentController@index')->name('warehouse.master-data.component.index');
    Route::post('/', 'ComponentController@store')->name('warehouse.master-data.component.store');
    Route::put('{id}', 'ComponentController@update')->name('warehouse.master-data.component.update');
    Route::delete('{id}', 'ComponentController@destroy')->name('warehouse.master-data.component.destroy');
  });

  Route::group(['prefix' => 'spare-part', 'middleware' => 'permission:super_admin|warehouse-master_data.spare_part.view'], function () {
    Route::get('/autocomplete', 'SparePartController@autocomplete')->name('warehouse.master-data.spare-part.autocomplete');
    Route::get('/add', 'SparePartController@add')->name('warehouse.master-data.spare-part.add');
    Route::get('/stock-card/{id}', 'SparePartController@stockCard')->name('warehouse.master-data.spare-part.stock-card');
    Route::get('/print', 'SparePartController@print')->name('warehouse.master-data.spare-part.print-all');
    Route::get('/stock-card/{id}/print', 'SparePartController@stockCardPrint')->name('warehouse.master-data.spare-part.stock-card-print');
    Route::get('{id}', 'SparePartController@edit')->name('warehouse.master-data.spare-part.edit');
    Route::put('{id}', 'SparePartController@update')->name('warehouse.master-data.spare-part.update');
    Route::delete('{id}', 'SparePartController@destroy')->name('warehouse.master-data.spare-part.destroy');
    Route::get('/', 'SparePartController@index')->name('warehouse.master-data.spare-part.index');
    Route::post('/', 'SparePartController@store')->name('warehouse.master-data.spare-part.store');
  });

  Route::group(['prefix' => 'fuel-tank', 'middleware' => 'permission:super_admin|warehouse-master_data.fuel_tank.view'], function () {
    Route::get('/', 'FuelTankController@index')->name('warehouse.master-data.fuel-tank.index');
    Route::post('/', 'FuelTankController@store')->name('warehouse.master-data.fuel-tank.store');
    Route::get('/history/{id}', 'FuelTankController@history')->name('warehouse.master-data.fuel-tank.history');
    Route::get('/history/{id}/print', 'FuelTankController@historyPrint')->name('warehouse.master-data.fuel-tank.history-print');
    Route::put('{id}', 'FuelTankController@update')->name('warehouse.master-data.fuel-tank.update');
    Route::delete('{id}', 'FuelTankController@destroy')->name('warehouse.master-data.fuel-tank.destroy');
  });

  Route::group(['prefix' => 'fuel-truck', 'as' => 'warehouse.master-data.fuel-truck.', 'middleware' => 'permission:super_admin|warehouse-master_data.fuel_truck.view'], function () {
    Route::get('/', 'FuelTruckController@index')->name('index');
    Route::post('/', 'FuelTruckController@store')->name('store');
    Route::get('/history/{id}', 'FuelTruckController@history')->name('history');
    Route::get('/history/{id}/print', 'FuelTruckController@historyPrint')->name('history-print');
    Route::put('{id}', 'FuelTruckController@update')->name('update');
    Route::delete('{id}', 'FuelTruckController@destroy')->name('destroy');
  });
});

Route::group(['middleware' => 'auth'], function () {

  Route::group(['prefix' => 'operating-sheet', 'middleware' => ['permission:super_admin|workshop-operating_sheet.view']], function () {
    Route::get('/', 'InspectionController@index')->name('workshop.inspection.index');
    Route::post('/', 'InspectionController@store')->name('workshop.inspection.store');
    Route::get('/add', 'InspectionController@create')->name('workshop.inspection.add');
    Route::get('/edit/{id}', 'InspectionController@edit')->name('workshop.inspection.edit');
    Route::put('{id}', 'InspectionController@update')->name('workshop.inspection.update');
    Route::get('/download', 'InspectionController@download')->name('workshop.inspection.download');
    Route::get('/download-template', 'InspectionController@downloadTemplate')->name('workshop.inspection.download_template');
    Route::delete('{id}', 'InspectionController@delete')->name('workshop.inspection.delete');
    Route::post('/import', 'InspectionController@import')->name('workshop.inspection.import');
  });

  Route::group(['prefix' => 'work-request', 'middleware' => ['permission:super_admin|workshop-work_request.view']], function () {
    Route::get('/', 'WorkRequestController@index')->name('workshop.work-request.index');
    Route::post('/', 'WorkRequestController@store')->name('workshop.work-request.store');
    Route::get('/add', 'WorkRequestController@create')->name('workshop.work-request.add');
    Route::get('/print/{id}', 'WorkRequestController@print')->name('workshop.work-request.print');
    Route::get('/schedule/{id}', 'WorkRequestController@schedule')->name('workshop.work-request.schedule');
    Route::post('/schedule/{id}', 'WorkRequestController@setSchedule')->name('workshop.work-request.set-schedule');
    Route::post('/delete-image', 'WorkRequestController@deleteImage')->name('workshop.work-request.delete-image');
    Route::get('/edit/{id}', 'WorkRequestController@edit')->name('workshop.work-request.edit');
    Route::put('{id}', 'WorkRequestController@update')->name('workshop.work-request.update');
    Route::get('/download', 'WorkRequestController@download')->name('workshop.work-request.download');
    Route::delete('{id}', 'WorkRequestController@delete')->name('workshop.work-request.delete');
  });

  Route::group(['prefix' => 'work-order', 'middleware' => ['permission:super_admin|workshop-work_order.view']], function () {
    Route::get('/', 'WorkOrderController@index')->name('workshop.work-order.index');
    Route::post('/delete-image', 'WorkOrderController@deleteImage')->name('workshop.work-order.delete-image');
    Route::post('/{id}', 'WorkOrderController@store')->name('workshop.work-order.store');
    Route::get('/add/{id}', 'WorkOrderController@add')->name('workshop.work-order.add');
    // Route::get('/schedule/{id}', 'WorkOrderController@schedule')->name('workshop.work-order.schedule');
    // Route::post('/schedule/{id}', 'WorkOrderController@setSchedule')->name('workshop.work-order.set-schedule');
    Route::get('/edit/{id}', 'WorkOrderController@edit')->name('workshop.work-order.edit');
    Route::put('{id}', 'WorkOrderController@update')->name('workshop.work-order.update');
    Route::get('/complete/{id}', 'WorkOrderController@complete')->name('workshop.work-order.complete');
    Route::post('/completed/{id}', 'WorkOrderController@completed')->name('workshop.work-order.completed');
    Route::get('/download', 'WorkOrderController@download')->name('workshop.work-order.download');
    Route::get('/print/{id}', 'WorkOrderController@print')->name('workshop.work-order.print');
    Route::get('{id}/inspection/', 'WorkOrderController@showInspection')->name('workshop.work-order.show-inspection');
    Route::get('{id}/inspection/print', 'WorkOrderController@printInspection')->name('workshop.work-order.print-inspection');
    Route::get('{id}/inspection/reset', 'WorkOrderController@resetInspection')->name('workshop.work-order.reset-inspection');
    Route::post('{id}/inspection/', 'WorkOrderController@storeInspection')->name('workshop.work-order.store-inspection');
    Route::delete('{id}', 'WorkOrderController@delete')->name('workshop.work-order.delete');
  });

  Route::group(['prefix' => 'tool-usage', 'middleware' => ['permission:super_admin|workshop-tool_management.tool_usage.view']], function () {
    Route::get('/', 'ToolUsageController@index')->name('workshop.tool-usage.index');
    Route::get('/add/{id}', 'ToolUsageController@add')->name('workshop.tool-usage.add');
    Route::get('/edit/{id}', 'ToolUsageController@edit')->name('workshop.tool-usage.edit');
    Route::get('/download', 'ToolUsageController@download')->name('workshop.tool-usage.download');
    Route::get('/missing/{id}', 'ToolUsageController@missing')->name('workshop.tool-usage.missing');
    Route::get('/print-missing/{id}', 'ToolUsageController@printMissing')->name('workshop.tool-usage.print-missing');
    Route::post('/missing/{id}', 'ToolUsageController@storeMissing')->name('workshop.tool-usage.store-missing');
    Route::post('/{id}', 'ToolUsageController@store')->name('workshop.tool-usage.store');
    Route::put('{id}', 'ToolUsageController@update')->name('workshop.tool-usage.update');
    Route::delete('{id}', 'ToolUsageController@delete')->name('workshop.tool-usage.delete');
  });

  Route::group(['prefix' => 'tool-receiving', 'middleware' => ['permission:super_admin|workshop-tool_management.tool_receiving.view']], function () {
    Route::get('/', 'ToolReceivingController@index')->name('workshop.tool-receiving.index');
    Route::get('/download', 'ToolUsageController@download')->name('workshop.tool-receiving.download');
    Route::get('/add', 'ToolReceivingController@create')->name('workshop.tool-receiving.add');
    Route::get('/edit/{id}', 'ToolReceivingController@edit')->name('workshop.tool-receiving.edit');
    Route::post('/', 'ToolReceivingController@store')->name('workshop.tool-receiving.store');
    Route::put('{id}', 'ToolReceivingController@update')->name('workshop.tool-receiving.update');
    Route::delete('{id}', 'ToolReceivingController@destroy')->name('workshop.tool-receiving.delete');
  });

  Route::group(['prefix' => 'scrap', 'middleware' => ['permission:super_admin|workshop-scrap_management.scrap.view']], function () {
    Route::get('/', 'ScrapController@index')->name('workshop.scrap.index');
    Route::get('/download', 'ToolUsageController@download')->name('workshop.scrap.download');
    Route::get('/add', 'ScrapController@create')->name('workshop.scrap.add');
    Route::get('/edit/{id}', 'ScrapController@edit')->name('workshop.scrap.edit');
    Route::post('/', 'ScrapController@store')->name('workshop.scrap.store');
    Route::put('{id}', 'ScrapController@update')->name('workshop.scrap.update');
    Route::delete('{id}', 'ScrapController@delete')->name('workshop.scrap.delete');
  });

  Route::group(['prefix' => 'scrap-receiving'], function () {
    Route::get('/', 'ScrapReceivingController@index')->name('workshop.scrap-receiving.index');
    Route::get('/download', 'ToolUsageController@download')->name('workshop.scrap-receiving.download');
    Route::get('/add', 'ScrapReceivingController@create')->name('workshop.scrap-receiving.add');
    Route::get('/edit/{id}', 'ScrapReceivingController@edit')->name('workshop.scrap-receiving.edit');
    Route::post('/', 'ScrapReceivingController@store')->name('workshop.scrap-receiving.store');
    Route::put('{id}', 'ScrapReceivingController@update')->name('workshop.scrap-receiving.update');
    Route::delete('{id}', 'ScrapReceivingController@delete')->name('workshop.scrap-receiving.delete');
  });
});

Route::group(['prefix' => 'fuel', 'middleware' => 'auth'], function () {
  Route::group(['prefix' => 'receiving', 'middleware' => 'permission:super_admin|warehouse-bbm.receiving.view'], function () {
    Route::get('/', 'FuelReceivingController@index')->name('warehouse.fuel-receiving.index');
    Route::post('/', 'FuelReceivingController@store')->name('warehouse.fuel-receiving.store');
    Route::get('/add', 'FuelReceivingController@add')->name('warehouse.fuel-receiving.add');
    Route::get('/test', 'FuelReceivingController@test')->name('warehouse.fuel-receiving.test');
    Route::get('/print/{id}', 'FuelReceivingController@print')->name('warehouse.fuel-receiving.print');
    Route::get('{id}', 'FuelReceivingController@edit')->name('warehouse.fuel-receiving.edit');
    Route::put('{id}', 'FuelReceivingController@update')->name('warehouse.fuel-receiving.update');
    Route::delete('{id}', 'FuelReceivingController@destroy')->name('warehouse.fuel-receiving.destroy');
  });
});

Route::group(['prefix' => 'purchasing-request', 'middleware' => ['auth', 'permission:super_admin|warehouse-spare_part.purchasing_request.view']], function () {
  Route::get('/', 'PurchasingRequestController@index')->name('warehouse.purchasing-request.index');
  Route::post('/', 'PurchasingRequestController@store')->name('warehouse.purchasing-request.store');
  Route::get('/add', 'PurchasingRequestController@add')->name('warehouse.purchasing-request.add');
  Route::get('/test', 'PurchasingRequestController@test')->name('warehouse.purchasing-request.test');
  Route::get('/print/{id}', 'PurchasingRequestController@print')->name('warehouse.purchasing-request.print');
  Route::get('/download', 'PurchasingRequestController@download')->name('warehouse.purchasing-request.download');
  Route::get('{id}', 'PurchasingRequestController@edit')->name('warehouse.purchasing-request.edit');
  Route::put('{id}', 'PurchasingRequestController@update')->name('warehouse.purchasing-request.update');
  Route::delete('{id}', 'PurchasingRequestController@destroy')->name('warehouse.purchasing-request.destroy');
});

Route::group(['prefix' => 'purchasing-comparison', 'middleware' => ['auth', 'permission:super_admin|warehouse-spare_part.purchasing_comparison.view']], function () {
  Route::get('/', 'PurchasingComparisonController@index')->name('warehouse.purchasing-comparison.index');
  Route::post('/', 'PurchasingComparisonController@store')->name('warehouse.purchasing-comparison.store');
  Route::get('/add/{id}', 'PurchasingComparisonController@add')->name('warehouse.purchasing-comparison.add');
  Route::get('/print/{id}', 'PurchasingComparisonController@print')->name('warehouse.purchasing-comparison.print');
  Route::get('{id}', 'PurchasingComparisonController@edit')->name('warehouse.purchasing-comparison.edit');
  Route::put('{id}', 'PurchasingComparisonController@update')->name('warehouse.purchasing-comparison.update');
  Route::delete('{id}', 'PurchasingComparisonController@destroy')->name('warehouse.purchasing-comparison.destroy');
});

Route::group(['prefix' => 'purchasing-order', 'middleware' => ['auth', 'permission:super_admin|warehouse-spare_part.purchasing_order.view']], function () {
  Route::get('/', 'PurchasingOrderController@index')->name('warehouse.purchasing-order.index');
  Route::post('/', 'PurchasingOrderController@store')->name('warehouse.purchasing-order.store');
  Route::get('/add', 'PurchasingOrderController@add')->name('warehouse.purchasing-order.add');
  Route::get('/test', 'PurchasingOrderController@test')->name('warehouse.purchasing-order.test');
  Route::get('/print/{id}', 'PurchasingOrderController@print')->name('warehouse.purchasing-order.print');
  Route::get('{id}', 'PurchasingOrderController@edit')->name('warehouse.purchasing-order.edit');
  Route::put('{id}', 'PurchasingOrderController@update')->name('warehouse.purchasing-order.update');
  Route::delete('{id}', 'PurchasingOrderController@destroy')->name('warehouse.purchasing-order.destroy');
});

Route::group(['prefix' => 'receiving', 'middleware' => ['auth', 'permission:super_admin|warehouse-spare_part.receiving.view']], function () {
  Route::get('/', 'ReceivingController@index')->name('warehouse.receiving.index');
  Route::post('/', 'ReceivingController@store')->name('warehouse.receiving.store');
  Route::get('/add/{id}', 'ReceivingController@add')->name('warehouse.receiving.add');
  Route::get('/test', 'ReceivingController@test')->name('warehouse.receiving.test');
  Route::get('/print/{id}', 'ReceivingController@print')->name('warehouse.receiving.print');
  Route::get('{id}', 'ReceivingController@edit')->name('warehouse.receiving.edit');
  Route::put('{id}', 'ReceivingController@update')->name('warehouse.receiving.update');
  Route::delete('{id}', 'ReceivingController@destroy')->name('warehouse.receiving.destroy');
});

Route::group(['prefix' => 'part-return', 'middleware' => ['auth', 'permission:super_admin|warehouse-spare_part.return.view']], function () {
  Route::get('/', 'PartReturnController@index')->name('warehouse.part-return.index');
  Route::post('/', 'PartReturnController@store')->name('warehouse.part-return.store');
  Route::get('/add/{id}', 'PartReturnController@add')->name('warehouse.part-return.add');
  Route::get('/print/{id}', 'PartReturnController@print')->name('warehouse.part-return.print');
  Route::get('{id}', 'PartReturnController@edit')->name('warehouse.part-return.edit');
  Route::put('{id}', 'PartReturnController@update')->name('warehouse.part-return.update');
  Route::put('release/{id}', 'PartReturnController@release')->name('warehouse.part-return.release');
  Route::delete('{id}', 'PartReturnController@destroy')->name('warehouse.part-return.destroy');
});

Route::group(['prefix' => 'issued', 'middleware' => ['auth', 'permission:super_admin|warehouse-spare_part.issued.view']], function () {
  Route::get('/', 'IssuedController@index')->name('warehouse.issued.index');
  Route::post('/', 'IssuedController@store')->name('warehouse.issued.store');
  Route::get('/add', 'IssuedController@add')->name('warehouse.issued.add');
  Route::get('/print/{id}', 'IssuedController@print')->name('warehouse.issued.print');
  Route::get('/download', 'IssuedController@download')->name('warehouse.issued.download');
  Route::get('{id}', 'IssuedController@edit')->name('warehouse.issued.edit');
  Route::put('{id}', 'IssuedController@update')->name('warehouse.issued.update');
  Route::delete('{id}', 'IssuedController@destroy')->name('warehouse.issued.destroy');
});

Route::group(['prefix' => 'fuel-tank-consumption', 'middleware' => ['auth', 'permission:super_admin|warehouse-bbm_consumption/issued.fuel_tank.view'], 'as' => 'warehouse.fuel-tank-consumption.'], function () {
  Route::get('/', 'FuelTankConsumptionController@index')->name('index');
  Route::post('/', 'FuelTankConsumptionController@store')->name('store');
  Route::get('/destination-data', 'FuelTankConsumptionController@getDestinationData')->name('destination-data');
  Route::get('/add', 'FuelTankConsumptionController@add')->name('add');
  Route::get('/print/{id}', 'FuelTankConsumptionController@print')->name('print');
  Route::get('/download', 'FuelTankConsumptionController@download')->name('download');
  Route::get('{id}', 'FuelTankConsumptionController@edit')->name('edit');
  Route::put('{id}', 'FuelTankConsumptionController@update')->name('update');
  Route::delete('{id}', 'FuelTankConsumptionController@destroy')->name('destroy');
});

Route::group(['prefix' => 'fuel-truck-consumption', 'middleware' => ['auth', 'permission:super_admin|warehouse-bbm_consumption/issued.fuel_truck.view'], 'as' => 'warehouse.fuel-truck-consumption.'], function () {
  Route::get('/', 'FuelTruckConsumptionController@index')->name('index');
  Route::post('/', 'FuelTruckConsumptionController@store')->name('store');
  Route::get('/destination-data', 'FuelTruckConsumptionController@getDestinationData')->name('destination-data');
  Route::get('/add', 'FuelTruckConsumptionController@add')->name('add');
  Route::get('/print/{id}', 'FuelTruckConsumptionController@print')->name('print');
  Route::get('/download', 'FuelTruckConsumptionController@download')->name('download');
  Route::get('{id}', 'FuelTruckConsumptionController@edit')->name('edit');
  Route::put('{id}', 'FuelTruckConsumptionController@update')->name('update');
  Route::delete('{id}', 'FuelTruckConsumptionController@destroy')->name('destroy');
});

Route::get('master-data', 'HomeController@index')->name('warehouse.master-data');
