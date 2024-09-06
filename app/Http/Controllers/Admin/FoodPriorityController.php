<?php

namespace App\Http\Controllers\Admin;

use App\Models\Restaurant;
use App\Models\FoodProduct;
use App\Models\FoodPriority;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\FoodPriorityService;

class FoodPriorityController extends Controller
{
    protected FoodPriority $food_priority;
    protected FoodPriorityService $food_priorityService;

    public function __construct(FoodPriority $food_priority, FoodPriorityService $food_priorityService)
    {
        $this->food_priority = $food_priority;
        $this->food_priorityService = $food_priorityService;
    }
    // Trong FoodPriorityController.php

// Trong FoodPriorityController.php

public function search(Request $request)
{
    $query = $request->input('search');
    $restaurantId = $request->input('restaurant_id');
    
    $productId = $request->input('product_id');

    if ($request->routeIs('restaurants.search')) {
        if ($productId) {
            // Nếu có product_id thì tìm các nhà hàng có sản phẩm đó
            $restaurants = Restaurant::whereHas('food_product', function($q) use ($productId) {
                $q->where('id', $productId);
            })->limit(10)->get();
            return view('admin.partials.restaurant_table', compact('restaurants'))->render();
        }

        // Tìm nhà hàng theo tên
        $restaurants = Restaurant::where('name', 'like', "%{$query}%")->limit(10)->get();
        return view('admin.partials.restaurant_table', compact('restaurants'))->render();
    }

    if ($request->routeIs('products.search')) {
        if ($restaurantId) {
            // Nếu có restaurant_id thì tìm các sản phẩm của nhà hàng đó
            $products = FoodProduct::where('restaurant_id', $restaurantId)->limit(10)->get();
            return view('admin.partials.product_table', compact('products'))->render();
        }

        // Tìm sản phẩm theo tên
        $products = FoodProduct::where('name', 'like', "%{$query}%")->limit(10)->get();
        return view('admin.partials.product_table', compact('products'))->render();
    }
}

// Trong FoodPriorityController.php



    public function index(Request $request)
    {
        $page_title = __('Cửa hàng ưu tiên');
        $food_priority = $this->food_priorityService->listFoodPriority($request);

        return view('admin.food_priority.index', compact('food_priority', 'page_title'));
    }


    public function create()
    {
        $page_title = __('Tạo ưu tiên');
        return view('admin.food_priority.create', compact('page_title'));
    }
    public function store(Request $request)
    {
        $data = $this->food_priorityService->prepareData($request->all());
        $is_successful = $this->food_priorityService->storeFoodPriority($data);

        return $is_successful
            ? redirect()->route('admin.food_priority.index')->with('success', __('Tạo ưu tiên thành công.'))
            : redirect()->route('admin.food_priority.index')->with('error', __('Có lỗi xảy ra khi tạo ưu tiên.'));
    }

    public function destroy($id)
    {
        $is_successful = $this->food_priorityService->deleteFoodPriority($id);

        return $is_successful
            ? redirect()->back()->with('success', __('Xoá thành công'))
            : redirect()->back()->with('error', __('Hệ thống đang bận và quá tải.'));
    }
}