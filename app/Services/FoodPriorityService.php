<?php

namespace App\Services;

use App\Models\FoodPriority;
use App\Services\common\LogService;
use App\Services\common\ReloadConfigService;
use Illuminate\Http\Request;

class FoodPriorityService
{
    protected FoodPriority $food_priority;
    protected ReloadConfigService $reloadConfigService;
    protected LogService $logService;

    public function __construct(FoodPriority $food_priority,  ReloadConfigService $reloadConfigService, LogService $logService)
    {
        $this->food_priority = $food_priority;
        $this->reloadConfigService = $reloadConfigService;
        $this->logService = $logService;
    }

    public function listFoodPriority(Request $request)
    {
        $query = $this->food_priority::with(['food_product', 'restaurant'])
        ->where('type', 'Ads'); // Eager load quan hệ 'food_product' và 'restaurant'
        
        if ($request->isMethod('get') && $request->input('todo') == 'Filter') {
            $this->applyFilters($query, $request);
        }
        
        $direction = $request->get('direction', 'desc');
        $sortBy = $request->get('sort', 'id');
        
        // Chỉ định rõ bảng khi sắp xếp
        $query->orderBy("t_food_priority.{$sortBy}", $direction);
        
        return $query->paginate(config('Reading.nodes_per_page'));
    }
    
    

   
    private function applyFilters($query, Request $request): void
{
    if ($request->filled('product_name')) {
        $product_name = $request->input('product_name');
        // Thực hiện join với bảng 'users' và 'restaurants' để tìm kiếm theo 'email' và 'name'
        $query->whereHas('food_product', function ($q) use ($product_name) {
            $q->where('name', 'like', "%{$product_name}%");
        });

     
    }
    
    if ($request->filled('restaurant_name')) {
        $restaurant_name = $request->input('restaurant_name');
        
        // Thực hiện join với bảng 'users' và 'restaurants' để tìm kiếm theo 'email' và 'name'
        $query->whereHas('restaurant', function ($q) use ($restaurant_name) {
            $q->where('name', 'like', "%{$restaurant_name}%");
        });
    }

    if ($request->filled('type')) {
        $query->where(function ($q) use ($request) {
            $q->where('t_food_priority.type', 'like', "%{$request->input('type')}%");
                
        });
    }

    
}


    public function storeFoodPriority(array $data): bool
    {
        try {
            $this->food_priority::create($data);
            return true;
        } catch (\Exception $e) {
            $this->logService->logError('Error creating priority', $e);
            return false;
        }
    }

   

    public function deleteFoodPriority($id): bool
    {
        try {
            $food_priority = $this->food_priority::findOrFail($id);
            $food_priority->delete();
            return true;
        } catch (\Exception $e) {
            $this->logService->logError('Error deleting food priority', $e);
            return false;
        }
    }

    public function prepareData(array $validated): array
    {
        return [
            'product_id' => $validated['product_id'],
            'restaurant_id' => $validated['restaurant_id'],
            'type' => 'Ads',
        ];
    }
}