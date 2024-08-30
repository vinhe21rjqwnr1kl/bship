{{-- Extends layout --}}
@extends('admin.layout.default')
{{-- Content --}}
@section('content')
<!-- row -->
<div class="container-fluid">
	<div class="row">
		<div class="col-xl-3 col-sm-6 m-t35">
			<div class="card card-coin">
				<div class="card-body text-center">
					<svg id="Layer_1"  class="mb-3 currency-icon" height="80" viewBox="0 0 512 512" width="80" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><g fill-rule="evenodd"><path d="m256 0c-141.159 0-256 114.8-256 256s114.841 256 256 256 256-114.8 256-256-114.84-256-256-256z" fill="#a3d4ff"/><path d="m471.249 394.45.024-.038.119-.186.143-.223a255.283 255.283 0 0 0 22.7-44.273q3.988-10.1 7.111-20.616l-197.172-218.685 2.258 2.658 2.144 2.778 2.025 2.891 1.9 3 1.775 3.1 1.643 3.2 1.507 3.3 1.366 3.389 1.222 3.473 1.073 3.553.92 3.628.762 3.7.6 3.764.434 3.825.264 3.882.088 3.931-.088 3.933-.264 3.881-.434 3.824-.6 3.765-.762 3.7-.92 3.629-1.073 3.553-1.222 3.473-1.366 3.388-1.507 3.3-1.643 3.2-1.775 3.1-1.9 3-2.025 2.891-2.143 2.777-2.258 2.658-2.369 2.535-2.474 2.407-2.575 2.272-2.673 2.135-2.766 1.992-2.854 1.844-2.938 1.692-3.019 1.533-3.093 1.372-3.165 1.2-3.233 1.033-3.294.855-3.354.674-3.407.487-3.457.3-3.5.1-3.5-.1-3.457-.3-3.407-.487-3.353-.674-3.3-.855-3.232-1.033-3.166-1.2-3.094-1.372-3.018-1.534-2.939-1.691-2.854-1.844-2.766-1.992-2.673-2.135-2.575-2.273-2.474-2.406 169.76 166.892h-254.7l-.477-.012-.472-.035-.464-.057-.456-.081-.449-.1-.44-.123-.431-.143-.421-.164-.411-.182-.4-.2-.388-.221-.377-.238-.363-.255-.35-.273 149.45 125.764c.979-.049 1.952-.118 2.928-.178a255.275 255.275 0 0 0 164.89-74.25q4.494-4.479 8.768-9.171a257.78 257.78 0 0 0 22.49-28.544q1.717-2.521 3.366-5.087z" fill="#65b1fc"/><path d="m256 241.014c37.585 0 68.156-34.312 68.156-76.507s-30.57-76.507-68.156-76.507-68.161 34.312-68.161 76.507 30.579 76.507 68.161 76.507zm77.117 21.212h-154.23a63.027 63.027 0 0 0 -62.9 62.945v53.555a9.214 9.214 0 0 0 9.271 9.274h261.485a9.21 9.21 0 0 0 9.273-9.272v-53.559a63.024 63.024 0 0 0 -62.898-62.943z" fill="#fff"/></g></svg>
					<h2 class="text-black mb-2 font-w600">{{ number_format($khachhang_count) }}</h2>
					<p class="mb-0">
						Khách hàng
					</p>	
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-sm-6 m-t35">
			<div class="card card-coin">
				<div class="card-body text-center">
					<svg id="Capa_1" class="mb-3 currency-icon" enable-background="new 0 0 512 512" height="80" viewBox="0 200 512 80" width="80" xmlns="http://www.w3.org/2000/svg"><g><g><g><g><g><g><g><circle cx="256" cy="256" fill="#a3d4ff" r="256"/></g></g></g></g></g></g><path d="m278.519 68.977-43.998 41.17 38.743 38.527-161.122 216.886 87.105 87.105-.919.67 58.663 58.663c126.33-.479 231.085-92.462 251.433-213.116z" fill="#65b1fc"/><g><path d="m389.857 365.56h-277.715l106.951-245.353h62.757z" fill="#ff7045"/></g><g><path d="m295.109 120.207-38.907-.042v245.353l133.655.042z" fill="#de4726"/></g><g><g><path d="m296.432 460.672c-12.435 0-23.17-9.322-24.638-21.974l-15.592-134.388-15.592 134.388c-1.581 13.624-13.916 23.387-27.531 21.807-13.624-1.581-23.387-13.907-21.807-27.531l25.285-217.932c1.453-12.524 12.061-21.972 24.669-21.972h29.952c12.608 0 23.216 9.448 24.669 21.972l25.285 217.932c1.581 13.624-8.182 25.95-21.806 27.531-.973.112-1.938.167-2.894.167z" fill="#414952"/></g></g><g><g><path d="m321.132 432.973-25.285-217.932c-1.453-12.524-12.06-21.972-24.669-21.972h-15.192l.216 111.24 15.592 134.388c1.468 12.652 12.203 21.974 24.638 21.974.955 0 1.921-.055 2.893-.167 13.625-1.58 23.388-13.907 21.807-27.531z" fill="#23272b"/></g></g><g><g><ellipse cx="256.202" cy="89.222" fill="#ffcdbe" rx="30.132" ry="30.132" transform="matrix(.229 -.974 .974 .229 110.736 318.219)"/></g></g><g><g><path d="m256.202 59.09c-.073 0-.144.005-.216.005v60.252c.073 0 .144.005.216.005 16.641 0 30.131-13.49 30.131-30.132.001-16.639-13.489-30.13-30.131-30.13z" fill="#faa68e"/></g></g><g><path d="m351.599 171.967-43.905-47.005c-4.551-4.551-10.514-5.755-12.585-5.755h-76.017c-2.241 0-9.143.517-14.382 5.755l-43.905 47.005c-5.682 6.084-5.997 15.429-.738 21.882l46.12 56.581c3.291 4.037 8.081 6.13 12.913 6.13 3.698 0 7.419-1.226 10.508-3.744 7.127-5.809 8.195-16.296 2.386-23.422l-2.294-2.815h53.001l-2.294 2.815c-5.809 7.127-4.741 17.613 2.386 23.422 3.089 2.518 6.81 3.744 10.508 3.744 4.832 0 9.623-2.093 12.914-6.13l46.12-56.581c5.261-6.453 4.946-15.798-.736-21.882zm-156.542 12.109 10.578-11.326 5.908 31.552zm108.458 16.97 4.073-27.419 9.76 10.449z" fill="#fff"/></g><g><path d="m351.599 171.967-43.905-47.005c-4.551-4.551-10.515-5.755-12.585-5.755h-39.123v107.372h26.717l-2.294 2.815c-5.809 7.127-4.741 17.613 2.386 23.422 3.089 2.518 6.81 3.744 10.508 3.744 4.831 0 9.623-2.093 12.914-6.13l46.12-56.581c5.259-6.453 4.944-15.798-.738-21.882zm-48.084 29.079 4.073-27.419 9.76 10.449z" fill="#e9edf5"/></g></g></svg>

					<h2 class="text-black mb-2 font-w600">{{ number_format($taixe_count) }}</h2>
					<p class="mb-0">
						Tài xế
					</p>	
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-sm-6 m-t35">
			<div class="card card-coin">
				<div class="card-body text-center">
					<svg class="mb-3 currency-icon" height="80" viewBox="0 0 512 512" width="80" xmlns="http://www.w3.org/2000/svg"><path d="m512 256c0 141.386719-114.613281 256-256 256s-256-114.613281-256-256 114.613281-256 256-256 256 114.613281 256 256zm0 0" fill="#a3d4ff"/><path d="m510.617188 282.707031-193.867188-193.867187-232.304688 219.519531 199.476563 202.117187c119.480469-12.960937 214.292969-108.121093 226.695313-227.769531zm0 0" fill="#65b1fc"/><path d="m84.445312 98.800781h232.304688v209.558594h-232.304688zm0 0" fill="#fefefe"/><path d="m200.601562 98.804688h116.148438v209.554687h-116.148438zm0 0" fill="#f4ede7"/><path d="m84.445312 88.839844h232.304688v41.097656h-232.304688zm0 0" fill="#6ed747"/><path d="m200.601562 88.839844h116.148438v41.101562h-116.148438zm0 0" fill="#4b9f28"/><path d="m253.496094 109.390625c0 5.117187-4.148438 9.261719-9.265625 9.261719-5.117188 0-9.261719-4.144532-9.261719-9.261719s4.144531-9.265625 9.261719-9.265625c5.117187 0 9.265625 4.148438 9.265625 9.265625zm0 0" fill="#0d789b"/><path d="m303.765625 109.390625c0 5.117187-4.148437 9.261719-9.265625 9.261719s-9.261719-4.144532-9.261719-9.261719 4.144531-9.265625 9.261719-9.265625 9.265625 4.148438 9.265625 9.265625zm0 0" fill="#fb5c59"/><path d="m278.628906 109.390625c0 5.117187-4.148437 9.261719-9.261718 9.261719-5.117188 0-9.265626-4.144532-9.265626-9.261719s4.148438-9.265625 9.265626-9.265625c5.113281 0 9.261718 4.148438 9.261718 9.265625zm0 0" fill="#ff9b00"/><path d="m139.847656 156.203125h232.304688v209.558594h-232.304688zm0 0" fill="#e0e0e2"/><path d="m256 156.203125h116.152344v209.558594h-116.152344zm0 0" fill="#c7c5cb"/><path d="m139.847656 146.242188h232.304688v41.097656h-232.304688zm0 0" fill="#fad818"/><path d="m256 146.238281h116.152344v41.105469h-116.152344zm0 0" fill="#f4b913"/><path d="m308.898438 166.789062c0 5.117188-4.148438 9.265626-9.265626 9.265626-5.117187 0-9.265624-4.148438-9.265624-9.265626 0-5.113281 4.148437-9.261718 9.265624-9.261718 5.117188 0 9.265626 4.148437 9.265626 9.261718zm0 0" fill="#0d789b"/><path d="m359.167969 166.789062c0 5.117188-4.148438 9.265626-9.265625 9.265626-5.117188 0-9.261719-4.148438-9.261719-9.265626 0-5.113281 4.144531-9.261718 9.261719-9.261718 5.117187 0 9.265625 4.148437 9.265625 9.261718zm0 0" fill="#eb1500"/><path d="m334.03125 166.789062c0 5.117188-4.148438 9.265626-9.261719 9.265626-5.117187 0-9.265625-4.148438-9.265625-9.265626 0-5.113281 4.148438-9.261718 9.265625-9.261718 5.113281 0 9.261719 4.148437 9.261719 9.261718zm0 0" fill="#ffe031"/><path d="m195.25 213.605469h232.304688v209.554687h-232.304688zm0 0" fill="#fefefe"/><path d="m311.402344 213.605469h116.152344v209.554687h-116.152344zm0 0" fill="#f4ede7"/><path d="m195.25 203.644531h232.304688v41.097657h-232.304688zm0 0" fill="#6ed747"/><path d="m311.402344 203.640625h116.152344v41.105469h-116.152344zm0 0" fill="#4b9f28"/><path d="m364.300781 224.191406c0 5.117188-4.148437 9.265625-9.265625 9.265625-5.117187 0-9.265625-4.148437-9.265625-9.265625 0-5.113281 4.148438-9.261718 9.265625-9.261718 5.117188 0 9.265625 4.148437 9.265625 9.261718zm0 0" fill="#0d789b"/><path d="m414.570312 224.191406c0 5.117188-4.148437 9.265625-9.265624 9.265625-5.117188 0-9.265626-4.148437-9.265626-9.265625 0-5.113281 4.148438-9.261718 9.265626-9.261718 5.117187 0 9.265624 4.148437 9.265624 9.261718zm0 0" fill="#fb5c59"/><path d="m389.433594 224.191406c0 5.117188-4.148438 9.265625-9.261719 9.265625-5.117187 0-9.265625-4.148437-9.265625-9.265625 0-5.113281 4.148438-9.261718 9.265625-9.261718 5.113281 0 9.261719 4.148437 9.261719 9.261718zm0 0" fill="#ff9b00"/><path d="m229.941406 265.582031h162.921875v94.6875h-162.921875zm0 0" fill="#fb5c59"/><path d="m311.398438 265.578125h81.460937v94.691406h-81.460937zm0 0" fill="#eb1500"/><path d="m220.492188 372.695312h62v30h-62zm0 0" fill="#fad818"/><path d="m340.3125 372.695312h62v30h-62zm0 0" fill="#f4b913"/><path d="m291.570312 372.695312h39.664063v30h-39.664063zm0 0" fill="#fad818"/><path d="m311.398438 372.691406h19.839843v30h-19.839843zm0 0" fill="#f4b913"/></svg>
					<h2 class="text-black mb-2 font-w600">{{ number_format($go_info_count) }}</h2>
					<p class="mb-0">
						Chuyến đi
					</p>	
				</div>
			</div>
		</div>
		
		<div class="col-xl-3 col-sm-6 m-t35">
			<div class="card card-coin">
				<div class="card-body text-center">
						<svg class="mb-3 currency-icon" width="80" height="80"  version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
							 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
						<circle style="fill:#a3d4ff;" cx="256" cy="256" r="256"/>
						<path style="fill:#65b1fc;" d="M511.716,267.195L387.661,143.137H172.692l-24.174,24.174l-24.172,24.21v129.536h0.036
							l185.247,185.27C421.732,482.424,506.634,385.17,511.716,267.195z"/>
						<polygon style="fill:#FFFFFF;" points="124.344,191.506 124.344,321.042 281.431,321.042 329.231,368.855 329.231,321.042 
							387.656,321.042 387.656,143.137 172.703,143.137 "/>
						<polygon style="fill:#E1EFFA;" points="124.344,239.859 172.703,191.506 148.534,167.309 124.344,191.506 "/>
						<polygon style="fill:#FF8E31;" points="172.703,191.506 124.344,191.506 172.703,143.137 "/>
						<g>
							<path style="fill:#5D6D7E;" d="M257.518,299.382h-75.182c-0.584,0-1.062-0.466-1.062-1.06c0-0.586,0.479-1.068,1.062-1.068h75.182
								c0.584,0,1.06,0.481,1.06,1.068C258.578,298.918,258.099,299.382,257.518,299.382z"/>
							<path style="fill:#5D6D7E;" d="M217.359,287.841l15.485-26.954l-13.14-13.141l-26.962,15.468
								c0.177,11.715-3.182,23.493-10.099,33.556c-0.102,0.028-0.197,0.069-0.243,0.125c-0.159,0.143-0.159,0.407,0,0.556
								c0.143,0.156,0.389,0.156,0.543,0.008l22.551-23.59c-0.223-0.689-0.056-1.467,0.481-1.994c0.765-0.781,1.976-0.773,2.742,0
								c0.755,0.737,0.755,1.994,0.013,2.744c-0.532,0.563-1.321,0.709-2.002,0.474l-23.611,22.551c-0.133,0.141-0.148,0.399,0.005,0.576
								c0.161,0.143,0.422,0.143,0.571,0c0.084-0.074,0.097-0.174,0.128-0.266C193.866,291.018,205.627,287.652,217.359,287.841z"/>
						</g>
						<path style="fill:#34495E;" d="M183.826,297.951c-0.031,0.069-0.046,0.189-0.11,0.253c-0.164,0.156-0.428,0.156-0.586,0
							c-0.166-0.161-0.141-0.422-0.005-0.563l23.611-22.551c0.681,0.238,1.454,0.069,1.994-0.479c0.748-0.745,0.748-2.002-0.008-2.739
							l17.572-17.559l6.523,6.556l-15.457,26.975C205.665,287.66,193.866,291.018,183.826,297.951z"/>
						<path style="fill:#F15540;" d="M316.672,163.904L316.672,163.904L316.672,163.904z"/>
						<path style="fill:#FF8E31;" d="M321.592,175.78c-0.003-4.641-1.882-8.835-4.92-11.876c-3.041-3.041-7.24-4.915-11.876-4.915
							c-4.641,0-8.835,1.876-11.878,4.915l-60.093,60.104l23.736,23.736l60.285-60.265C319.89,184.445,321.59,180.416,321.592,175.78z"/>
						<g>
							<path style="fill:#FFC87C;" d="M256.036,207.99c-0.794-0.801-0.794-2.094,0-2.88l27.172-27.172c0.794-0.801,2.081-0.801,2.872,0
								c0.801,0.801,0.801,2.086,0,2.885l-27.162,27.167C258.122,208.776,256.829,208.776,256.036,207.99z"/>
							<path style="fill:#FFC87C;" d="M298.363,166.651c-0.166-0.161-0.299-0.366-0.407-0.576c-0.479-1.011-0.046-2.227,0.97-2.719
								c1.864-0.878,3.843-1.313,5.873-1.313c3.666,0,7.119,1.418,9.713,4.017c0.794,0.794,0.794,2.079,0.008,2.88
								c-0.796,0.801-2.086,0.801-2.888,0.005c-1.825-1.841-4.25-2.844-6.833-2.844c-1.431,0-2.821,0.323-4.129,0.942
								C299.873,167.421,298.949,167.24,298.363,166.651z"/>
						</g>
						<polygon style="fill:#FF9D4D;" points="233.654,261.683 218.911,246.945 234.903,226.094 254.505,245.688 "/>
						<polygon style="fill:#34495E;" points="311.629,192.694 287.877,168.947 290.757,166.06 314.509,189.819 "/>
						<polygon style="fill:#F28124;" points="252.052,247.557 254.505,245.688 234.903,226.094 233.027,228.531 "/>
						<path style="fill:#5D6D7E;" d="M290.757,166.06l-0.701-0.709c-1.155-1.16-2.698-1.784-4.332-1.784
							c-1.641,0.013-3.174,0.645-4.326,1.812l-23.404,23.626c-0.794,0.781-0.786,2.079,0.005,2.872h0.003
							c0.801,0.794,2.086,0.786,2.88-0.013l23.411-23.619c0.381-0.394,0.899-0.604,1.441-0.604c0.548,0,1.06,0.205,1.444,0.596
							l0.701,0.709L290.757,166.06z"/>
						</svg>
					<h2 class="text-black mb-2 font-w600">{{ number_format($service_count) }}</h2>
					<p class="mb-0">
						Dịch vụ
					</p>	
					
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-16 col-xxl-15">
			<div class="card">
				<div class="card-header border-0 flex-wrap pb-0">
					<div class="mb-3">
						<h4 class="fs-20 text-black">Khách hàng</h4>
						<p class="mb-0 fs-12 ">Khách hàng tạo mới(tháng)</p>
					</div>
				</div>
				<div class="card-body pb-2 px-3">
					<div id="revenueMap" class="market-line"></div>
				</div>
			</div>
		</div>
		
	</div>
</div>
@endsection

@push('inline-scripts')
	<script>
		'use strict';
		var catagory_counts = {};
		var catagory_labels = {};
		var users_monthyear = {!! $users_monthyear !!};
		var users_count = {!! $users_count !!};
		var max_user_count = {!! $max_user_count !!};
	</script>
@endpush