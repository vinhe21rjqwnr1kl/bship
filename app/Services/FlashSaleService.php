<?php

namespace App\Services;

use App\Models\FlashSale;
use App\Models\Restaurant;
use App\Services\common\LogService;
use App\Services\common\ReloadConfigService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlashSaleService
{
    protected FlashSale $flashSale;
    protected LogService $logService;
    protected ReloadConfigService $reloadConfigService;

    public function __construct(FlashSale $flashSale, ReloadConfigService $reloadConfigService, LogService $logService)
    {
        $this->flashSale = $flashSale;
        $this->logService = $logService;
        $this->reloadConfigService = $reloadConfigService;
    }

    public function listFlashSale(Request $request)
    {
        $query = $this->flashSale::query();

        if ($request->isMethod('GET') && $request->input('todo') == 'Filter') {
            $this->applyFilter($request, $query);
        }
        $flashTypes = array_keys(FlashSale::FLASH_SALE_TYPE);
        $query->whereIn('type', $flashTypes);

        $direction = $request->get('direction', 'desc');
        $sortBy = $request->get('sort', 'id');
        $query->orderBy($sortBy, $direction);

        return $query->paginate(config('Reading.nodes_per_page'));
    }

    public function listGoldenHoursFlashSale(Request $request)
    {
        $query = $this->flashSale::query();

        if ($request->isMethod('GET') && $request->input('todo') == 'Filter') {
            $this->applyFilter($request, $query);
        }
        $query->where('type', 'GoldenHours');

        $direction = $request->get('direction', 'desc');
        $sortBy = $request->get('sort', 'id');
        $query->orderBy($sortBy, $direction);

        return $query->paginate(config('Reading.nodes_per_page'));
    }

    private function applyFilter(Request $request, $query): void
    {
        if ($request->filled('title')) {
            $query->where('title', 'like', "%{$request->input('title')}%");
        }
        if ($request->filled('status')) {
            $query->where('status', "{$request->input('status')}");
        }
    }

    public function storeFlashSale(array $data): bool
    {
        try {
            $this->flashSale::create($data);
            $this->reloadConfigService->reload_config();

            return true;
        } catch (\Exception $e) {
            $this->logService->logError('Error creating flash sale', $e);
            return false;
        }
    }

    public function updateFlashSale($id, array $data): bool
    {
        try {
            DB::beginTransaction();

            if (empty($data['banner'])) {
                unset($data['banner']);
            }

            $flashSale = $this->flashSale::findOrFail($id);
            $flashSale->fill($data)->saveOrFail();

            $this->updateFlashSaleDetails($flashSale, $data['discounts'] ?? []);

            DB::commit();
            $this->reloadConfigService->reload_config();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->logService->logError('Error updating flash sale', $e);
            return false;
        }
    }

    private function updateFlashSaleDetails(FlashSale $flashSale, array $discounts = []): void
    {
        $flashSale->flashSaleDetails()->whereNotIn('discount_id', array_keys($discounts))->delete();

        foreach ($discounts as $discountId => $discountData) {
            $flashSale->flashSaleDetails()->updateOrCreate(
                [
                    'discount_id' => $discountId,
                ],
                [
                    'type' => $discountData['type'],
                    'max_usage' => $discountData['max_usage'],
                    'status' => $discountData['status'] ?? 0
                ]
            );
        }
    }

    public function updateFlashSaleRestaurant($id, array $data): bool
    {
        try {
            DB::beginTransaction();

            if (empty($data['banner'])) {
                unset($data['banner']);
            }

            $flashSale = $this->flashSale::findOrFail($id);
            $flashSale->fill($data)->saveOrFail();

            $this->updateFlashSaleDetailsRestaurant($flashSale, $data['discounts'] ?? []);

            DB::commit();
            $this->reloadConfigService->reload_config();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->logService->logError('Error updating flash sale golden hours', $e);
            return false;
        }
    }

    private function updateFlashSaleDetailsRestaurant(FlashSale $flashSale, array $restaurants = []): void
    {
        $deleted = $flashSale->flashSaleDetails()
            ->whereNotIn('restaurant_id', array_keys($restaurants))
            ->delete();

        $flashSaleId = $flashSale->id;
        foreach ($restaurants as $restaurantId => $restaurantData) {
            $flashSale->flashSaleDetails()->updateOrCreate(
                [
                    'flash_sale_id' => $flashSaleId,
                    'restaurant_id' => $restaurantId
                ],
                [
                    'status' => $restaurantData['status'] ?? 0
                ]
            );
        }
    }

    public function destroyFlashSale($id): bool
    {
        try {
            $flashSale = $this->flashSale::findOrFail($id);
            $flashSale->delete();
            return true;
        } catch (\Exception $e) {
            $this->logService->logError('Error deleting news', $e);
            return false;
        }
    }

    public function prepareData(array $validated): array
    {
        $data = $validated;
        $data['banner'] = $this->handleImageUpload($validated['data']['meta'] ?? []);

        return $data;
    }

    private function handleImageUpload(array $metas): ?string
    {
        $image = null;
        $sortedMetas = collect($metas)->sortKeys()->all();

        foreach ($sortedMetas as $meta) {
            $value = $meta['value'] ?? null;

            if ($value) {
                $fileName = time() . '_' . $value->getClientOriginalName();
                $value->storeAs('public/flash-sale', $fileName);
                $image = config('app.url') . 'storage/flash-sale/' . $fileName;
            }
        }

        return $image;
    }


}
