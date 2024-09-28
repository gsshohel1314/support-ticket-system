<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TicketReplyController;
use App\Http\Controllers\User\TicketController;
use App\Http\Controllers\Admin\TicketCategoryController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if(auth()->check()){
        if(in_array(auth()->user()->role_id,[1])){
            return redirect(url('/admin/tickets'));
        }elseif(in_array(auth()->user()->role_id,[2])){
            return redirect(url('/user/tickets'));
        }
    }
    return redirect(url('/login'));
})->name('index');

Route::get('/login', [LoginController::class,'showUserLogin'])->name('login-show');
Route::post('/login', [LoginController::class,'userLogin'])->name('login');
Route::get('/register', [LoginController::class,'showUserRegister'])->name('register-show');
Route::post('/register', [LoginController::class,'userRegister'])->name('register');
Route::get('/logout', [LoginController::class,'logout'])->name('logout')->middleware('auth:web');

Route::group(['prefix' => 'admin','as' => 'admin.'], function(){
    Route::get('/', [LoginController::class,'showAdminLogin'])->name('login-show');
    Route::post('/', [LoginController::class,'adminLogin'])->name('login');

    Route::group(['middleware' => ['auth','admin']], function(){
        Route::resource('ticket-categories', TicketCategoryController::class)->except(['update','show']);
        Route::get('/ticket-categories/get-list', [TicketCategoryController::class,'getList'])->name('ticket-categories.get-list');
        Route::post('/ticket-categories/update', [TicketCategoryController::class,'update'])->name('ticket-categories.update');

        Route::resource('tickets', AdminTicketController::class)->except(['update','show','destroy']);
        Route::get('/tickets/get-list', [AdminTicketController::class, 'getList'])->name('tickets.get-list');
        Route::get('/tickets/view/{id}', [AdminTicketController::class, 'view'])->name('tickets.view-ticket');
        Route::post('/tickets/reject/{id}', [AdminTicketController::class, 'reject'])->name('tickets.reject-ticket');

        Route::post('/reply-ticket', [TicketReplyController::class,'replyByAdmin'])->name('ticket_reply');
    });
});

Route::group(['prefix' => 'user','as' => 'user.'], function(){
    Route::group(['middleware' => ['auth','user']], function(){
        Route::resource('tickets', TicketController::class)->except(['update', 'show']);
        Route::get('tickets/get-list', [TicketController::class, 'getList'])->name('tickets.get-list');
        Route::post('/tickets/update', [TicketController::class, 'update'])->name('tickets.update');
        Route::post('/tickets/remove-file', [TicketController::class, 'removeFile'])->name('tickets.remove-file');
        Route::get('/tickets/view/{id}', [TicketController::class, 'view'])->name('tickets.view-ticket');

        Route::post('/reply-ticket', [TicketReplyController::class,'replyByUser'])->name('ticket_reply');
    });
});
