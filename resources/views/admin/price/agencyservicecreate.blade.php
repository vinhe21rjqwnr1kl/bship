{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')
<script type="text/javascript">
	function change_first(x)
	{
		//var value = document.getElementById("duration_block_first");
		document.getElementById("duration_block_first01").value= x;
	}
	function change_second(x)
	{
		//var value = document.getElementById("duration_block_first");
		document.getElementById("duration_block_second01").value= x;
	
	}
	</script>
<div class="container-fluid">

	<div class="card">
		<form action="{{ route('price.admin.agencyservicestore') }}" method="POST" enctype="multipart/form-data">
        @csrf
			<div class="card-body">
				<div class="basic-form">
					<div class="row align-items-center">

						<div class="col-sm-12">
								<div class="form-group col-12">
									<label>Đại lý</label>
									<select name="agency_id" id="agency_id" class="default-select form-control">
									@forelse($Agency as $services)
											<option value="{{ $services->id }}">{{ $services->name }}</option>
										@empty
										@endforelse
									</select>
								</div>
						</div>
						<table class="table table-responsive-lg mb-0">
							<thead class="">
								<tr>
									<th> <strong>ID</strong> </th>
									<th> <strong> Tên dịch vụ </strong> </th>
									<th> <strong> Loại dịch vụ </strong> </th>
									<th> <strong> Trạng thái </strong> </th>
								</tr>
							</thead>
							<tbody>
								@forelse ($ServicesDetailArr as $page01)
									<tr>
										<td> {{$page01->id}}</td>
										<td> {{$ServicesArr[$page01->service_id]}}</td>
										<td> {{$ServicesTypeArr[$page01->service_type]}}</td>
									  <td><input type='checkbox' name='checkboxvar[]' value='{{$page01->id}}'></td>					
									</tr>
								@empty
									<tr><td class="text-center" colspan="9"><p>Không có dữ liệu.</p></td></tr>
								@endforelse

							</tbody>
						</table>
						
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary">Tạo</button>
				<a href="{{ route('price.admin.gservice') }}" class="btn btn-danger">Quay lại</a>
			</div>
		</form>
	</div>

</div>

@endsection