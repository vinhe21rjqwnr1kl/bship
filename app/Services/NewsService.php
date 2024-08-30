<?php

namespace App\Services;

use App\Models\TNews;
use App\Services\common\LogService;
use App\Services\common\ReloadConfigService;
use Illuminate\Http\Request;

class NewsService
{
    protected TNews $news;
    protected ReloadConfigService $reloadConfigService;
    protected LogService $logService;

    public function __construct(TNews $news, ReloadConfigService $reloadConfigService, LogService $logService)
    {
        $this->news = $news;
        $this->reloadConfigService = $reloadConfigService;
        $this->logService = $logService;
    }

    public function listNews(Request $request)
    {
        $query = $this->news::query();

        if ($request->isMethod('get') && $request->input('todo') == 'Filter') {
            $this->applyFilters($query, $request);
        }

        $direction = $request->get('direction', 'desc');
        $sortBy = $request->get('sort', 'id');
        $query->orderBy($sortBy, $direction);

        return $query->paginate(config('Reading.nodes_per_page'));
    }
   
    private function applyFilters($query, Request $request): void
    {
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('news_url', 'like', "%{$request->input('keyword')}%")
                    ->orWhere('title', 'like', "%{$request->input('keyword')}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
    }

    public function storeNews(array $data): bool
    {
        try {
            $this->news::create($data);
            $this->reloadConfigService->reload_config();
            return true;
        } catch (\Exception $e) {
            $this->logService->logError('Error creating news', $e);
            return false;
        }
    }

    public function updateNews($id, array $data): bool
    {
        try {
            $news = $this->news::findOrFail($id);

            if (empty($data['image'])) {
                unset($data['image']);
            }

            $news->fill($data)->saveOrFail();
            $this->reloadConfigService->reload_config();

            return true;
        } catch (\Exception $e) {
            $this->logService->logError('Error updating news', $e);
            return false;
        }
    }

    public function deleteNews($id): bool
    {
        try {
            $news = $this->news::findOrFail($id);
            $news->delete();
            $this->reloadConfigService->reload_config();
            return true;
        } catch (\Exception $e) {
            $this->logService->logError('Error deleting news', $e);
            return false;
        }
    }

    public function prepareData(array $validated): array
    {
        return [
            'title' => $validated['title'],
            'status' => $validated['status'],
            'find_index' => $validated['find_index'],
            'news_url' => $validated['news_url'],
            'image' => $this->handleImageUpload($validated['data']['meta'] ?? [])
        ];
    }

    private function handleImageUpload(array $metas): ?string
    {
        $image = null;
        $sortedMetas = collect($metas)->sortKeys()->all();

        foreach ($sortedMetas as $meta) {
            $value = $meta['value'] ?? null;

            if ($value) {
                $fileName = time() . '_' . $value->getClientOriginalName();
                $value->storeAs('public/news', $fileName);
                $image = config('app.url') . 'storage/news/' . $fileName;
            }
        }

        return $image;
    }
}