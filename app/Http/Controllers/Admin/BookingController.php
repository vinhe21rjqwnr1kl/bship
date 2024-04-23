<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TBookingOrders;
use App\Models\TBookingComments;
use App\Models\TBookingCommentTag;
use App\Models\TBookingSupplierServices;
use App\Models\TBookingSuppliers;
use App\Models\TBookingSupplierImages;
use App\Models\CfServiceMain;
use App\Models\CfServiceType;
use App\Models\Agency;

use App\Rules\EditorEmptyCheckRule;
use Storage;



class BookingController extends Controller

{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_order(Request $request)
    {
        $page_title             = __('Danh sách đặt lịch');
        $resultQuery            = TBookingOrders::query();
        if($request->isMethod('get') && $request->input('todo') == 'Filter')
        {
            if($request->filled('phone')) {
                $resultQuery->where('user_data.phone', 'like', "%{$request->input('phone')}%");
            }
            if($request->filled('name')) {
                $resultQuery->where('user_data.name', 'like', "%{$request->input('name')}%");
            }
            if($request->filled('datefrom')) {
                $resultQuery->where('t_booking_orders.create_date', '>=', "{$request->input('datefrom')}");
            }
            if($request->filled('dateto')) {
                $resultQuery->where('t_booking_orders.create_date', '<', "{$request->input('dateto')}");
            }
        }


        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'create_date';
        $resultQuery->orderBy('t_booking_orders.'.$sortBy, $direction);
        $sortWith = $request->get('with') ? $request->get('with') : Null;


        $resultQuery->join('user_data', 'user_data.id', '=', 't_booking_orders.user_data_id');
        $resultQuery->join('cf_service_main', 'cf_service_main.id', '=', 't_booking_orders.service_id');
        $resultQuery->join('t_booking_suppliers', 't_booking_suppliers.id', '=', 't_booking_orders.booking_supplier_id');

        $resultQuery->select('t_booking_orders.*', 't_booking_suppliers.name as s_name',
        'user_data.name as user_name09','user_data.phone as user_phone09');

        //check tai xe thuoc dai ly
        $current_user 	= auth()->user();
        $driveData["agency_id"]   = $current_user->agency_id;

        if($driveData["agency_id"] > 0)
        {
            $resultQuery->where('agency_id', '=', $driveData["agency_id"] );
        }

        $drivers = $resultQuery->paginate(config('Reading.nodes_per_page'));
        $ServicesArr        = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr    = CfServiceType::pluck('name', 'id')->toArray();

        if($request->input('excel')=="Excel")
        {
            $response = Excel::download(new ExportTrip($request), 'chuyendi.xlsx', \Maatwebsite\Excel\Excel::XLSX);
            ob_end_clean();
            return $response;
        }
       // $status = config('blog.status');
       // $roleArr = Agency::pluck('name', 'id')->toArray();
       // $roleArr[0]= "Công ty BUTL";
        return view('admin.booking.order', compact('drivers','ServicesArr','ServicesTypeArr','page_title'));

    }




    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function admin_edit($id)
    {
        $page_title = __('Thông tin đặt chổ');
        $driver = TBookingOrders::findorFail($id);
        return view('admin.booking.orderedit', compact( 'driver','page_title'));
    }



    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function admin_update(Request $request, $id)
    {
        $bookingData["request_time"]    = $request->input('request_time');
        $bookingData["status_order"]            = $request->input('status_order');

        $validation = [
            'request_time'           => 'required',

        ];
        $validationMsg = [
            'request_time.required'      => __('Thời gian không để trống.'),

        ];
        $this->validate($request, $validation, $validationMsg);
        $booking               = TBookingOrders::findorFail($id);
        $booking->fill($bookingData)->save();
        return redirect()->route('booking.admin.order')->with('success', __('Cập nhật thông tin thành công.'));

    }


