<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExamEventController;
use App\Http\Controllers\Admin\ExamResultController;
use App\Http\Controllers\Admin\ExamScheduleQuestionController;
use App\Http\Controllers\Admin\ExamScheduleController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamSubmitController;
use App\Models\ExamSession;
use App\Models\Question;
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

Route::prefix('admin')->group(function () {

    // login
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('admin.login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('admin.login.submit');

    // protected admin area
    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('admin.logout');


        Route::prefix('questions')->group(function () {
            Route::get('/', [QuestionController::class, 'index'])
                ->name('admin.questions.index');

            Route::post('/', [QuestionController::class, 'store'])
                ->name('admin.questions.store');

            Route::get('/create', [QuestionController::class, 'create'])
                ->name('admin.questions.create');

            Route::get('/{question}/edit', [QuestionController::class, 'edit'])
                ->name('admin.questions.edit');

            Route::put('/{question}', [QuestionController::class, 'update'])
                ->name('admin.questions.update');

            Route::patch('/{question}/toggle', [QuestionController::class, 'toggleStatus'])
                ->name('admin.questions.toggle');

            Route::get('/preview/by-subject/{subject}', function ($subject) {
                return Question::with('options')
                    ->where('subject_id', $subject)
                    ->where('status', 'published')
                    ->get();
            })->middleware('admin');
        });

        Route::prefix('subjects')->group(function () {
            Route::get('/', [SubjectController::class, 'index'])
                ->name('admin.subjects.index');

            Route::get('/create', [SubjectController::class, 'create'])
                ->name('admin.subjects.create');

            Route::post('/', [SubjectController::class, 'store'])
                ->name('admin.subjects.store');

            Route::get('/{subject}/edit', [SubjectController::class, 'edit'])
                ->name('admin.subjects.edit');

            Route::put('/{subject}', [SubjectController::class, 'update'])
                ->name('admin.subjects.update');

            Route::delete('/{subject}', [SubjectController::class, 'destroy'])
                ->name('admin.subjects.destroy');
        });

        Route::prefix('exam-events')->group(function () {
            Route::get('/', [ExamEventController::class, 'index'])
                ->name('admin.exam-events.index');

            Route::get('/create', [ExamEventController::class, 'create'])
                ->name('admin.exam-events.create');

            Route::post('/', [ExamEventController::class, 'store'])
                ->name('admin.exam-events.store');

            Route::get('/{event}/edit', [ExamEventController::class, 'edit'])
                ->name('admin.exam-events.edit');

            Route::put('/{event}', [ExamEventController::class, 'update'])
                ->name('admin.exam-events.update');
        });

        Route::prefix('exam-schedules')->group(function () {
            Route::get('/', [ExamScheduleController::class, 'index'])
                ->name('admin.exam-schedules.index');

            Route::get('/create', [ExamScheduleController::class, 'create'])
                ->name('admin.exam-schedules.create');

            Route::post('/', [ExamScheduleController::class, 'store'])
                ->name('admin.exam-schedules.store');

            Route::get('/{schedule}/edit', [ExamScheduleController::class, 'edit'])
                ->name('admin.exam-schedules.edit');

            Route::put('/{schedule}', [ExamScheduleController::class, 'update'])
                ->name('admin.exam-schedules.update');

            Route::get('/{schedule}/questions', [ExamScheduleQuestionController::class, 'edit'])
                ->name('admin.exam-schedules.questions');

            Route::post('/{schedule}/questions', [ExamScheduleQuestionController::class, 'update'])
                ->name('admin.exam-schedules.questions.update');
        });

        Route::get(
            '/exam-results',
            [ExamResultController::class, 'index']
        )->name('admin.exam-results.index');

        Route::get(
            '/exam-results/session/{session}',
            [ExamResultController::class, 'show']
        )->name('admin.exam-results.show');

        Route::get(
            '/exam-results/export/{schedule}',
            [App\Http\Controllers\Admin\ExamResultExportController::class, 'export']
        )->name('admin.exam-results.export');
    });
});
