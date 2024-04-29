<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ContactController::class, 'index'])->name('index');

Route::get('/contacts/find', [ContactController::class, 'find'])->name('find');

Route::post('/contacts', [ContactController::class, 'store'])->name('store');

Route::get('/contacts/{campaignId}', [ContactController::class, 'getContactsByCampaignId']);

Route::get('/sucesso', [ContactController::class, 'successForm'])->name('success-form');
