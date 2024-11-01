<?php

use SuperDocs\App\Http\Controllers\CategoryController;
use SuperDocs\App\Http\Controllers\DocController;
use SuperDocs\App\Http\Controllers\ProductController;
use SuperDocs\App\Http\Controllers\SearchController;
use SuperDocs\App\Http\Controllers\SettingsController;
use SuperDocs\App\Http\Controllers\TemplateController;
use SuperDocs\Bootstrap\Route;

Route::post( 'search', [SearchController::class, 'get'], true );

Route::group( ['prefix' => 'category', 'middleware' => ['admin']], function () {
    Route::get( 'order', [CategoryController::class, 'get'] );
    Route::post( 'order', [CategoryController::class, 'order'] );
    Route::get( 'create', [CategoryController::class, 'create_page'] );
    Route::post( 'create', [CategoryController::class, 'create'] );
    Route::get( 'delete', [CategoryController::class, 'delete_page'] );
    Route::post( 'delete', [CategoryController::class, 'delete'] );
    Route::get( 'edit', [CategoryController::class, 'edit_page'] );
    Route::post( 'update', [CategoryController::class, 'update'] );
} );

Route::group( ['prefix' => 'template', 'middleware' => ['admin']], function () {
    Route::get( '/', [TemplateController::class, 'index'] );
    Route::get( 'create', [TemplateController::class, 'create_page'] );
    Route::post( 'create', [TemplateController::class, 'create'] );
} );

Route::group( ['prefix' => 'settings', 'middleware' => ['admin']], function () {
    Route::get( 'general', [SettingsController::class, 'general_page'] );
    Route::post( 'general', [SettingsController::class, 'general'] );
} );

Route::group( ['prefix' => 'doc', 'middleware' => ['admin']], function () {
    Route::get( '/create', [DocController::class, 'create_page'] );
    Route::post('/create', [DocController::class, 'create']);
} );

Route::group( ['prefix' => 'product', 'middleware' => ['admin']], function () {
    Route::get( '/', [ProductController::class, 'index'] );
    Route::get( '/create', [ProductController::class, 'create_page'] );
    Route::post('/create', [ProductController::class, 'create']);
} );
