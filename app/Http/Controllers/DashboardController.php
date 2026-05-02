<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BloodStock;
use App\Models\Post;
use App\Models\BloodDonor;
use App\Models\Category;
use App\Models\Service;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Auth\Access\AuthorizationException;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function admin(): Response
    {
        if (!auth()->user()->isAdmin()) {
            throw new AuthorizationException('Anda bukan admin');
        }

        $bloodStockTotal = BloodStock::all()->sum(function($stock) {
            return $stock->stock_a + $stock->stock_b + $stock->stock_o + $stock->stock_ab;
        });

        return Inertia::render('Dashboards/AdminDashboard', [
            'userCount' => User::count(),
            'perawatCount' => User::where('role', 'perawat')->count(),
            'bloodStockTotal' => $bloodStockTotal,
            'postCount' => Post::count(),
        ]);
    }

    /**
     * Show perawat dashboard
     */
    public function perawat(): Response
    {
        if (!auth()->user()->isPerawat()) {
            throw new AuthorizationException('Anda bukan perawat');
        }

        $bloodStockTotal = BloodStock::all()->sum(function($stock) {
            return $stock->stock_a + $stock->stock_b + $stock->stock_o + $stock->stock_ab;
        });

        return Inertia::render('Dashboards/PerawatDashboard', [
            'bloodDonorCount' => BloodDonor::count(),
            'bloodStockTotal' => $bloodStockTotal,
            'categoryCount' => Category::count(),
            'serviceCount' => Service::count(),
        ]);
    }
}
