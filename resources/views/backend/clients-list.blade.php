@extends('layouts.backend')

@section('styles')	
<!-- Datatable CSS -->
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
@endsection

@section('page-header')
<div class="row align-items-center">
	<div class="col">
		<h3 class="page-title">Danh sách khách hàng</h3>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Thống kê</a></li>
			<li class="breadcrumb-item active">Khách hàng</li>
		</ul>
	</div>
	<div class="col-auto float-right ml-auto">
		<a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_client"><i class="fa fa-plus"></i> Thêm khách hàng</a>
		<div class="view-icons">
			<a href="{{route('clients')}}" class="grid-view btn btn-link {{route_is('clients') ? 'active' : '' }}"><i class="fa fa-th"></i></a>
			<a href="{{route('clients-list')}}" class="list-view btn btn-link {{route_is('clients-list') ? 'active' : '' }}"><i class="fa fa-bars"></i></a>
		</div>
	</div>
</div>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-striped custom-table datatable">
				<thead>
					<tr>
						<th>Mã khách hàng</th>
						<th>Họ và tên</th>
						<th>Email</th>
						<th>SDT</th>
						<th>Địa chỉ liên hệ</th>
						<th class="text-right">Hành động</th>
					</tr>
				</thead>
				<tbody>
					@if (!empty($clients->count()))
						@foreach ($clients as $client)
						<tr>
						
							<td>KH-{{$client->id}}</td>
							<td>
								{{$client->firstname}} {{$client->lastname}}
							</td>
							<td>{{$client->email}}</td>
							<td>{{$client->phone}}</td>
							<td>{{$client->company}}</td>
							<td class="text-right">
								<div class="dropdown dropdown-action">
									<a href="javascript:void(0)" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
									<div class="dropdown-menu dropdown-menu-right">
										<a data-id="{{$client->id}}" data-firstname="{{$client->firstname}}" data-lastname="{{$client->lastname}}" data-email="{{$client->email}}" data-phone="{{$client->phone}}" data-avatar="{{$client->avatar}}" data-company="{{$client->company}}" class="dropdown-item editbtn" href="javascript:void(0)" data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Chỉnh sửa</a>
										<a data-id="{{$client->id}}" class="dropdown-item deletebtn" href="javascript:void(0)" data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Xóa</a>
									</div>
								</div>
							</td>
						</tr>
						@endforeach
						<x-modals.delete :route="'client.destroy'" :title="'Client'" />
						<!-- Edit Client Modal -->
						<div id="edit_client" class="modal custom-modal fade" role="dialog">
							<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Chỉnh sửa thông tin khách hàng</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form method="POST" enctype="multipart/form-data" action="{{route('client.update')}}">
											@csrf
											@method("PUT")
											<div class="row">
												<input type="hidden" id="edit_id" name="id">
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-form-label">Họ <span class="text-danger">*</span></label>
														<input class="form-control edit_firstname" name="firstname" type="text">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-form-label">Tên</label>
														<input class="form-control edit_lastname" name="lastname" type="text">
													</div>
												</div>
												
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-form-label">Email <span class="text-danger">*</span></label>
														<input class="form-control floating edit_email" name="email" type="email">
													</div>
												</div>
												
												<div class="col-md-6">  
													<div class="form-group">
														<label class="col-form-label">Avt<span class="text-danger">*</span></label>
														<input class="form-control floating edit_avatar" name="avatar" type="file">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-form-label">SĐT </label>
														<input class="form-control edit_phone" name="phone" type="text">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-form-label">Địa chỉ liên hệ</label>
														<input class="form-control edit_company" name="company" type="text">
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
						<!-- /Edit Client Modal -->
					@endif					
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Add Client Modal -->
<div id="add_client" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Thêm khách hàng</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" enctype="multipart/form-data" action="{{route('client.add')}}">
					@csrf
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label">Họ <span class="text-danger">*</span></label>
								<input class="form-control" name="firstname" type="text">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label">Tên</label>
								<input class="form-control" name="lastname" type="text">
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label">Email <span class="text-danger">*</span></label>
								<input class="form-control floating" name="email" type="email">
							</div>
						</div>
						
						<div class="col-md-6">  
							<div class="form-group">
								<label class="col-form-label">Avt<span class="text-danger">*</span></label>
								<input class="form-control floating" name="avatar" type="file">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label">SĐT </label>
								<input class="form-control" name="phone" type="text">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label">Địa chỉ liên hệ</label>
								<input class="form-control" name="company" type="text">
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
<!-- /Add Client Modal -->
@endsection

@section('scripts')
<!-- Datatable JS -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script>
	$(document).ready(function (){
		$('.editbtn').on('click',function (){
			$('#edit_client').modal('show');
			var id = $(this).data('id');
			var firstname = $(this).data('firstname');
			var lastname = $(this).data('lastname');
			var email = $(this).data('email');
			var phone = $(this).data('phone');
			var avatar = $(this).data('avatar');
			var company = $(this).data('company');

			$('#edit_id').val(id);
			$('.edit_firstname').val(firstname);
			$('.edit_lastname').val(lastname);
			$('.edit_email').val(email);
			$('.edit_phone').val(phone);
			$('.edit_avatar').val(avatar);
			$('.edit_company').val(company);
		})
	})
</script>
@endsection


