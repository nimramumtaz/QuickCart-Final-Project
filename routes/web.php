<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AiAssistantController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StoreController::class, 'index'])->name('store.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::post('/contact', [ContactController::class, 'message'])->name('contact.message');
Route::post('/newsletter', [ContactController::class, 'newsletter'])->name('newsletter.store');
Route::post('/ai/ask', [AiAssistantController::class, 'ask'])->name('ai.ask');
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
