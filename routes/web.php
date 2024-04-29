<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/contacts', [ContactController::class, 'index'])->name('index');

Route::get('/contacts/find', [ContactController::class, 'find'])->name('find');
// Route::get('/contacts/find/{id}', [ContactController::class, 'show'])->name('show');

Route::post('/contacts', [ContactController::class, 'store'])->name('store');

Route::get('/contacts/{campaignId}', [ContactController::class, 'getContactsByCampaignId']);

Route::get('/sucesso', [ContactController::class, 'successForm'])->name('success-form');