 /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_comment(Request $request)
    {
        $page_title             = __('Danh sách bình luận');
        $resultQuery            = TBookingComments::query();
        if($request->isMethod('get') && $request->input('todo') == 'Filter')
        {
            if($request->filled('phone')) {
                $resultQuery->where('user_data.phone', 'like', "%{$request->input('phone')}%");
            }
            if($request->filled('name')) {
                $resultQuery->where('user_data.name', 'like', "%{$request->input('name')}%");
            }
            if($request->filled('datefrom')) {
                $resultQuery->where('t_booking_comments.create_date', '>=', "{$request->input('datefrom')}");
            }
            if($request->filled('dateto')) {
                $resultQuery->where('t_booking_comments.create_date', '<', "{$request->input('dateto')}");
            }
        }


        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'create_date';
        $resultQuery->orderBy('t_booking_comments.'.$sortBy, $direction);
        $sortWith = $request->get('with') ? $request->get('with') : Null;
        $resultQuery->join('user_data', 'user_data.id', '=', 't_booking_comments.user_data_id');

        $resultQuery->join('t_booking_suppliers', 't_booking_suppliers.id', '=', 't_booking_comments.booking_supplier_id');
        $resultQuery->select('t_booking_comments.*', 't_booking_suppliers.name as s_name',
        'user_data.name as user_name09','user_data.phone as user_phone09');

        //check tai xe thuoc dai ly
        $current_user 	= auth()->user();
        $driveData["agency_id"]   = $current_user->agency_id;

        if($driveData["agency_id"] > 0)
        {
            $resultQuery->where('agency_id', '=', $driveData["agency_id"] );
        }

        $drivers = $resultQuery->paginate(config('Reading.nodes_per_page'));


       // $status = config('blog.status');
       // $roleArr = Agency::pluck('name', 'id')->toArray();
       // $roleArr[0]= "Công ty BUTL";
       $comment_tag        = TBookingCommentTag::pluck('description', 'comment_tag')->toArray();

        return view('admin.booking.comment', compact('drivers','comment_tag','page_title'));

    }



    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function admin_commentedit($id)
    {
        $page_title = __('Thông tin bình luận');
        $driver = TBookingComments::findorFail($id);
        $comment_tag        = TBookingCommentTag::pluck('description', 'comment_tag')->toArray();

        return view('admin.booking.commentedit', compact( 'driver','comment_tag','page_title'));
    }



    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function admin_commentupdate(Request $request, $id)
    {
        $bookingData["title"]               = $request->input('title');
        $bookingData["content"]             = $request->input('content');
        $bookingData["comment_tag"]         = $request->input('comment_tag');
        $bookingData["status"]              = $request->input('status');

        $validation = [
            'title'           => 'required',
            'content'           => 'required',

        ];
        $validationMsg = [
            'title.required'      => __('Tiêu đề không để trống.'),
            'content.required'      => __('Nội dung không để trống.'),

        ];
        $this->validate($request, $validation, $validationMsg);
        $booking               = TBookingComments::findorFail($id);
        $booking->fill($bookingData)->save();
        return redirect()->route('booking.admin.comment')->with('success', __('Cập nhật thông tin thành công.'));

    }



