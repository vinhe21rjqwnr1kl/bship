<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Models\TNews;
use App\Services\NewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    protected TNews $news;
    protected NewsService $newsService;

    public function __construct(TNews $news, NewsService $newsService)
    {
        $this->news = $news;
        $this->newsService = $newsService;
    }

    public function index(Request $request)
    {
        $page_title = __('Danh sách tin tức');
        $news = $this->newsService->listNews($request);

        return view('admin.news.index', compact('news', 'page_title'));
    }

    public function create()
    {
        $page_title = __('Tạo tin tức');
        return view('admin.news.create', compact('page_title'));
    }

    public function store(NewsRequest $request)
    {
        $data = $this->newsService->prepareData($request->validated());
        $is_successful = $this->newsService->storeNews($data);

        return $is_successful
            ? redirect()->route('admin.news.index')->with('success', __('Tạo tin tức thành công.'))
            : redirect()->route('admin.news.index')->with('error', __('Có lỗi xảy ra khi tạo tin tức.'));
    }

    public function edit($id)
    {
        $page_title = 'Cập nhật tin tức';
        $news = $this->news::findOrFail($id);

        return view('admin.news.edit', compact('news', 'page_title'));
    }

    public function update(NewsRequest $request, $id)
    {
        $data = $this->newsService->prepareData($request->validated());
        $is_successful = $this->newsService->updateNews($id, $data);

        return $is_successful
            ? redirect()->route('admin.news.index')->with('success', __('Cập nhật thành công'))
            : redirect()->route('admin.news.index')->with('error', __('Có lỗi xảy ra khi cập nhật tin tức.'));
    }

    public function destroy($id)
    {
        $is_successful = $this->newsService->deleteNews($id);

        return $is_successful
            ? redirect()->back()->with('success', __('Xoá thành công'))
            : redirect()->back()->with('error', __('Hệ thống đang bận và quá tải.'));
    }
}
