<?php

namespace App\Services;

use App\Models\TNews;
use App\Models\TouristDestinations;
use App\Services\common\LogService;
use App\Services\common\ReloadConfigService;
use Illuminate\Http\Request;

class TouristDestinationsService
{
    protected TouristDestinations $model;
    protected ReloadConfigService $reloadConfigService;
    protected LogService $logService;

    public function __construct(TouristDestinations $model, ReloadConfigService $reloadConfigService, LogService $logService)
    {
        $this->model = $model;
        $this->reloadConfigService = $reloadConfigService;
        $this->logService = $logService;
    }

    public function list(Request $request)
    {
        $query = $this->model::query();

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
                $q->where('title', 'like', "%{$request->input('keyword')}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
    }

    public function store(array $data): bool
    {
        try {
            $this->model::create($data);
            $this->reloadConfigService->reload_config();
            return true;
        } catch (\Exception $e) {
            $this->logService->logError('Error creating tourist destination', $e);
            return false;
        }
    }

    public function update($id, array $data): bool
    {
        try {
            $model = $this->model::findOrFail($id);

            if (empty($data['url'])) {
                unset($data['url']);
            }

            $model->fill($data)->saveOrFail();
            $this->reloadConfigService->reload_config();

            return true;
        } catch (\Exception $e) {
            $this->logService->logError('Error updating news', $e);
            return false;
        }
    }

    public function delete($id): bool
    {
        try {
            $model = $this->model::findOrFail($id);
            $model->delete();
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
            'index' => $validated['index'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'limit_radius' => $validated['limit_radius'],
            'url' => $this->handleImageUpload($validated['data']['meta'] ?? [])
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
                $value->storeAs('public/tourist-destinations', $fileName);
                $image = config('app.url') . 'storage/tourist-destinations/' . $fileName;
            }
        }

        return $image;
    }
}