 /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_service(Request $request)
    {
        $page_title             = __('Danh sách dịch vụ');
        $resultQuery            = TBookingSupplierServices::query();
        if($request->isMethod('get') && $request->input('todo') == 'Filter')
        {

            if($request->filled('name')) {
                $resultQuery->where('t_booking_supplier_services.name', 'like', "%{$request->input('name')}%");
            }
            if($request->filled('datefrom')) {
                $resultQuery->where('t_booking_supplier_services.create_date', '>=', "{$request->input('datefrom')}");
            }
            if($request->filled('dateto')) {
                $resultQuery->where('t_booking_supplier_services.create_date', '<', "{$request->input('dateto')}");
            }
        }


        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'create_date';
        $resultQuery->orderBy('t_booking_supplier_services.'.$sortBy, $direction);
        $sortWith = $request->get('with') ? $request->get('with') : Null;
       // $resultQuery->join('user_data', 'user_data.id', '=', 't_booking_comments.user_data_id');

        $resultQuery->join('t_booking_suppliers', 't_booking_suppliers.id', '=', 't_booking_supplier_services.booking_supplier_id');
        $resultQuery->select('t_booking_supplier_services.*', 't_booking_suppliers.name as s_name');

        //check tai xe thuoc dai ly
        $current_user 	= auth()->user();
        $driveData["agency_id"]   = $current_user->agency_id;

        if($driveData["agency_id"] > 0)
        {
            $resultQuery->where('agency_id', '=', $driveData["agency_id"] );
        }

        $drivers = $resultQuery->paginate(config('Reading.nodes_per_page'));

        return view('admin.booking.service', compact('drivers','page_title'));

    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function admin_serviceedit($id)
    {
        $page_title = __('Thông tin dịch vụ');
        $driver = TBookingSupplierServices::findorFail($id);

        return view('admin.booking.serviceedit', compact( 'driver','page_title'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function admin_serviceupdate(Request $request, $id)
    {
        $bookingData["name"]                = $request->input('name');
        $bookingData["description"]         = $request->input('description');
        $bookingData["cost"]                = $request->input('cost');
        $bookingData["org_cost"]            = $request->input('org_cost');
        $bookingData["status"]              = $request->input('status');

        $validation = [
            'name'           => 'required',
            'cost'           => 'required',

        ];
        $validationMsg = [
            'name.required'      => __('Tiêu đề không để trống.'),
            'cost.required'      => __('Nội dung không để trống.'),

        ];
        $this->validate($request, $validation, $validationMsg);
        $booking               = TBookingSupplierServices::findorFail($id);
        $booking->fill($bookingData)->save();
        return redirect()->route('booking.admin.service')->with('success', __('Cập nhật thông tin thành công.'));

    }
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function admin_servicecreate()
    {
        $page_title = __('Tạo dịch vụ');
        return view('admin.booking.servicecreate', compact( 'page_title'));
    }



    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function admin_servicestore(Request $request)
    {
        $bookingData["name"]                = $request->input('name');
        $bookingData["description"]         = $request->input('description');
        $bookingData["cost"]                = $request->input('cost');
        $bookingData["org_cost"]            = $request->input('org_cost');
        $bookingData["status"]              = $request->input('status');

        $booking_supplier_id  =0;
        //check tai xe thuoc dai ly
        $current_user 	= auth()->user();
        $driveData["agency_id"]   = $current_user->agency_id;
        if($driveData["agency_id"] > 0)
        {
            $check_phone = TBookingSuppliers::firstWhere('agency_id', $driveData["agency_id"]);
            $booking_supplier_id =  $check_phone["id"];
        }

        if($booking_supplier_id < 1)
        {
            $booking_supplier_id =   1;
        }

        $bookingData["booking_supplier_id"]  =   $booking_supplier_id;

        $validation = [
            'name'           => 'required',
            'cost'           => 'required',

        ];
        $validationMsg = [
            'name.required'      => __('Tiêu đề không để trống.'),
            'cost.required'      => __('Nội dung không để trống.'),
        ];
        $this->validate($request, $validation, $validationMsg);
        $user = TBookingSupplierServices::create($bookingData);
        if($user)
        {
            return redirect()->route('booking.admin.service')->with('success', __('Thêm thông tin thành công.'));

        } else
        {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }

    }

     /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_image(Request $request)
    {
        $page_title             = __('Danh sách hình ảnh');
        $resultQuery            = TBookingSupplierImages::query();
        if($request->isMethod('get') && $request->input('todo') == 'Filter')
        {

            if($request->filled('name')) {
                $resultQuery->where('t_booking_supplier_images.name', 'like', "%{$request->input('name')}%");
            }
            if($request->filled('datefrom')) {
                $resultQuery->where('t_booking_supplier_images.create_date', '>=', "{$request->input('datefrom')}");
            }
            if($request->filled('dateto')) {
                $resultQuery->where('t_booking_supplier_images.create_date', '<', "{$request->input('dateto')}");
            }
        }


        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'create_date';
        $resultQuery->orderBy('t_booking_supplier_images.'.$sortBy, $direction);
        $sortWith = $request->get('with') ? $request->get('with') : Null;
       // $resultQuery->join('user_data', 'user_data.id', '=', 't_booking_comments.user_data_id');

        $resultQuery->join('t_booking_suppliers', 't_booking_suppliers.id', '=', 't_booking_supplier_images.booking_supplier_id');
        $resultQuery->select('t_booking_supplier_images.*', 't_booking_suppliers.name as s_name');

        //check tai xe thuoc dai ly
        $current_user 	= auth()->user();
        $driveData["agency_id"]   = $current_user->agency_id;

        if($driveData["agency_id"] > 0)
        {
            $resultQuery->where('agency_id', '=', $driveData["agency_id"] );
        }

        $drivers = $resultQuery->paginate(config('Reading.nodes_per_page'));

        return view('admin.booking.image', compact('drivers','page_title'));

    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function admin_imageedit($id)
    {
        $page_title = __('Hình dịch vụ');
        $driver = TBookingSupplierImages::findorFail($id);
        return view('admin.booking.imageedit', compact( 'driver','page_title'));
    }
    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function admin_imageupdate(Request $request, $id)
    {
        $bookingData["type"]                = 'IMAGE_DETAIL';
        $bookingData["status"]              = $request->input('status');

        $appUrl = config('app.url');

        $blog_metas = collect($request->data['BlogMeta'])->sortKeys()->all();

        if(!empty($blog_metas))
        {

            foreach ($blog_metas as $blog_meta)
            {
                if(!empty($blog_meta['value']))
                {

                    $OriginalName = $blog_meta['value']->getClientOriginalName();
                    $fileName = time().'_'.$OriginalName;
                    $blog_meta['value']->storeAs('public/booking', $fileName);
                        $blog_meta['value'] = $fileName;
                        //Array ( [title] => avatar [value] => 1680872171_6.png ) Array ( [title] => cmnd [value] => 1680872171_7.png ) Array ( [title] => gplx [value] => 1680872171_8.png
                        $bookingData["image"] =  $appUrl.'admin/public/storage/booking/'.$blog_meta["value"];

                }
            }
        }
        $booking_supplier_id  =0;
        //check tai xe thuoc dai ly
        $current_user 	= auth()->user();
        $driveData["agency_id"]   = $current_user->agency_id;
        if($driveData["agency_id"] > 0)
        {
            $check_phone = TBookingSuppliers::firstWhere('agency_id', $driveData["agency_id"]);
            $booking_supplier_id =  $check_phone["id"];
        }

        if($booking_supplier_id < 1)
        {
            $booking_supplier_id =   1;
        }

        $bookingData["booking_supplier_id"]  =   $booking_supplier_id;
        $booking               = TBookingSupplierImages::findorFail($id);
        $booking->fill($bookingData)->save();
        return redirect()->route('booking.admin.image')->with('success', __('Cập nhật thông tin thành công.'));

    }
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function admin_imagecreate()
    {
        $page_title = __('Tạo hình ảnh');
        return view('admin.booking.imagecreate', compact( 'page_title'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function admin_imagestore(Request $request)
    {
        $bookingData["type"]                = 'IMAGE_DETAIL';
        $bookingData["status"]              = $request->input('status');

        $appUrl = config('app.url');

        $blog_metas = collect($request->data['BlogMeta'])->sortKeys()->all();

        if(!empty($blog_metas))
        {

            foreach ($blog_metas as $blog_meta)
            {
                if(!empty($blog_meta['value']))
                {

                    $OriginalName = $blog_meta['value']->getClientOriginalName();
                    $fileName = time().'_'.$OriginalName;
                    $blog_meta['value']->storeAs('public/booking', $fileName);
                        $blog_meta['value'] = $fileName;
                        //Array ( [title] => avatar [value] => 1680872171_6.png ) Array ( [title] => cmnd [value] => 1680872171_7.png ) Array ( [title] => gplx [value] => 1680872171_8.png
                        $bookingData["image"] =  $appUrl.'admin/public/storage/booking/'.$blog_meta["value"];

                }
            }
        }
        $booking_supplier_id  =0;
        //check tai xe thuoc dai ly
        $current_user 	= auth()->user();
        $driveData["agency_id"]   = $current_user->agency_id;
        if($driveData["agency_id"] > 0)
        {
            $check_phone = TBookingSuppliers::firstWhere('agency_id', $driveData["agency_id"]);
            $booking_supplier_id =  $check_phone["id"];
        }

        if($booking_supplier_id < 1)
        {
            $booking_supplier_id =   1;
        }
        $bookingData["booking_supplier_id"]  =   $booking_supplier_id;


        $user = TBookingSupplierImages::create($bookingData);
        if($user)
        {
            return redirect()->route('booking.admin.image')->with('success', __('Thêm thông tin thành công.'));

        } else
        {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }


    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_supplier(Request $request)
    {
        $page_title             = __('Danh sách đại lý đặt lịch');
        $resultQuery            = TBookingSuppliers::query();
        if($request->isMethod('get') && $request->input('todo') == 'Filter')
        {

            if($request->filled('name')) {
                $resultQuery->where('t_booking_suppliers.name', 'like', "%{$request->input('name')}%");
            }
            if($request->filled('datefrom')) {
                $resultQuery->where('t_booking_suppliers.create_date', '>=', "{$request->input('datefrom')}");
            }
            if($request->filled('dateto')) {
                $resultQuery->where('t_booking_suppliers.create_date', '<', "{$request->input('dateto')}");
            }
        }
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'create_date';
        $resultQuery->orderBy('t_booking_suppliers.'.$sortBy, $direction);
        $sortWith = $request->get('with') ? $request->get('with') : Null;
       // $resultQuery->join('user_data', 'user_data.id', '=', 't_booking_comments.user_data_id');
        $resultQuery->join('agency', 'agency.id', '=', 't_booking_suppliers.agency_id');
        $resultQuery->select('t_booking_suppliers.*','agency.name as name_a');
        //check tai xe thuoc dai ly
        $current_user 	= auth()->user();
        $driveData["agency_id"]   = $current_user->agency_id;
        if($driveData["agency_id"] > 0)
        {
            $resultQuery->where('agency_id', '=', $driveData["agency_id"] );
        }

        $drivers = $resultQuery->paginate(config('Reading.nodes_per_page'));
        $ServicesArr        = CfServiceMain::pluck('name', 'id')->toArray();

        return view('admin.booking.supplier', compact('drivers','ServicesArr','page_title'));

    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function admin_supplieredit($id)
    {
        $page_title = __('Sửa dịch vụ đặt lịch cho đại lý');
        $driver = TBookingSuppliers::findorFail($id);
        $ServicesMainArr    = CfServiceMain::where('service_type', 2)->get();
        $AgencyArr    = Agency::get();
        return view('admin.booking.supplieredit', compact( 'driver','ServicesMainArr','AgencyArr','page_title'));
    }
    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function admin_supplierupdate(Request $request, $id)
    {
        $bookingData["name"]                = $request->input('name');
        $bookingData["description"]              = $request->input('description');
        $bookingData["address_text"]                = $request->input('address_text');
        $bookingData["status"]              = $request->input('status');
        $bookingData["lat"]                = $request->input('lat');
        $bookingData["lng"]              = $request->input('lng');

        $bookingData["service_id"]              = $request->input('service_id');
        $bookingData["agency_id"]              = $request->input('agency_id');


        $validation = [
            'name'           => 'required',
            'address_text'           => 'required',
            'lat'           => 'required',
            'lng'           => 'required',

        ];
        $validationMsg = [
            'name.required'      => __('Tên không để trống.'),
            'address_text.required'      => __('Địa chỉ không để trống.'),
            'lat.required'      => __('Lat không để trống.'),
            'lng.required'      => __('Long không để trống.'),
        ];
        $this->validate($request, $validation, $validationMsg);

        $appUrl = config('app.url');

        $blog_metas = collect($request->data['BlogMeta'])->sortKeys()->all();

        if(!empty($blog_metas))
        {

            foreach ($blog_metas as $blog_meta)
            {
                if(!empty($blog_meta['value']))
                {

                    $OriginalName = $blog_meta['value']->getClientOriginalName();
                    $fileName = time().'_'.$OriginalName;
                    $blog_meta['value']->storeAs('public/booking', $fileName);
                        $blog_meta['value'] = $fileName;
                        //Array ( [title] => avatar [value] => 1680872171_6.png ) Array ( [title] => cmnd [value] => 1680872171_7.png ) Array ( [title] => gplx [value] => 1680872171_8.png
                        $bookingData["thumbnail"] =  $appUrl.'admin/public/storage/booking/'.$blog_meta["value"];

                }
            }
        }
        $booking               = TBookingSuppliers::findorFail($id);
        $booking->fill($bookingData)->save();
        return redirect()->route('booking.admin.supplier')->with('success', __('Cập nhật thông tin thành công.'));

    }
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function admin_suppliercreate()
    {
        $page_title = __('Tạo dịch vụ đặt lịch cho đại lý');
        $ServicesMainArr    = CfServiceMain::where('service_type', 2)->get();
        $AgencyArr    = Agency::get();
       // return view('admin.booking.supplieredit', compact( 'driver','ServicesMainArr','AgencyArr','page_title'));

        return view('admin.booking.suppliercreate', compact('ServicesMainArr','AgencyArr', 'page_title'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function admin_supplierstore(Request $request)
    {
        $bookingData["name"]                = $request->input('name');
        $bookingData["description"]              = $request->input('description');
        $bookingData["address_text"]                = $request->input('address_text');
        $bookingData["status"]              = $request->input('status');
        $bookingData["lat"]                = $request->input('lat');
        $bookingData["lng"]              = $request->input('lng');
        $bookingData["service_id"]              = $request->input('service_id');
        $bookingData["agency_id"]              = $request->input('agency_id');


        $validation = [
            'name'           => 'required',
            'address_text'           => 'required',
            'lat'           => 'required',
            'lng'           => 'required',

        ];
        $validationMsg = [
            'name.required'      => __('Tên không để trống.'),
            'address_text.required'      => __('Địa chỉ không để trống.'),
            'lat.required'      => __('Lat không để trống.'),
            'lng.required'      => __('Long không để trống.'),
        ];
        $this->validate($request, $validation, $validationMsg);

        $appUrl = config('app.url');

        $blog_metas = collect($request->data['BlogMeta'])->sortKeys()->all();

        if(!empty($blog_metas))
        {

            foreach ($blog_metas as $blog_meta)
            {
                if(!empty($blog_meta['value']))
                {

                    $OriginalName = $blog_meta['value']->getClientOriginalName();
                    $fileName = time().'_'.$OriginalName;
                    $blog_meta['value']->storeAs('public/booking', $fileName);
                        $blog_meta['value'] = $fileName;
                        //Array ( [title] => avatar [value] => 1680872171_6.png ) Array ( [title] => cmnd [value] => 1680872171_7.png ) Array ( [title] => gplx [value] => 1680872171_8.png
                        $bookingData["thumbnail"] =  $appUrl.'admin/public/storage/booking/'.$blog_meta["value"];

                }
            }
        }
        $user = TBookingSuppliers::create($bookingData);
        if($user)
        {
            return redirect()->route('booking.admin.supplier')->with('success', __('Thêm thông tin thành công.'));

        } else
        {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }


    }
}
