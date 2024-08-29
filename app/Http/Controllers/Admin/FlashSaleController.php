<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FlashSaleRequest;
use App\Http\Resources\DiscountResource;
use App\Http\Resources\FlashSaleResource;
use App\Models\FlashSale;
use App\Models\FlashSaleDetail;
use App\Models\FlashSaleType;
use App\Models\Restaurant;
use App\Models\Voucher;
use App\Services\FlashSaleService;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    protected FlashSale $flashSale;
    protected FlashSaleDetail $flashSaleDetail;
    protected FlashSaleService $flashSaleService;

    public function __construct(FlashSale $flashSale, FlashSaleDetail $flashSaleDetail, FlashSaleService $flashSaleService)
    {
        $this->flashSale = $flashSale;
        $this->flashSaleDetail = $flashSaleDetail;
        $this->flashSaleService = $flashSaleService;
    }

    public function index(Request $request)
    {
        $page_title = 'Danh sách nhóm Flash Sale';
        $falseSale = $this->flashSaleService->listFlashSale($request);

        return view('admin.flash_sale.index', compact('page_title', 'falseSale'));
    }

    public function create()
    {
        $page_title = 'Tạo nhóm Flash Sale';
        $flashTypes = FlashSale::FLASH_SALE_TYPE;
        return view('admin.flash_sale.create', compact('flashTypes', 'page_title'));
    }

    public function store(FlashSaleRequest $request)
    {
        $data = $this->flashSaleService->prepareData($request->validated());
        $data['create_date'] = now();
        $isSuccessful = $this->flashSaleService->storeFlashSale($data);

        return $isSuccessful
            ? redirect()->route('admin.flash_sale.index')->with('success', __('Tạo thành công.'))
            : redirect()->route('admin.flash_sale.index')->with('error', __('Có lỗi xảy ra.'));
    }

    public function edit($id)
    {
        $flashSale = $this->flashSale::with('flashSaleDetails.discount')->findOrFail($id);
        $flashTypes = FlashSale::FLASH_SALE_TYPE;
        $allDiscounts = Voucher::query()->where('status', 1)
            ->orderBy('create_date', 'desc')
            ->get();

        return view('admin.flash_sale.edit', [
            'flashSale' => new FlashSaleResource($flashSale),
            'flashTypes' => $flashTypes,
            'allDiscounts' => DiscountResource::collection($allDiscounts),
            'page_title' => 'Cập nhật nhóm flash sale'
        ]);
    }

    public function update(FlashSaleRequest $request, $id)
    {
        $data = $this->flashSaleService->prepareData($request->validated());
        $isSuccessful = $this->flashSaleService->updateFlashSale($id, $data);

        return $isSuccessful
            ? redirect()->back()->with('success', __('Cập nhật thành công'))
            : redirect()->back()->with('error', __('Có lỗi xảy ra khi cập nhật flash sale.'));
    }

    public function destroy($id)
    {
        $isSuccessful = $this->flashSaleService->destroyFlashSale($id);

        return $isSuccessful
            ? redirect()->back()->with('success', __('Xoá thành công'))
            : redirect()->back()->with('error', __('Hệ thống đang bận và quá tải.'));
    }

    public function indexGoldenHours(Request $request)
    {
        $page_title = 'khung giờ vàng';
        $items = $this->flashSaleService->listGoldenHoursFlashSale($request);

        return view('admin.flash_sale.golden_hours.index', compact('page_title', 'items'));
    }

    public function createGoldenHours()
    {
        $page_title = 'Tạo nhóm Flash Sale';
        return view('admin.flash_sale.golden_hours.create', compact('page_title'));
    }

    public function storeGoldenHours(FlashSaleRequest $request)
    {
        $data = $this->flashSaleService->prepareData($request->validated());
        $data['create_date'] = now();
        $data['type'] = FlashSaleType::GoldenHours->name;

        $isSuccessful = $this->flashSaleService->storeFlashSale($data);

        return $isSuccessful
            ? redirect()->route('admin.flash_sale.golden-hours')->with('success', __('Tạo thành công.'))
            : redirect()->route('admin.flash_sale.golden-hours')->with('error', __('Có lỗi xảy ra.'));
    }

    public function editGoldenHours($id)
    {
        $data = $this->flashSale::with('flashSaleDetails.restaurant')->findOrFail($id);
        return view('admin.flash_sale.golden_hours.edit', [
            'data' => new FlashSaleResource($data),
            'page_title' => 'Cập nhật nhóm flash sale'
        ]);
    }

    public function updateGoldenHours(FlashSaleRequest $request, $id)
    {
//        dd($request);
        $data = $this->flashSaleService->prepareData($request->validated());
        $isSuccessful = $this->flashSaleService->updateFlashSaleRestaurant($id, $data);

        return $isSuccessful
            ? redirect()->back()->with('success', __('Cập nhật thành công'))
            : redirect()->back()->with('error', __('Có lỗi xảy ra khi cập nhật flash sale.'));
    }

    public function restaurantList(Request $request)
    {
        $query = Restaurant::query();

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $query->where('status', 1)
        ->orderBy('id','desc');

        $restaurants = $query->paginate(10);

        if ($request->ajax()) {
            return view('admin.flash_sale.golden_hours.partials.restaurant_list', compact('restaurants'))->render();
        }

        return view('admin.flash_sale.golden_hours.partials.restaurant_list', compact('restaurants'));
    }

}
