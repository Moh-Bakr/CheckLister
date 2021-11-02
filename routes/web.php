<?php

use App\Http\Controllers\Admin\ChecklistController;
use App\Http\Controllers\Admin\ChecklistGroupController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'welcome');

Auth::routes();
Route::group(['middleware' => ['auth', 'save_last_action_timestamp']], function () {
    Route::get('welcome', [\App\Http\Controllers\PageController::class, 'welcome'])
        ->name('welcome');
    Route::get('consultation', [\App\Http\Controllers\PageController::class, 'consultation'])
        ->name('consultation');
    Route::get('checklists/{checklist}', [\App\Http\Controllers\User\ChecklistController::class, 'show'])
        ->name('user.checklists.show');

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'is_admin'],
        function () {
            Route::resource('pages', PageController::class)->only(['edit', 'update']);;
            Route::resource('checklist_groups', ChecklistGroupController::class);
            Route::resource('checklist_groups.checklists', ChecklistController::class);
            Route::resource('checklists.tasks', TaskController::class);
            Route::get('users', [\App\Http\Controllers\Admin\UserController::class, 'index'])
                ->name('users.index');
            Route::post('images', [\App\Http\Controllers\Admin\ImageController::class, 'store'])
                ->name('images.store');
        });
});
Route::get('/home', [HomeController::class, 'index'])->name('home');
