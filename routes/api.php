<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'throttle:60,1'])->group(function () {

    /**
     * Endpoint for Promoters
     */
    Route::get('promoters/methods', [App\Http\Controllers\PromoterController::class, 'methods']);
    Route::apiResource('promoters', App\Http\Controllers\PromoterController::class);

    /**
     *  Endpoint for Promoter Groups
     */
    Route::get('promoter-groups/methods', [App\Http\Controllers\PromoterGroupController::class, 'methods']);
    Route::apiResource('promoter-groups', App\Http\Controllers\PromoterGroupController::class);
    Route::prefix('promoter-groups/{promoter_group_id}')->group(function () {
        Route::get('members', [App\Http\Controllers\PromoterGroupController::class, 'members']);
    });

    Route::get('countries/methods', [App\Http\Controllers\CountryController::class, 'methods']);
    Route::apiResource('countries', App\Http\Controllers\CountryController::class);

    Route::get('genders/methods', [App\Http\Controllers\GenderController::class, 'methods']);
    Route::apiResource('genders', App\Http\Controllers\GenderController::class);

    Route::get('offer-states/methods', [App\Http\Controllers\OfferStateController::class, 'methods']);
    Route::apiResource('offer-states', App\Http\Controllers\OfferStateController::class);
    Route::prefix('offer-states/{offer_state_id}')->group(function () {
       Route::get('offers', [App\Http\Controllers\OfferStateController::class, 'offers']);
    });

    Route::get('payment-states/methods', [App\Http\Controllers\PaymentStateController::class, 'methods']);
    Route::apiResource('payment-states', App\Http\Controllers\PaymentStateController::class);

    Route::get('commitment-states/methods', [App\Http\Controllers\CommitmentStateController::class, 'methods']);
    Route::apiResource('commitment-states', App\Http\Controllers\CommitmentStateController::class);

    Route::get('departments/methods', [App\Http\Controllers\DepartmentController::class, 'methods']);
    Route::apiResource('departments', App\Http\Controllers\DepartmentController::class);

    Route::get('inventory-conditions/methods', [App\Http\Controllers\InventoryConditionController::class, 'methods']);
    Route::apiResource('inventory-conditions', App\Http\Controllers\InventoryConditionController::class);

    Route::get('event-states/methods', [App\Http\Controllers\EventStateController::class, 'methods']);
    Route::apiResource('event-states', App\Http\Controllers\EventStateController::class);

    Route::get('employees/methods', [App\Http\Controllers\EmployeeController::class, 'methods']);
    Route::apiResource('employees', App\Http\Controllers\EmployeeController::class);

    Route::get('customers/methods', [App\Http\Controllers\CustomerController::class, 'methods']);
    Route::apiResource('customers', App\Http\Controllers\CustomerController::class);

    Route::get('events/methods', [App\Http\Controllers\EventController::class, 'methods']);
    Route::apiResource('events', App\Http\Controllers\EventController::class);

    Route::get('offers/methods', [App\Http\Controllers\OfferController::class, 'methods']);
    Route::apiResource('offers', App\Http\Controllers\OfferController::class);

    Route::get('invoices/methods', [App\Http\Controllers\InvoiceController::class, 'methods']);
    Route::apiResource('invoices', App\Http\Controllers\InvoiceController::class);

    Route::get('occupations/methods', [App\Http\Controllers\OccupationController::class, 'methods']);
    Route::apiResource('occupations', App\Http\Controllers\OccupationController::class);

    Route::get('commitments/methods', [App\Http\Controllers\CommitmentController::class, 'methods']);
    Route::apiResource('commitments', App\Http\Controllers\CommitmentController::class);

    Route::get('locations/methods', [App\Http\Controllers\LocationController::class, 'methods']);
    Route::apiResource('locations', App\Http\Controllers\LocationController::class);

    Route::get('contact-persons/methods', [App\Http\Controllers\ContactPersonController::class, 'methods']);
    Route::apiResource('contact-persons', App\Http\Controllers\ContactPersonController::class);

    Route::get('skills/methods', [App\Http\Controllers\SkillController::class, 'methods']);
    Route::apiResource('skills', App\Http\Controllers\SkillController::class);

    Route::get('inventories/methods', [App\Http\Controllers\InventoryController::class, 'methods']);
    Route::apiResource('inventories', App\Http\Controllers\InventoryController::class);

    Route::get('price-groups/methods', [App\Http\Controllers\PriceGroupController::class, 'methods']);
    Route::apiResource('price-groups', App\Http\Controllers\PriceGroupController::class);

    Route::get('service-areas/methods', [App\Http\Controllers\ServiceAreaController::class, 'methods']);
    Route::apiResource('service-areas', App\Http\Controllers\ServiceAreaController::class);

    Route::get('permissions/methods', [App\Http\Controllers\PermissionController::class, 'methods']);
    Route::apiResource('permissions', App\Http\Controllers\PermissionController::class);

    Route::get('groups/methods', [App\Http\Controllers\GroupController::class, 'methods']);
    Route::apiResource('groups', App\Http\Controllers\GroupController::class);

    Route::get('users/methods', [App\Http\Controllers\UserController::class, 'methods']);
    Route::apiResource('users', App\Http\Controllers\UserController::class);

    Route::get('group-permissions/methods', [App\Http\Controllers\GroupPermissionController::class, 'methods']);
    Route::apiResource('group-permissions', App\Http\Controllers\GroupPermissionController::class);

    Route::get('group-users/methods', [App\Http\Controllers\GroupUserController::class, 'methods']);
    Route::apiResource('group-users', App\Http\Controllers\GroupUserController::class);

    Route::get('time-tracking-states/methods', [App\Http\Controllers\TimeTrackingStateController::class, 'methods']);
    Route::apiResource('time-tracking-states', App\Http\Controllers\TimeTrackingStateController::class);

    Route::get('time-tracking-channels/methods', [App\Http\Controllers\TimeTrackingChannelController::class, 'methods']);
    Route::apiResource('time-tracking-channels', App\Http\Controllers\TimeTrackingChannelController::class);

    Route::get('time-trackings/methods', [App\Http\Controllers\TimeTrackingController::class, 'methods']);
    Route::apiResource('time-trackings', App\Http\Controllers\TimeTrackingController::class);
});

