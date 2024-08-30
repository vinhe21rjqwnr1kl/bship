<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RatingsRequest;
use App\Models\TRatings;
use App\Services\RatingsService;

class RatingsController extends Controller
{
    protected TRatings $ratings;
    protected RatingsService $ratingsService;

    public function __construct(TRatings $ratings, RatingsService $ratingsService)
    {
        $this->ratings = $ratings;
        $this->ratingsService = $ratingsService;
    }

    public function index(Request $request)
    {
        $page_title = __('Danh sách đánh giá chuyến đi');
        $ratings = $this->ratingsService->listRatings($request);

        return view('admin.ratings.index', compact('ratings', 'page_title'));
    }


    public function destroy($id)
    {
        $is_successful = $this->ratingsService->deleteRatings($id);

        return $is_successful
            ? redirect()->back()->with('success', __('Xoá thành công'))
            : redirect()->back()->with('error', __('Hệ thống đang bận và quá tải.'));
    }
    public function updateStatus(Request $request)
    {
        $rating = TRatings::find($request->id);

        if ($rating) {
            // Thay đổi status
            $rating->status = $rating->status == 1 ? 0 : 1;
            $rating->save();

            return response()->json(['status' => $rating->status]);
        }

        return response()->json(['error' => 'Rating not found'], 404);
    }

  

    

}