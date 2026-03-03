<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portal\InvoicePortalController;
Route::get('/', fn() => response()->json(['name' => config('app.name'), 'version' => '1.0.0']));
Route::prefix('portal')->group(function () {
    Route::get('/invoice/{token}',      [InvoicePortalController::class, 'show']);
    Route::post('/invoice/{token}/pay', [InvoicePortalController::class, 'pay']);
    Route::get('/invoice/{token}/pdf',  [InvoicePortalController::class, 'pdf']);
});