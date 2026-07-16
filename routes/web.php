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
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\MenuController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

// Route untuk memperbaiki link storage secara permanen (tanpa symlink) dan memindahkan ke folder uploads
Route::get('/fix-storage', function () {
    try {
        $publicUploads = public_path('uploads');
        $appStorage = storage_path('app/public');
        $oldStorage = public_path('storage');

        // Hapus symlink atau file jika sudah ada
        if (is_link($oldStorage) || is_file($oldStorage)) {
            unlink($oldStorage);
        }

        // Buat folder uploads di public jika belum ada
        if (!is_dir($publicUploads)) {
            mkdir($publicUploads, 0777, true);
        }

        // Clear config cache so the new filesystems.php config is used
        Artisan::call('config:clear');
        Artisan::call('cache:clear');

        // Copy semua file dari storage/app/public ke public/uploads (agar gambar lama tidak hilang)
        if (is_dir($appStorage)) {
            File::copyDirectory($appStorage, $publicUploads);
        }

        // Jika folder public/storage ada dan itu adalah folder asli (bukan symlink), copy juga isinya
        if (is_dir($oldStorage)) {
            File::copyDirectory($oldStorage, $publicUploads);
        }

        return 'Storage folder set up successfully & Cache cleared! Gambar Anda sudah aman (dipindah ke folder uploads). Silakan cek ulang.';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

// Fallback route untuk melayani file gambar jika server Alwaysdata tidak bisa melayaninya langsung
Route::get('/uploads/{path}', function ($path) {
    $filePath = public_path('uploads/' . $path);
    if (file_exists($filePath)) {
        return response()->file($filePath);
    }
    abort(404);
})->where('path', '.*');

Route::get('/debug-storage', function () {
    $out = "<h3>Debug Storage</h3>";
    $out .= "<b>public_path('uploads/hero-sliders')</b><br>";
    $publicDir = public_path('uploads/hero-sliders');
    if (is_dir($publicDir)) {
        $files = scandir($publicDir);
        foreach ($files as $f) {
            if ($f !== '.' && $f !== '..') {
                $url = asset('uploads/hero-sliders/' . $f);
                $out .= "<a href='$url'>$f</a> - Size: " . filesize($publicDir . '/' . $f) . " bytes<br>";
            }
        }
    } else {
        $out .= "Directory not found.<br>";
    }
    
    $out .= "<br><b>storage_path('app/public/hero-sliders')</b><br>";
    $appDir = storage_path('app/public/hero-sliders');
    if (is_dir($appDir)) {
        $files = scandir($appDir);
        foreach ($files as $f) {
            if ($f !== '.' && $f !== '..') {
                $out .= "$f - Size: " . filesize($appDir . '/' . $f) . " bytes<br>";
            }
        }
    } else {
        $out .= "Directory not found.<br>";
    }
    return $out;
});

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login.admin'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'bloodStocks' => \App\Models\BloodStock::all(),
        'mobileUnits' => \App\Models\BloodDonor::orderBy('date', 'asc')->get(),
        'footer' => \App\Models\FooterSetting::first(),
        'heroSliders' => \App\Models\HeroSlider::where('is_active', true)->orderBy('order', 'asc')->get(),
        'services' => \App\Models\Service::orderBy('title')->get(),
        'latestPosts' => \App\Models\Post::with('category')->where('is_published', true)->latest()->take(3)->get(),
    ]);
})->name('home');



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

    // Admin & Perawat CRUD Routes (Vue-based)
    Route::middleware('role:admin,perawat')->prefix('manage')->name('admin.')->group(function () {
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
    });

    // Admin Only CRUD Routes (Vue-based)
    Route::middleware('role:admin')->prefix('manage')->name('admin.')->group(function () {
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

        // Pengaturan Situs (Branding, Footer, Kontak)
        Route::get('/site-setting', [SiteSettingController::class, 'index'])->name('site-setting.index');
        Route::post('/site-setting', [SiteSettingController::class, 'update'])->name('site-setting.update');

        // Manajemen Halaman Statis
        Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
        Route::get('/pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/{page}', [PageController::class, 'update'])->name('pages.update');

        // Manajemen Navbar (Menu)
        Route::resource('menus', MenuController::class)->names([
            'index'   => 'menus.index',
            'create'  => 'menus.create',
            'store'   => 'menus.store',
            'edit'    => 'menus.edit',
            'update'  => 'menus.update',
            'destroy' => 'menus.destroy',
        ]);
    });
});

// Berita Routes (Public UI)
Route::get('/berita', function () {
    return Inertia::render('Markas/Berita', [
        'posts' => \App\Models\Post::with('category')->where('is_published', true)->latest()->paginate(12),
    ]);
})->name('berita.index');

