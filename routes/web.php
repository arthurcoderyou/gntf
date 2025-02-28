<?php

use App\Http\Controllers\PlayerRegistrationController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TournamentEventCategoryController;
use App\Http\Controllers\TournamentEventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ActivityLogController;

Route::view('/', 'welcome');


 

Route::middleware(['throttle:60,1','auth', 'verified'])->group(function () {

    
    Route::view('dashboard', 'dashboard') 
        ->name('dashboard');

    Route::view('profile', 'profile') 
        ->middleware(['role.permission:role:DSI God Admin,permission:profile update information,permission:profile update password'])
        ->name('profile');

    #   activity_logs
        Route::get('activity_logs',[ActivityLogController::class, 'index'])
            ->middleware(['role.permission:role:DSI God Admin,permission:activity logs list']) 
            ->name('activity_logs.index');

    #   ./ activity_logs

    #   user
        Route::get('user',[UserController::class, 'index'])
            ->middleware(['role.permission:role:DSI God Admin,permission:user list']) 
            ->name('user.index');
        Route::get('user/create',[UserController::class, 'create'])
            ->middleware(['role.permission:role:DSI God Admin,permission:user create'])     
            ->name('user.create');
        Route::get('user/{user}/edit',[UserController::class, 'edit'])
            ->middleware(['role.permission:role:DSI God Admin,permission:user edit'])   
            ->name('user.edit');
    #   ./ user


    # role
        Route::get('role',[RoleController::class, 'index'])
            ->middleware(['role.permission:role:DSI God Admin,permission:role list'])   
            ->name('role.index');
        Route::get('role/create',[RoleController::class, 'create'])
            ->middleware(['role.permission:role:DSI God Admin,permission:role create'])  
            ->name('role.create');
        Route::get('role/{role}/edit',[RoleController::class, 'edit'])
            ->middleware(['role.permission:role:DSI God Admin,permission:role edit'])  
            ->name('role.edit');
        Route::get('role/{role}/add_permissions',[RoleController::class, 'add_permissions'])
            ->middleware(['role.permission:role:DSI God Admin,permission:role view permission']) 
            ->name('role.add_permissions');
    # ./ role

    # permission
        Route::get('permission',[PermissionController::class, 'index'])
            ->middleware(['role.permission:role:DSI God Admin,permission:permission list']) 
            ->name('permission.index');
        Route::get('permission/create',[PermissionController::class, 'create'])
            ->middleware(['role.permission:role:DSI God Admin,permission:permission create']) 
            ->name('permission.create');
        Route::get('permission/{permission}/edit',[PermissionController::class, 'edit'])
            ->middleware(['role.permission:role:DSI God Admin,permission:permission edit']) 
            ->name('permission.edit');
    # ./ permission


    # tournament
        Route::get('tournament',[TournamentController::class, 'index'])
            ->middleware(['role.permission:role:DSI God Admin,permission:tournament list']) 
            ->name('tournament.index');
        Route::get('tournament/create',[TournamentController::class, 'create'])
            ->middleware(['role.permission:role:DSI God Admin,permission:tournament create'])
            ->name('tournament.create');
        Route::get('tournament/{tournament}/edit',[TournamentController::class, 'edit'])
            ->middleware(['role.permission:role:DSI God Admin,permission:tournament edit'])
            ->name('tournament.edit');
    # ./ tournament

    # tournament_event
        Route::get('tournament_event',[TournamentEventController::class, 'index'])
            ->middleware(['role.permission:role:DSI God Admin,permission:event list']) 
            ->name('tournament_event.index');
        Route::get('tournament_event/create',[TournamentEventController::class, 'create'])
        ->middleware(['role.permission:role:DSI God Admin,permission:event create'])
            ->name('tournament_event.create');
        Route::get('tournament_event/{tournament_event}/edit',[TournamentEventController::class, 'edit'])
            ->middleware(['role.permission:role:DSI God Admin,permission:event edit'])
            ->name('tournament_event.edit');
    # ./ tournament_event

    # tournament_event_category
        Route::get('tournament_event_category',[TournamentEventCategoryController::class, 'index'])
            ->middleware(['role.permission:role:DSI God Admin,permission:category list'])
            ->name('tournament_event_category.index');
        Route::get('tournament_event_category/create',[TournamentEventCategoryController::class, 'create'])
            ->middleware(['role.permission:role:DSI God Admin,permission:category create'])
            ->name('tournament_event_category.create');
        Route::get('tournament_event_category/{tournament_event_category}/edit',[TournamentEventCategoryController::class, 'edit'])
            ->middleware(['role.permission:role:DSI God Admin,permission:category edit'])
            ->name('tournament_event_category.edit');
    # ./ tournament_event_category


    # player_registration
        Route::get('player_registration',[PlayerRegistrationController::class, 'index'])
            ->middleware(['role.permission:role:DSI God Admin,permission:registration list'])
            ->name('player_registration.index');
        Route::get('player_registration/{player_registration}/edit',[PlayerRegistrationController::class, 'edit'])
            ->middleware(['role.permission:role:DSI God Admin,permission:registration edit'])
            ->name('player_registration.edit');
        Route::get('player_registration/{player_registration}/show',[PlayerRegistrationController::class, 'show'])
            ->middleware(['role.permission:role:DSI God Admin,permission:registration view'])
            ->name('player_registration.show');
    # ./ player_registration





});


require __DIR__.'/auth.php';
