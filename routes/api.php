<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Penyewa\MidtransController;

Route::post('/midtrans/callback', [MidtransController::class, 'callback']);
