<?php

use Illuminate\Support\Facades\Route;

use Inertia\Inertia;
use Illuminate\Foundation\Application;

use App\Models\HeroSlider;
use App\Models\BloodStock;
use App\Models\BloodDonor;
use App\Models\FooterSetting;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\BloodStockController;
use App\Http\Controllers\Admin\BloodDonorController;
use App\Http\Controllers\Admin\HeroSliderController;
use App\Http\Controllers\Admin\FooterSettingController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login.admin'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'bloodStocks' => BloodStock::all(),
        'mobileUnits' => BloodDonor::orderBy('date', 'asc')->get(),
        'footer' => FooterSetting::first(),
        'heroSliders' => HeroSlider::where('is_active', true)->orderBy('order', 'asc')->get(),
    ]);
})->name('home');

// Dynamic Static Pages for Public UI
Route::get('/{category}/{page?}/{subpage?}', function ($category, $page = null, $subpage = null) {
    // Categories allowed
    if (!in_array($category, ['profil', 'markas', 'donor'])) {
        abort(404);
    }

    $folder = ucfirst($category);
    $componentName = '';

    if ($category === 'profil' && $page === 'struktur' && $subpage) {
        $componentName = 'Struktur/' . ucfirst($subpage);
    } elseif ($category === 'donor' && $page === 'info' && $subpage) {
        $componentName = 'Info/' . ucfirst($subpage);
    } elseif ($page) {
        $componentName = str_replace('-', '', ucwords($page, '-'));
    } else {
        abort(404);
    }

    $component = $folder . '/' . $componentName;
    if (file_exists(resource_path("js/Pages/{$component}.vue"))) {
        return Inertia::render($component);
    }
    
    abort(404);
})->where([
    'category' => '(profil|markas|donor)',
    'page' => '[a-zA-Z0-9-]+',
    'subpage' => '[a-zA-Z0-9-]+'
]);

// Auth Routes
Route::get('/login/admin', [AuthController::class, 'showAdminLogin'])->name('login.admin')->middleware('guest');
Route::get('/login/perawat', [AuthController::class, 'showPerawatLogin'])->name('login.perawat')->middleware('guest');
Route::post('/login/admin', [AuthController::class, 'storeAdminLogin'])->name('login.admin.store')->middleware('guest');
Route::post('/login/perawat', [AuthController::class, 'storePerawatLogin'])->name('login.perawat.store')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::get('/dashboard/perawat', [DashboardController::class, 'perawat'])->name('dashboard.perawat');

    // Admin CRUD Routes (Vue-based, admin only)
    Route::middleware('admin')->prefix('manage')->name('admin.')->group(function () {

        // Stok Darah
        Route::get('/blood-stocks', [BloodStockController::class, 'index'])->name('blood-stocks.index');
        Route::get('/blood-stocks/create', [BloodStockController::class, 'create'])->name('blood-stocks.create');
        Route::post('/blood-stocks', [BloodStockController::class, 'store'])->name('blood-stocks.store');
        Route::get('/blood-stocks/{bloodStock}/edit', [BloodStockController::class, 'edit'])->name('blood-stocks.edit');
        Route::put('/blood-stocks/{bloodStock}', [BloodStockController::class, 'update'])->name('blood-stocks.update');
        Route::delete('/blood-stocks/{bloodStock}', [BloodStockController::class, 'destroy'])->name('blood-stocks.destroy');

        // Donor Darah
        Route::get('/blood-donors', [BloodDonorController::class, 'index'])->name('blood-donors.index');
        Route::get('/blood-donors/create', [BloodDonorController::class, 'create'])->name('blood-donors.create');
        Route::post('/blood-donors', [BloodDonorController::class, 'store'])->name('blood-donors.store');
        Route::get('/blood-donors/{bloodDonor}/edit', [BloodDonorController::class, 'edit'])->name('blood-donors.edit');
        Route::put('/blood-donors/{bloodDonor}', [BloodDonorController::class, 'update'])->name('blood-donors.update');
        Route::delete('/blood-donors/{bloodDonor}', [BloodDonorController::class, 'destroy'])->name('blood-donors.destroy');

        // Hero Slider / Background
        Route::get('/hero-sliders', [HeroSliderController::class, 'index'])->name('hero-sliders.index');
        Route::get('/hero-sliders/create', [HeroSliderController::class, 'create'])->name('hero-sliders.create');
        Route::post('/hero-sliders', [HeroSliderController::class, 'store'])->name('hero-sliders.store');
        Route::get('/hero-sliders/{heroSlider}/edit', [HeroSliderController::class, 'edit'])->name('hero-sliders.edit');
        Route::post('/hero-sliders/{heroSlider}', [HeroSliderController::class, 'update'])->name('hero-sliders.update');
        Route::delete('/hero-sliders/{heroSlider}', [HeroSliderController::class, 'destroy'])->name('hero-sliders.destroy');

        // Layanan
        Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
        Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
        Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
        Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
        Route::post('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
        Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

        // Berita
        Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
        Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::post('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

        // Kategori Berita
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Manajemen User
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Pengaturan Footer
        Route::get('/footer-setting', [FooterSettingController::class, 'index'])->name('footer-setting.index');
        Route::post('/footer-setting', [FooterSettingController::class, 'upsert'])->name('footer-setting.upsert');
    });
});

