<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});


/* Route::get('/classrooms',[ClassroomController::class,'index'])->name('classrooms.index');
Route::get('/classrooms/create',[ClassroomController::class,'create'])->name('classrooms.create');
Route::post('/classrooms/create',[ClassroomController::class,'store'])->name('classrooms.store');
Route::get('/classrooms/{id}',[ClassroomController::class,'show'])->name('classrooms.show');
Route::get('/classrooms/edit/{id}',[ClassroomController::class,'edit'])->name('classrooms.edit');
Route::put('/classrooms/edit/{id}',[ClassroomController::class,'update'])->name('classrooms.update');
Route::delete('/classrooms/delete/{id}',[ClassroomController::class,'destroy'])->name('classrooms.delete'); */


Route::resource('classrooms',ClassroomController::class)->names([/* 'index'=>'classrooms','create'=>'classrooms' */]);

Route::get('/classrooms/{id}/topics',[TopicController::class,'index'])->name('topics');
Route::get('/classrooms/{id}/topics/create',[TopicController::class,'create'])->name('topics.create');
Route::post('/classrooms/topics/create',[TopicController::class,'store'])->name('topics.store');
Route::get('/classrooms/topics/edit/{id}',[TopicController::class,'edit'])->name('topics.edit');
Route::put('/classrooms/topics/edit/{id}',[TopicController::class,'update'])->name('topics.update');
Route::delete('/classrooms/topics/delete/{id}',[TopicController::class,'destroy'])->name('topics.delete');
