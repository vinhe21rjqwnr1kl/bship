<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Http\Requests\TouristDestinationRequest;
use App\Models\TNews;
use App\Models\TouristDestinations;
use App\Services\NewsService;
use App\Services\TouristDestinationsService;
use Illuminate\Http\Request;

class TouristDestinationsController extends Controller
{
    protected TouristDestinations $model;
    protected TouristDestinationsService $service;

    public function __construct(TouristDestinations $model, TouristDestinationsService $service)
    {
        $this->model = $model;
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $page_title = __('Danh sách điểm du lịch');
        $listData = $this->service->list($request);

        return view('admin.tourist_destinations.index', compact('listData', 'page_title'));
    }

    public function create()
    {
        $page_title = __('Thêm điểm du lịch');
        return view('admin.tourist_destinations.create', compact('page_title'));
    }

    public function store(TouristDestinationRequest $request)
    {
        $data = $this->service->prepareData($request->validated());
        $is_successful = $this->service->store($data);

        return $is_successful
            ? redirect()->route('admin.tourist_destinations.index')->with('success', __('Thêm điểm du lịch thành công.'))
            : redirect()->route('admin.tourist_destinations.index')->with('error', __('Có lỗi xảy ra khi tạo điểm du lịch.'));
    }

    public function edit($id)
    {
        $page_title = 'Cập nhật điểm du lịch';
        $model = $this->model::findOrFail($id);

        return view('admin.tourist_destinations.edit', compact('model', 'page_title'));
    }

    public function update(TouristDestinationRequest $request, $id)
    {
        $data = $this->service->prepareData($request->validated());
        $is_successful = $this->service->update($id, $data);

        return $is_successful
            ? redirect()->route('admin.tourist_destinations.index')->with('success', __('Cập nhật thành công'))
            : redirect()->route('admin.tourist_destinations.index')->with('error', __('Có lỗi xảy ra khi cập nhật.'));
    }

    public function destroy($id)
    {
        $is_successful = $this->service->delete($id);

        return $is_successful
            ? redirect()->back()->with('success', __('Xoá thành công'))
            : redirect()->back()->with('error', __('Hệ thống đang bận và quá tải.'));
    }
}
