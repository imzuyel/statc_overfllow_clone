<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\CKEditorController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::resource('questions', QuestionController::class)->except('show');
Route::get('/questions/{slug}', [QuestionController::class, 'show'])->name('questions.show');



Route::resource('questions.answers', AnswerController::class)->except('index','create','show');

Route::get('question/answer/{aid}/{qid}/accept',  [AnswerController::class, 'acceptAnswer'])->name('answer.accept');


Route::post('question/{question}/favorites',  [AnswerController::class, 'store_favorite'])->name('favorite.question');
Route::delete('question/{question}/favorites',  [AnswerController::class, 'delete_favorite'])->name('favorite.question');




Route::post('ckeditor/image_upload', [CKEditorController::class,'upload'])->name('upload');



