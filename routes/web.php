<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ClassroomPeopleController;
use App\Http\Controllers\ClassWorkController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\JoinClassroomController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\TopicController;
use App\Models\Classwork;
use App\Models\User;
use Illuminate\Http\Request;
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


Route::middleware(['auth', 'user.preferences'])->group(function () {

    // Classrooms routes
    Route::prefix('/classrooms/trached')->controller(ClassroomController::class)->group(function () {
        Route::get('/', 'trached')->name('classrooms.trached');
        Route::put('/restore/{id}', 'restore')->name('classrooms.restore');
        Route::delete('/forceDelete/{id}', 'forceDelete')->name('classrooms.forceDelete');
    });
    /*    Route::resource('classrooms',ClassroomController::class)
          // ->names([ 'index'=>'classrooms','create'=>'classrooms' ]); 
            */

    // Join classrooms routes
    Route::get('/classrooms/{classroom}/join', [JoinClassroomController::class, 'create'])
        ->middleware('signed')
        ->name('classrooms.join');
    Route::post('/classrooms/{classroom}/join', [JoinClassroomController::class, 'store'])
        ->name('classrooms.join');


    // trached topics routes
    Route::prefix('classrooms/{classroom}/topics/trached')->controller(TopicController::class)->group(function () {
        Route::get('/', 'trached')->name('topics.trached');
        Route::put('/restore/{topic}', 'restore')->name('topics.restore');
        Route::delete('/forceDelete/{topic}', 'forceDelete')->name('topics.forceDelete');
    });

    Route::resources([
        'classrooms.topics' => TopicController::class,
        'classrooms' => ClassroomController::class,
        'classrooms.classworks' => ClassWorkController::class,
    ]);

    Route::get('/classrooms/{classroom}/people', [ClassroomPeopleController::class, 'index'])->name('classrooms.people');
    Route::delete('/classrooms/{classroom}/people', [ClassroomPeopleController::class, 'destroy'])->name('classrooms.people.destroy');

    // Comments

    Route::post('comments', [CommentController::class, 'store'])
        ->name('comments.store');

    Route::post('classwork/{classwork}/submission', [SubmissionController::class, 'store'])
        ->name('submissions.store')
        // ->middleware('can:submissions.create,classwork');
        // ->middleware('can:submissions.create,app\Model\Classwork');
    ;

    Route::get('submissions/{submission}/file', [SubmissionController::class, 'file'])
        ->name('submissions.file');



    // Nested resources
    //Route::resource('classrooms.topics',TopicController::class);

    // Class Works routes
    //Route::resource('classrooms.classworks',ClassWorkController::class)->shallow();


});



Route::get('/charts', function () {
    return view('charts');
});




require __DIR__ . '/auth.php';
