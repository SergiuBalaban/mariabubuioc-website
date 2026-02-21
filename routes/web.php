<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'home'])->name('home');
Route::get('/about', [UserController::class, 'about'])->name('about');
Route::get('/blog', [UserController::class, 'blog'])->name('blog');
Route::get('/blogs/{blog}', [UserController::class, 'article'])->name('blog.article');
Route::get('/projects/{project}', [UserController::class, 'project'])->name('project.detail');

Route::get('dashboard', [DashboardController::class, 'show'])->middleware(['auth', 'verified'])->name('dashboard');
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function (): void {
    Route::prefix('blogs')->group(function (): void {
        Route::get('', [BlogController::class, 'show'])->name('admin.blogs');
        Route::post('upload-cover', [BlogController::class, 'uploadCover'])->name('admin.blogs.upload-cover');
        Route::prefix('{blog}')->group(function (): void {
            Route::get('', [BlogController::class, 'edit'])->name('admin.blogs.edit');
            Route::put('', [BlogController::class, 'update'])->name('admin.blogs.update');
            Route::delete('', [BlogController::class, 'destroy'])->name('admin.blogs.destroy');
        });
    });

    Route::prefix('projects')->group(function (): void {
        Route::get('', [ProjectController::class, 'show'])->name('admin.projects');
    });
});

require __DIR__.'/settings.php';
