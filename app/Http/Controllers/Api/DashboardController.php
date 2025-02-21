<?php

namespace App\Http\Controllers\Api;

use App\Enums\AddressType;
use App\Enums\CustomerStatus;
use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\OrderResource;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Category;
use App\Models\Product;
use App\Models\Alergen;
use App\Traits\ReportTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use ReportTrait;
    /**
     * Display a listing of the resource.
     */
    public function activeCustomers()
    {
        return Customer::where('status', CustomerStatus::Active->value)->count();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function activeCategories()
    {
        return Category::all()->count();
    }

    public function popularCategories()
    {
        return Category::query()
            ->select(['categories.id', 'categories.name', 'categories.image'])
            ->withCount('products')
            ->with(['products' => function ($query) {
                $query->select('products.id', 'products.title', 'products.created_at')
                    ->orderByDesc('products.created_at') // Ordenamos por el producto más reciente
                    ->limit(1);
            }])
            ->whereHas('products', function ($query) {
                $query->whereNull('products.deleted_at'); // Filtrar productos no eliminados
            })
            ->where('active', 1)
            ->orderByDesc(function ($query) {
                $query->select('created_at')
                    ->from('products')
                    ->join('product_categories', 'product_categories.product_id', '=', 'products.id')
                    ->whereRaw('product_categories.category_id = categories.id')
                    ->whereNull('products.deleted_at')
                    ->latest()
                    ->limit(1);
            }) // Ordenar categorías por el último producto creado
            ->limit(5)
            ->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function totalProducts()
    {
        return Product::all()->count();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function activeProducts()
    {
        return Product::where('published', '=', 1)->count();
    }

    /**
     * Update the specified resource in storage.
     */
    public function latestProducts()
    {
        return Product::query()
            ->select(['id', 'title', 'created_at'])
            ->with(['images' => function ($query) {
                $query->select('id', 'product_id', 'url')->orderBy('id')->limit(1);
            }])
            ->where('published', 1)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function activeAlergens()
    {
        return Alegen::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function paidOrders()
    {
        $fromDate = $this->getFromDate();
        $query = Order::query()->where('status', OrderStatus::Paid->value);

        if ($fromDate) {
            $query->where('created_at', '>', $fromDate);
        }

        return $query->count();
    }

    /**
     * Display the specified resource.
     */
    public function totalIncome()
    {
        $fromDate = $this->getFromDate();
        $query = Order::query()->where('status', OrderStatus::Paid->value);

        if ($fromDate) {
            $query->where('created_at', '>', $fromDate);
        }
        return round($query->sum('total_price'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function ordersByCountry()
    {
        $fromDate = $this->getFromDate();
        $query = Order::query()
            ->select(['c.name', DB::raw('count(orders.id) as count')])
            ->join('users', 'created_by', '=', 'users.id')
            ->join('customer_addresses AS a', 'users.id', '=', 'a.customer_id')
            ->join('countries AS c', 'a.country_code', '=', 'c.code')
            ->where('status', OrderStatus::Paid->value)
            ->where('a.type', AddressType::Billing->value)
            ->groupBy('c.name')
            ;

        if ($fromDate) {
            $query->where('orders.created_at', '>', $fromDate);
        }

        return $query->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function latestCustomers()
    {
        return Customer::query()
            ->select(['id', 'first_name', 'last_name', 'u.email', 'phone', 'u.created_at'])
            ->join('users AS u', 'u.id', '=', 'customers.user_id')
            ->where('status', CustomerStatus::Active->value)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function latestOrders()
    {
        return OrderResource::collection(
            Order::query()
                ->select(['o.id', 'o.total_price', 'o.created_at', DB::raw('COUNT(oi.id) AS items'),
                    'c.user_id', 'c.first_name', 'c.last_name'])
                ->from('orders AS o')
                ->join('order_items AS oi', 'oi.order_id', '=', 'o.id')
                ->join('customers AS c', 'c.user_id', '=', 'o.created_by')
                ->where('o.status', OrderStatus::Paid->value)
                ->limit(10)
                ->orderBy('o.created_at', 'desc')
                ->groupBy('o.id', 'o.total_price', 'o.created_at', 'c.user_id', 'c.first_name', 'c.last_name')
                ->get()
        );
    }
}
