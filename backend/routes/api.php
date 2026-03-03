<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\EstimateController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ActivityController;

Route::post('/login',    [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout',          [AuthController::class, 'logout']);
    Route::get('/me',               [AuthController::class, 'me']);
    Route::put('/profile',          [AuthController::class, 'updateProfile']);
    Route::put('/profile/password', [AuthController::class, 'updatePassword']);

    Route::get('/dashboard',               [DashboardController::class, 'index']);
    Route::get('/dashboard/revenue-chart', [DashboardController::class, 'revenueChart']);

    Route::apiResource('users',    UserController::class);
    Route::put('/users/{user}/toggle-status', [UserController::class, 'toggleStatus']);

    Route::apiResource('clients',  ClientController::class);
    Route::get('/clients/{client}/projects', [ClientController::class, 'projects']);
    Route::get('/clients/{client}/invoices', [ClientController::class, 'invoices']);
    Route::get('/clients/{client}/contacts', [ClientController::class, 'contacts']);
    Route::apiResource('contacts', ContactController::class);

    Route::apiResource('projects', ProjectController::class);
    Route::post('/projects/{project}/members',            [ProjectController::class, 'addMember']);
    Route::delete('/projects/{project}/members/{user}',   [ProjectController::class, 'removeMember']);

    Route::apiResource('tasks', TaskController::class);
    Route::put('/tasks/{task}/status',       [TaskController::class, 'updateStatus']);
    Route::post('/tasks/{task}/timer/start', [TaskController::class, 'startTimer']);
    Route::post('/tasks/{task}/timer/stop',  [TaskController::class, 'stopTimer']);

    Route::apiResource('invoices', InvoiceController::class);
    Route::post('/invoices/{invoice}/send',           [InvoiceController::class, 'send']);
    Route::post('/invoices/{invoice}/mark-paid',      [InvoiceController::class, 'markPaid']);
    Route::post('/invoices/{invoice}/duplicate',      [InvoiceController::class, 'duplicate']);
    Route::post('/invoices/{invoice}/record-payment', [InvoiceController::class, 'recordPayment']);
    Route::get('/invoices/{invoice}/pdf',             [InvoiceController::class, 'pdf']);

    Route::apiResource('payments',  PaymentController::class);
    Route::apiResource('estimates', EstimateController::class);
    Route::post('/estimates/{estimate}/send',    [EstimateController::class, 'send']);
    Route::post('/estimates/{estimate}/convert', [EstimateController::class, 'convertToInvoice']);

    Route::apiResource('leads', LeadController::class);
    Route::put('/leads/{lead}/status',   [LeadController::class, 'updateStatus']);
    Route::post('/leads/{lead}/convert', [LeadController::class, 'convertToClient']);

    Route::apiResource('expenses', ExpenseController::class);

    Route::get('/settings',          [SettingsController::class, 'index']);
    Route::post('/settings',         [SettingsController::class, 'update']);
    Route::get('/settings/company',  [SettingsController::class, 'company']);
    Route::post('/settings/company', [SettingsController::class, 'updateCompany']);

    Route::get('/notifications',            [NotificationController::class, 'index']);
    Route::get('/notifications/unread',     [NotificationController::class, 'unread']);
    Route::put('/notifications/{id}/read',  [NotificationController::class, 'markRead']);
    Route::put('/notifications/read-all',   [NotificationController::class, 'markAllRead']);
    Route::delete('/notifications/{id}',    [NotificationController::class, 'destroy']);

    Route::get('/activities', [ActivityController::class, 'index']);
});