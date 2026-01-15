<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamSubmitController;
use App\Models\ExamSession;
use Illuminate\Support\Facades\Route;


Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/exam', [ExamController::class, 'index'])
        ->name('exam.index');

    Route::post('/exam/start', [ExamController::class, 'start'])
        ->name('exam.start');

    Route::post('/exam/{session}/autosave', [ExamController::class, 'autosave'])
        ->name('exam.autosave');

    Route::post('/exam/{session}/submit', [
       ExamSubmitController::class,
        'submit'
    ])->name('exam.submit');

    Route::get('/exam/{session}/submit/force', [
       ExamSubmitController::class,
        'forceSubmit'
    ])->name('exam.submit.force');

    
    
    Route::get('/exam/{session}', [ExamController::class, 'show'])
    ->name('exam.show');
    
    Route::get('/exam/{session}/result', function (ExamSession $session) {
        abort_if($session->user_id !== auth()->id(), 403);

        return view('exam.result', compact('session'));
    })->name('exam.result');
});
