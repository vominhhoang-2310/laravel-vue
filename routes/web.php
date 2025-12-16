<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoryController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Story;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    $stories = Story::orderByDesc('created_at')
        ->limit(20)
        ->get(['id', 'title', 'author', 'category', 'published_year', 'thumbnail', 'pdf_link'])
        ->map(function ($story) {
            return [
                'id' => $story->id,
                'title' => $story->title,
                'author' => $story->author,
                'category' => $story->category,
                'published_year' => $story->published_year,
                'thumbnail' => $story->thumbnail,
                'thumbnail_url' => $story->thumbnail ? Storage::disk('public')->url($story->thumbnail) : null,
                'pdf_url' => $story->pdf_link ? Storage::disk('public')->url($story->pdf_link) : null,
            ];
        });

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'stories' => $stories,
    ]);
})->name('welcome');

Route::get('/dashboard', function () {
    $totalStories = Story::count();
    $weeklyQuery = Story::whereBetween('created_at', [
        Carbon::now()->startOfWeek(),
        Carbon::now()->endOfWeek(),
    ])->orderByDesc('created_at');
    $weeklyStories = $weeklyQuery->count();

    return Inertia::render('Dashboard', [
        'stats' => [
            'total' => $totalStories,
            'weekly' => $weeklyStories,
        ],
        'weeklyStories' => $weeklyQuery
            ->get(['id', 'title', 'author', 'category', 'published_year', 'thumbnail'])
            ->map(function ($story) {
                return [
                    'id' => $story->id,
                    'title' => $story->title,
                    'author' => $story->author,
                    'category' => $story->category,
                    'published_year' => $story->published_year,
                    'thumbnail' => $story->thumbnail,
                    'thumbnail_url' => $story->thumbnail ? Storage::disk('public')->url($story->thumbnail) : null,
                ];
            }),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/stories', [StoryController::class, 'index'])->name('stories');
    Route::post('/stories', [StoryController::class, 'store'])->name('stories.store');
    Route::put('/stories/{story}', [StoryController::class, 'update'])->name('stories.update');
    Route::delete('/stories/{story}', [StoryController::class, 'destroy'])->name('stories.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
