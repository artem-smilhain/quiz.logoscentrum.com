<?php

use App\Http\Controllers\Question\QuestionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use \App\Http\Controllers\Answer\AnswerController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('admin.index');

//группа страаниц админа
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {

    //группа страаниц для юзеров
    Route::group(['prefix' => 'users', 'namespace' => 'Admin'], function () {
        Route::get('/index', [UserController::class, 'index'])->name('users.index');
        //Route::get('/show/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
        Route::patch('/update/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/destroy/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
    });

    //группа страаниц для вопросов
    Route::group(['prefix' => 'questions', 'namespace' => 'Admin'], function () {
        Route::get('/index', [QuestionController::class, 'index'])->name('questions.index');
        //Route::get('/show/{question}', [QuestionController::class, 'show'])->name('questions.show');
        Route::get('/edit/{question}', [QuestionController::class, 'edit'])->name('questions.edit');
        Route::patch('/update/{question}', [QuestionController::class, 'update'])->name('questions.update');
        Route::delete('/destroy/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
        Route::get('/create', [QuestionController::class, 'create'])->name('questions.create');
        Route::post('/store', [QuestionController::class, 'store'])->name('questions.store');
    });

    //группа страаниц для ответов
    Route::group(['prefix' => 'answers', 'namespace' => 'Admin'], function () {
        Route::get('/index', [AnswerController::class, 'index'])->name('answers.index');
        //Route::get('/show/{answer}', [AnswerController::class, 'show'])->name('answers.show');
        Route::get('/edit/{answer}', [AnswerController::class, 'edit'])->name('answers.edit');
        Route::patch('/update/{answer}', [AnswerController::class, 'update'])->name('answers.update');
        Route::delete('/destroy/{answer}', [AnswerController::class, 'destroy'])->name('answers.destroy');
        Route::get('/create', [AnswerController::class, 'create'])->name('answers.create');
        Route::post('/store', [AnswerController::class, 'store'])->name('answers.store');
    });

});
