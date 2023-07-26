<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\JoinClassroomController;
use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



/* Route::get('/classrooms',[ClassroomController::class,'index'])->name('classrooms.index');
Route::get('/classrooms/create',[ClassroomController::class,'create'])->name('classrooms.create');
Route::post('/classrooms/create',[ClassroomController::class,'store'])->name('classrooms.store');
Route::get('/classrooms/{id}',[ClassroomController::class,'show'])->name('classrooms.show');
Route::get('/classrooms/edit/{id}',[ClassroomController::class,'edit'])->name('classrooms.edit');
Route::put('/classrooms/edit/{id}',[ClassroomController::class,'update'])->name('classrooms.update');
Route::delete('/classrooms/delete/{id}',[ClassroomController::class,'destroy'])->name('classrooms.delete'); */


Route::middleware(['auth'])->group(function(){

    // Classrooms routes
    Route::prefix('/classrooms/trached')->controller(ClassroomController::class)->group(function(){  
        Route::get('/', 'trached')->name('classrooms.trached');
        Route::put('/restore/{id}', 'restore')->name('classrooms.restore');
        Route::delete('/forceDelete/{id}', 'forceDelete')->name('classrooms.forceDelete');
    });
    Route::resource('classrooms',ClassroomController::class)
           ->names([/* 'index'=>'classrooms','create'=>'classrooms' */]);
   
        // Join classrooms routes
    Route::get('/classrooms/{classroom}/join',[JoinClassroomController::class,'create'])
    ->middleware('signed')
    ->name('classrooms.join');
    Route::post('/classrooms/{classroom}/join',[JoinClassroomController::class,'store'])
    ->name('classrooms.join');


    // trached topics routes
    Route::prefix('classrooms/{classroom}/topics/trached')->controller(TopicController::class)->group(function(){  
        Route::get('/', 'trached')->name('topics.trached');
        Route::put('/restore/{topic}', 'restore')->name('topics.restore');
        Route::delete('/forceDelete/{topic}', 'forceDelete')->name('topics.forceDelete');
    });

    // tpoics routes
    // Nested resources
    Route::resource('classrooms.topics',TopicController::class);
   
    
        
    });
    







require __DIR__.'/auth.php';
