@extends('layouts.backend')

@section('styles')
<!-- Datatable CSS -->
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">

@endsection

@section('page-header')
<div class="row align-items-center">
	<div class="col">
		<h3 class="page-title">Tài sản</h3>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Thống kê</a></li>
			<li class="breadcrumb-item active">Tài sản</li>
		</ul>
	</div>
	<div class="col-auto float-right ml-auto">
		<a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_asset"><i class="fa fa-plus"></i> Thêm tài sản</a>
	</div>
</div>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-striped custom-table mb-0 datatable">
				<thead>
					<tr>
						<th>Tên tài sản</th>
						<th>Mã tài sản</th>
						<th>Ngày mua</th>
						<th>Bảo hành</th>
						<th>Người bán</th>
						<th>Giá trị</th>
						<th class="text-center">Tình trạng</th>
						<th class="text-right">Hành động</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($assets as $asset)
						<tr>
							<td>
								<strong>{{$asset->name}}</strong>
							</td>
							<td>{{$asset->uuid}}</td>
							<td>{{date_format(date_create($asset->purchase_date),'d/m/Y')}}</td>
							<td>{{$asset->warranty}} tháng</td>
							<td>{{$asset->supplier}}</td>
							<td> {{ number_format($asset->value, 0, ',', '.') }} VND</td>
							<td class="text-center">
								{{$asset->condition}}
							</td>
							<td class="text-right">
								<div class="dropdown dropdown-action">
									<a href="javascript:void(0)" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
									<div class="dropdown-menu dropdown-menu-right">
										<a data-id="{{$asset->id}}" data-name="{{$asset->name}}"
											data-uuid="{{$asset->uuid}}" data-pdate="{{$asset->purchase_date}}"
											 data-pfrom="{{$asset->purchase_from}}"
											 data-manufacturer="{{$asset->manufacturer}}"
											 data-model="{{$asset->model}}" data-sn="{{$asset->serial_number}}" data-supplier="{{$asset->supplier}}" data-condition="{{$asset->condition}}" data-warranty="{{$asset->warranty}}" data-value="{{$asset->value}}"
											 data-status="{{$asset->status}}" data-description="{{$asset->description}}" class="dropdown-item editbtn" href="javascript:void(0)" data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Chỉnh sửa</a>
										<a data-id="{{$asset->id}}" class="dropdown-item deletebtn" href="javascript:void(0)" data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Xóa</a>
									</div>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- Add Asset Modal -->
<div id="add_asset" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Thêm tài sản</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{route('assets')}}">
					@csrf
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Tên tài sản <span class="text-danger">*</label>
								<input class="form-control" name="name" type="text">
							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Ngày mua <span class="text-danger">*</label>
								<input class="form-control datetimepicker" name="purchase_date" type="text">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Mua từ <span class="text-danger">*</label>
								<input class="form-control" name="purchase_from" type="text">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Công ty sản xuất</label>
								<input class="form-control" name="manufacturer" type="text">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Mẫu mã</label>
								<input class="form-control" name="model" type="text">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Số seri</label>
								<input class="form-control" name="serial_number" type="text">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Nhà cung cấp <span class="text-danger">*</label>
								<input class="form-control" name="supplier" type="text">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Tình trạng</label>
								<input class="form-control" name="condition" type="text">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Bảo hành</label>
								<input class="form-control" name="warranty" type="text" placeholder="Bảo hành bao nhiêu tháng">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Giá trị <span class="text-danger">*</label>
								<input name="value" placeholder="Ví dụ: 1.000.000 VND" class="form-control" type="text">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Mô tả</label>
								<textarea name="description" class="form-control" rows="4"></textarea>
							</div>
						</div>
					</div>
					<div class="submit-section">
						<button class="btn btn-primary submit-btn">Thêm</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /Add Asset Modal -->

<!-- Edit Asset Modal -->
<div id="edit_asset" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Sửa thông tin tài sản</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{route('assets')}}">
					@csrf
					@method("PUT")
					<div class="row">
						<input type="hidden" name="id" id="edit_id">
						<div class="col-md-6">
							<div class="form-group">
								<label>Tên tài sản</label>
								<input class="form-control edit_name" name="name" type="text">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Mã tài sản</label>
								<input name="uuid" class="form-control edit_uuid" type="text" value="#TS-0001" readonly>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Ngày mua</label>
								<input class="form-control datetimepicker edit_date" name="purchase_date" type="text">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Mua từ</label>
								<input class="form-control edit_from" name="purchase_from" type="text">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Công ty sản xuất</label>
								<input class="form-control edit_manufacturer" name="manufacturer" type="text">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Mẫu mã</label>
								<input class="form-control edit_model" name="model" type="text">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Số seri</label>
								<input class="form-control edit_serial" name="serial_number" type="text">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Nhà cung cấp</label>
								<input class="form-control edit_supplier" name="supplier" type="text">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Tình trạng</label>
								<input class="form-control edit_condition" name="condition" type="text">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Bảo hành</label>
								<input class="form-control edit_warranty" name="warranty" type="text" placeholder="Bảo hành trong bao nhiêu tháng?">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Giá trị</label>
								<input name="value" placeholder="VD: 1tr đồng" class="form-control edit_value" type="text">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label>Mô tả</label>
								<textarea name="description" class="form-control edit_description"></textarea>
							</div>
						</div>
					</div>
					<div class="submit-section">
						<button class="btn btn-primary submit-btn">Lưu</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Edit Asset Modal -->
<x-modals.delete :route="'assets'" :title="'tài sản'"/>
@endsection

@section('scripts')
	<!-- Datatable JS -->
	<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>

	<script>
		$(document).ready(function(){
			$('.table').on('click','.editbtn',function(){
				$('#edit_asset').modal('show');
				var id = $(this).data('id');
				var uuid = $(this).data('uuid');
				var name = $(this).data('name');
				var purchase_date = $(this).data('pdate');
				var purchase_from = $(this).data('pfrom');
				var manufacturer = $(this).data('manufacturer');
				var serial_number = $(this).data('sn');
				var model = $(this).data('model');
				var supplier = $(this).data('supplier');
				var condition = $(this).data('condition');
				var warranty = $(this).data('warranty');
				var value = $(this).data('value');
				var status = $(this).data('status');
				var description = $(this).data('description');
				$('#edit_id').val(id);
				$('.edit_name').val(name);
				$('.edit_uuid').val(uuid);
				$('.edit_date').val(purchase_date);
				$('.edit_from').val(purchase_from);
				$('.edit_manufacturer').val(manufacturer);
				$('.edit_model').val(model);
				$('.edit_serial').val(serial_number);
				$('.edit_supplier').val(supplier);
				$('.edit_condition').val(condition);
				$('.edit_warranty').val(warranty);
				$('.edit_value').val(value);
				$("#status_select").val(status).change();
				$('.edit_description').val(description);
			});
		});
	</script>
@endsection