Route::get('/berita/{slug}', function ($slug) {
    $post = \App\Models\Post::with('category')->where('slug', $slug)->first();
    if ($post) {
        return Inertia::render('Markas/PostShow', [
            'post' => $post,
            'relatedPosts' => \App\Models\Post::where('id', '!=', $post->id)->where('is_published', true)->latest()->take(5)->get(),
        ]);
    }
    abort(404);
})->name('berita.show');

// Backward compatible redirect
Route::redirect('/donor/registrasi', '/donor/jadwal-dokter', 301);

// Canonical URL scheme (more consistent with menu names)
Route::get('/profile/struktur-organisasi', function () {
    return Inertia::render('Profil/Struktur/Organisasi', [
        'pageData' => \App\Models\Page::where('slug', 'struktur-organisasi')->first(),
    ]);
});

Route::get('/klinik/struktur', function () {
    return Inertia::render('Profil/Struktur/Klinik', [
        'pageData' => \App\Models\Page::where('slug', 'struktur-klinik')->first(),
    ]);
});

// Backward compatible redirects (old -> canonical)
Route::redirect('/profil/struktur/organisasi', '/profile/struktur-organisasi', 301);
Route::redirect('/profil/struktur/klinik', '/klinik/struktur', 301);
Route::redirect('/profil/struktur/markas', '/markas/struktur', 301);
Route::redirect('/profil/visi-misi', '/profile/visi-misi', 301);
Route::redirect('/profil/7-prinsip', '/profile/7-prinsip', 301);
Route::redirect('/profil/sejarah', '/profile/sejarah', 301);
Route::redirect('/profil/mars-hymne', '/profile/mars-hymne', 301);

// Profile canonical routes
Route::get('/profile/{page}', function ($page) {
    // Reuse existing page slug mapping used in dynamic routes.
    $componentName = str_replace('-', '', ucwords($page, '-'));
    $component = 'Profil/' . $componentName;

    if (!file_exists(resource_path("js/Pages/{$component}.vue"))) {
        abort(404);
    }

    return Inertia::render($component, [
        'pageData' => \App\Models\Page::where('slug', $page)->first(),
    ]);
})->where('page', '[a-zA-Z0-9-]+');

// Dynamic Static Pages for Public UI
Route::get('/{category}/{page?}/{subpage?}', function ($category, $page = null, $subpage = null) {
    if (!in_array($category, ['profil', 'markas', 'donor'])) {
        abort(404);
    }

    $folder = ucfirst($category);
    $componentName = '';
    $pageSlug = '';

    if ($category === 'profil' && $page === 'struktur' && $subpage) {
        $componentName = 'Struktur/' . ucfirst($subpage);
        $pageSlug = 'struktur-' . $subpage;
    } elseif ($category === 'donor' && $page === 'info' && $subpage) {
        $componentName = 'Info/' . ucfirst($subpage);
        $pageSlug = $subpage;
    } elseif ($page) {
        // Special mappings for services to static pages
        $mappings = [
            'layanan-ambulance' => 'Sibats',
            'ambulance' => 'Sibats',
            'ambulans' => 'Sibats',
            'layanan-ambulans' => 'Sibats',
            'pertolongan-pertama' => 'PertolonganPertama',
        ];

        if (isset($mappings[$page])) {
            $componentName = $mappings[$page];
        } else {
            $componentName = str_replace('-', '', ucwords($page, '-'));
        }
        $pageSlug = $page;
    } else {
        abort(404);
    }

    $component = $folder . '/' . $componentName;

    // Special Case: News/Berita Details
    if ($category === 'markas' && $page === 'berita' && $subpage) {
        $post = \App\Models\Post::with('category')->where('slug', $subpage)->first();
        if ($post) {
            return Inertia::render('Markas/PostShow', [
                'post' => $post,
                'relatedPosts' => \App\Models\Post::where('id', '!=', $post->id)->where('is_published', true)->latest()->take(5)->get(),
            ]);
        }
    }

    // Special Case: News/Berita List
    if ($category === 'markas' && $page === 'berita' && !$subpage) {
        return Inertia::render('Markas/Berita', [
            'posts' => \App\Models\Post::with('category')->where('is_published', true)->latest()->paginate(12),
        ]);
    }
    
    // 1. Try to find the specific Vue component
    if (file_exists(resource_path("js/Pages/{$component}.vue"))) {
        $pageData = \App\Models\Page::where('slug', $pageSlug)->first();
        return Inertia::render($component, [
            'pageData' => $pageData
        ]);
    }
    
    // 2. Fallback for Services in Markas category
    if ($category === 'markas' && $page) {
        $service = \App\Models\Service::where('slug', $page)->first();
        if ($service) {
            return Inertia::render('Markas/ServiceShow', [
                'service' => $service
            ]);
        }
    }

    abort(404);
})->where([
    'category' => '(profil|markas|donor)',
    'page' => '[a-zA-Z0-9-]+',
    'subpage' => '[a-zA-Z0-9-]+'
]);
