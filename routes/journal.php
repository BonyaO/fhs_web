<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Journal\JournalController;
use App\Http\Controllers\Journal\ArchiveController;
use App\Http\Controllers\Journal\ArticleController;
use App\Http\Controllers\Journal\EditorialBoardController;

/*
|--------------------------------------------------------------------------
| Journal Routes
|--------------------------------------------------------------------------
|
*/

Route::prefix('journal')->name('journal.')->group(function () {
    
    // Homepage
    Route::get('/', [JournalController::class, 'home'])->name('home');
    
    // About & Information Pages
    Route::get('/about', [JournalController::class, 'about'])->name('about');
    Route::get('/submission', [JournalController::class, 'submission'])->name('submission');
    Route::get('/policies', [JournalController::class, 'policies'])->name('policies');
    
    // Editorial Board
    Route::get('/editorial-board', [EditorialBoardController::class, 'index'])->name('editorial-board');
    
    // Archive & Browse
    Route::get('/archive', [ArchiveController::class, 'index'])->name('archive');
    Route::get('/archive/volume-{volume}', [ArchiveController::class, 'volume'])->name('archive.volume');
    Route::get('/volume-{volume}/issue-{issue}', [ArchiveController::class, 'issue'])->name('issue');
    
    // Articles
    Route::get('/articles/{article:slug}', [ArticleController::class, 'show'])->name('article.show');
    Route::get('/articles/{article:slug}/download', [ArticleController::class, 'download'])->name('article.download');
    Route::post('/articles/{article:slug}/track-view', [ArticleController::class, 'trackView'])->name('article.track-view');
    
    // Search
    Route::get('/search', [ArticleController::class, 'search'])->name('search');
    
    // Author & Affiliation Pages (optional, for future)
    Route::get('/authors/{author:slug}', [ArticleController::class, 'byAuthor'])->name('author.show');
    
    // Browse by keyword
    Route::get('/keywords/{keyword}', [ArticleController::class, 'byKeyword'])->name('keyword.show');
});