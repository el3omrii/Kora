<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\ScraperController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SitemapController;

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
    return redirect('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    /* Sources */
    Route::get('/sources', [SourceController::class, 'index'])->name('source.index');
    Route::post('/sources', [SourceController::class, 'store'])->name('source.store');
    Route::put('/sources/{source}', [SourceController::class, 'update'])->name('source.update');
    Route::delete('/sources/{source}', [SourceController::class, 'destroy'])->name('source.destroy');
    /* Scraper */
    Route::get('/sources/scraper/{source}', [ScraperController::class, 'scrape'])->name('source.scraper');
    Route::get('/sources/scraper/{source}/entries', [ScraperController::class, 'entries'])->name('source.scraper.entries');
    Route::post('/sources/scraper/publish', [ScraperController::class, 'publish'])->name('source.scraper.publish');
    Route::post('/sources/scraper/manual', [ScraperController::class, 'manual'])->name('source.scraper.manual');
    /* Posts */
    Route::get('/posts', [PostController::class, 'index'])->name('post.index');
    Route::get('/posts/new', [PostController::class, 'create'])->name('post.create');
    Route::post('/posts/new', [PostController::class, 'store'])->name('post.store');
    Route::get('/posts/edit/{post}', [PostController::class, 'edit'])->name('post.edit');
    Route::post('/posts/edit/{post}', [PostController::class, 'update'])->name('post.update');
    Route::post('/posts/fetch', [PostController::class, 'fetch'])->name('post.fetch');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('post.destroy');
    Route::post('/posts/setfeatured/{post}', [PostController::class, 'set_featured'])->name('post.set_featured');
    /* POSTS CATEGORIES */
    Route::get('/posts/categories', [PostController::class, 'categories'])->name('post.categories');
    Route::post('/posts/categories', [PostController::class, 'storeCategory'])->name('post.categories.store');
    Route::delete('/posts/categories/{category}', [PostController::class, 'destroyCategory'])->name('post.categories.destroy');
    Route::put('/posts/categories/{category}', [PostController::class, 'updateCategory'])->name('post.categories.update');
    /* POSTS TAGS */
    Route::get('/posts/tags', [PostController::class, 'tags'])->name('post.tags');
    Route::post('/posts/tags', [PostController::class, 'storeTag'])->name('post.tags.store');
    Route::delete('/posts/tags/{category}', [PostController::class, 'destroTag'])->name('post.tags.destroy');
    /* Matchs */
    Route::get('/matchs', [MatchController::class, 'index'])->name('match.index');
    Route::get('/matchs/scheduled', [MatchController::class, 'scheduled'])->name('match.scheduled');
    Route::get('/matchs/fixtures', [MatchController::class, 'fixtures']);
    Route::post('/matchs/scheduled', [MatchController::class, 'load_scheduled']);
    Route::post('/matchs/publish', [MatchController::class, 'publish']);
    Route::put('/matchs/{fixture}', [MatchController::class, 'update']);
    Route::delete('/matchs/{fixture}', [MatchController::class, 'destroy']);
    /* Translations */
    Route::get('/translations', [TranslationController::class, 'index'])->name('translations');
    Route::post('/translations', [TranslationController::class, 'translations']);
    Route::put('/translations/{translation}', [TranslationController::class, 'saveTranslation']);
    Route::delete('/translations/{translation}', [TranslationController::class, 'destroy']);
    /* Settings */
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    //Route::post('/posts/fetch', [PostController::class, 'fetch'])->name('post.fetch');
});

require __DIR__ . '/auth.php';

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');