<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\ContentController as AdminContentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RequestController as AdminRequestController;
use App\Http\Controllers\Admin\TranslationController as AdminTranslationController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VideoMessageController as AdminVideoMessageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LiveController;
use App\Http\Controllers\MissingPersonRequestController;
use App\Http\Controllers\PersonInfoReportController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\VideoMessageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/locale/{locale}', [HomeController::class, 'setLocale'])->name('locale.set');

Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/live', [LiveController::class, 'index'])->name('live');

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::post('/search', [SearchController::class, 'store'])->middleware('throttle:20,1')->name('search.store');

Route::get('/missing-person', [MissingPersonRequestController::class, 'create'])->name('missing-person.create');
Route::post('/missing-person', [MissingPersonRequestController::class, 'store'])->middleware('throttle:20,1')->name('missing-person.store');

Route::middleware('auth')->group(function (): void {
    Route::get('/cabinet', [HomeController::class, 'cabinet'])->name('cabinet');
    Route::get('/provide-info', [PersonInfoReportController::class, 'create'])->name('provide-info.create');
    Route::post('/provide-info', [PersonInfoReportController::class, 'store'])->middleware('throttle:20,1')->name('provide-info.store');
});

Route::get('/video-messages', [VideoMessageController::class, 'index'])->name('video-messages.index');
Route::get('/video-messages/create', [VideoMessageController::class, 'create'])->middleware('auth')->name('video-messages.create');
Route::post('/video-messages', [VideoMessageController::class, 'store'])->middleware(['auth', 'throttle:10,1'])->name('video-messages.store');

Auth::routes();

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/requests', [AdminRequestController::class, 'index'])->name('requests.index');
    Route::put('/requests/missing/{missingPersonRequest}', [AdminRequestController::class, 'updateMissing'])->name('requests.missing.update');
    Route::put('/requests/report/{personInfoReport}', [AdminRequestController::class, 'updateReport'])->name('requests.report.update');

    Route::get('/video-messages', [AdminVideoMessageController::class, 'index'])->name('videos.index');
    Route::put('/video-messages/{videoMessage}', [AdminVideoMessageController::class, 'update'])->name('videos.update');

    Route::get('/content', [AdminContentController::class, 'index'])->name('content.index');
    Route::put('/content', [AdminContentController::class, 'update'])->name('content.update');
    Route::put('/content/social/{socialLink}', [AdminContentController::class, 'updateSocial'])->name('content.social.update');

    Route::get('/translations', [AdminTranslationController::class, 'index'])->name('translations.index');
    Route::put('/translations', [AdminTranslationController::class, 'update'])->name('translations.update');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
});
