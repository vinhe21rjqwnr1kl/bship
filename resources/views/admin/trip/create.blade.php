{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
	<form action="{{ route('trip.admin.store') }}" method="post" enctype="multipart/form-data">
		@csrf
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Thông tin</h4>
							</div>
							<div class="card-body p-12">
								<div class="row col-12" >
									<div class="form-group col-12">
										<label>Dịch vụ</label>
										<select name="service_detail_id" id="service_detail_id" class="default-select form-control">
										@forelse($ServicesDetailArr as $services)
												<option value="{{ $services->id }}">{{ $ServicesArr[$services->service_id] }}--{{ $ServicesTypeArr[$services->service_type] }}</option>
											@empty
											@endforelse
										</select>
										@error('service_detail_id')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-6">
										<label for="BlogTitle">SĐT khách hàng</label>
										<input type="text" name="sdt_kh" class="form-control" id="sdt_kh" placeholder="" value="{{ old('sdt_kh') }}">
										@error('sdt_kh')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-6">
										<label for="BlogTitle">SĐT tài xế</label>
										<input type="text" name="sdt_tx" class="form-control" id="sdt_tx" placeholder="" value="{{ old('sdt_tx') }}">
										@error('sdt_tx')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">Địa chỉ đi</label>
										<input type="text" name="from" class="form-control" id="from" placeholder="" value="{{ old('from') }}">
										@error('from')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-12">
										<label for="BlogTitle">Địa chỉ đến</label>
										<input type="text" name="to" class="form-control" id="to" placeholder="" value="{{ old('to') }}">
										@error('to')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-4">
										<label for="BlogTitle">Tổng  tiền</label>
										<input type="text" name="money_total" class="form-control" id="BlogTmoney_totalitle" placeholder="" value="{{ old('money_total') }}">
										@error('money_total')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-4">
										<label for="BlogTitle">Tiền tài xế</label>
										<input type="text" name="money_tx" class="form-control" id="money_tx" placeholder="" value="{{ old('money_tx') }}">
										@error('money_tx')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-4">
										<label for="BlogTitle">Tiền butl</label>
										<input type="text" name="money_butl" class="form-control" id="money_butl" placeholder="" value="{{ old('money_butl') }}">
										@error('money_butl')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-4">
										<label for="BlogTitle">Tiền khuyến mãi</label>
										<input type="text" name="money_km" class="form-control" id="money_km" placeholder="" value="{{ old('money_km') }}">
										@error('money_km')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
									<div class="form-group col-md-4">
										<label for="BlogTitle">Tiền dịch vụ</label>
										<input type="text" name="money_dv" class="form-control" id="money_dv" placeholder="" value="{{ old('money_dv') }}">
										@error('money_dv')
											<p class="text-danger">
												{{ $message }}
											</p>
										@enderror
									</div>
                                    <div class="form-group col-md-4">
                                        <label for="vat_money">Tiền VAT</label>
                                        <input type="text" name="vat_money" class="form-control" id="vat_money" placeholder="" value="{{ old('vat_money') }}">
                                        @error('vat_money')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>


									<div class="col-md-12">
										<button type="submit" class="btn btn-primary">Thêm</button>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

			</div>
{{--		</div>--}}
	</form>
</div>

@push('inline-scripts')
	<script>
		'use strict';
		var screenOptionArray = '<?php echo json_encode($screenOption) ?>';
	</script>
@endpush

@endsection

