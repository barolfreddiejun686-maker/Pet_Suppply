<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('dashboard', [
            'productCount'  => Product::count(),
            'categoryCount' => Category::count(),
            'brandCount'    => Brand::count(),
            'supplierCount' => Supplier::count(),
            'stockValue'    => Product::sum(DB::raw('stock * cost_price')),
            'lowStock'      => Product::lowStock()->with('category')->orderBy('stock')->limit(8)->get(),
            'expiring'      => Product::whereNotNull('expiry_date')
                                ->whereBetween('expiry_date', [now()->toDateString(), now()->addDays(30)->toDateString()])
                                ->orderBy('expiry_date')->limit(8)->get(),
            'recent'        => Transaction::withCount('items')->latest('transacted_at')->limit(8)->get(),
        ]);
    }
}
