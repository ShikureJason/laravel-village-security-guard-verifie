<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthTokens;
use App\Http\Controllers\AuthUser;
use App\Http\Controllers\GuestUserController;


Route::post('register',[AuthUser::class, 'registration']);
Route::post('login',[AuthUser::class, 'authenticate']);

Route::controller(AuthTokens::class)->group(function (){
    Route::post('create', 'Create');
    Route::post('verifie', 'Verifie');
});

Route::controller(GuestUserController::class)->group(function (){
    Route::post('add/create', 'Create');
});

