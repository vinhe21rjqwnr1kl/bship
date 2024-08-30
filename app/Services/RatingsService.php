<?php

namespace App\Services;

use App\Models\TRatings;
use App\Services\common\LogService;
use App\Services\common\ReloadConfigService;
use Illuminate\Http\Request;

class RatingsService
{
    protected TRatings $ratings;
    protected ReloadConfigService $reloadConfigService;
    protected LogService $logService;

    public function __construct(TRatings $ratings, ReloadConfigService $reloadConfigService, LogService $logService)
    {
        $this->ratings = $ratings;
        $this->reloadConfigService = $reloadConfigService;
        $this->logService = $logService;
    }

    public function listRatings(Request $request)
    {
        $query = $this->ratings::with(['user', 'restaurant']); // Eager load quan hệ 'user' và 'restaurant'
    
        if ($request->isMethod('get') && $request->input('todo') == 'Filter') {
            $this->applyFilters($query, $request);
        }
    
        $direction = $request->get('direction', 'desc');
        $sortBy = $request->get('sort', 'id');
    
        // Chỉ định rõ bảng khi sắp xếp
        $query->orderBy("ratings.{$sortBy}", $direction);
    
        return $query->paginate(config('Reading.nodes_per_page'));
    }
    

   
    private function applyFilters($query, Request $request): void
{
    if ($request->filled('keyword')) {
        $keyword = $request->input('keyword');
        // Thực hiện join với bảng 'users' và 'restaurants' để tìm kiếm theo 'email' và 'name'
        $query->join('users', 'ratings.user_id', '=', 'users.id')
              ->where(function ($q) use ($keyword) {
                  $q->where('users.email', 'like', "%{$keyword}%");
              });
    }
    
    if ($request->filled('name')) {
        $name = $request->input('name');
        
        // Thực hiện join với bảng 'users' và 'restaurants' để tìm kiếm theo 'email' và 'name'
        $query->join('restaurants', 'ratings.restaurant_id', '=', 'restaurants.id')
              ->where(function ($q) use ($name) {
                  $q->Where('restaurants.name', 'like', "%{$name}%");
              });
    }

    if ($request->filled('comment')) {
        $query->where(function ($q) use ($request) {
            $q->where('comment', 'like', "%{$request->input('comment')}%");
                
        });
    }

    if ($request->filled('status')) {
        // Chỉ định rõ ràng bảng chứa cột 'status'
        $query->where('ratings.status', $request->input('status'));
    }
}


    public function storeratings(array $data): bool
    {
        try {
            $this->ratings::create($data);
            $this->reloadConfigService->reload_config();
            return true;
        } catch (\Exception $e) {
            $this->logService->logError('Error creating ratings', $e);
            return false;
        }
    }

   

    public function deleteRatings($id): bool
    {
        try {
            $ratings = $this->ratings::findOrFail($id);
            $ratings->delete();
            $this->reloadConfigService->reload_config();
            return true;
        } catch (\Exception $e) {
            $this->logService->logError('Error deleting ratings', $e);
            return false;
        }
    }

    public function prepareData(array $validated): array
    {
        return [
            'user_id' => $validated['user_id'],
            'restaurant_id' => $validated['restaurant_id'],
            'stars' => $validated['stars'],
            'created_at' => $validated['created_at'],
            'updated_at' => $validated['updated_at'],
            'comment' => $validated['comment'],
            'status' => $validated['status'],            
            'images' => $this->handleImagesUpload($validated['data']['meta'] ?? [])
        ];
    }

    private function handleImagesUpload(array $metas): ?string
    {
        $images = null;
        $sortedMetas = collect($metas)->sortKeys()->all();

        foreach ($sortedMetas as $meta) {
            $value = $meta['value'] ?? null;

            if ($value) {
                $fileName = time() . '_' . $value->getClientOriginalName();
                $value->storeAs('public/ratings', $fileName);
                $images = config('app.url') . 'storage/ratings/' . $fileName;
            }
        }

        return $images;
    }
}