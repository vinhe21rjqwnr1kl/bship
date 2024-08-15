<?php

return [
	'name'          => 'Blog',
	'slug'          => 'blog',
	'route_prefix'  => 'blogs',
	'ScreenOption'	=> array(
		'Categories'	=> array('visibility' => true),
		'FeaturedImage'	=> array('visibility' => true),
		'Video'			=> array('visibility' => false),
		'Excerpt'		=> array('visibility' => true),
		'CustomFields'	=> array('visibility' => true),
		'Discussion'	=> array('visibility' => false),
		'Slug'			=> array('visibility' => false),
		'Author'		=> array('visibility' => true),
		'Seo'			=> array('visibility' => true),
		'Tags'			=> array('visibility' => true),
	),
	'status' => array(
					'1' => 'Published',
					'2' => 'Draft',
					'3' => 'Trash',
					'4' => 'Private',
					'5' => 'Pending'
				),

    'type_payments' => array(
        'cashin' => 'Nạp ví tài xế - Tiền mặt',
        'cashin_online' => 'Nạp ví tài xế - Online',
        'refund' => 'Hoàn ví cuốc hủy',
        'refund_payment_trip' => 'Hoàn ví cuốc chuyển khoản',
        'donate' => 'Tặng/thưởng',
        'cashout' => 'Rút ví ngưng hợp tác',
        'other' => 'Khác'
    ),

    'type_points' => array(
        'give_event' => 'Tặng sự kiện',
        'buy_point' => 'Khách mua điểm',
        'give_vip' => 'Tặng khách hàng VIP',
        'give_staff' => 'Tặng nhân viên',
        'cashout' => 'Rút hoàn tiền',
        'other' => 'Khác'
    ),
];
