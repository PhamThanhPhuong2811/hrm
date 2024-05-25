@extends('includes.NhanVien.backend')

@section('styles')
	<!-- Datatable CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
@endsection

@section('page-header')
<div class="row align-items-center">
	<div class="col">
		<h3 class="page-title">Các loại nghỉ phép</h3>
		<ul class="breadcrumb">
			<li class="breadcrumb-item">Nhân viên</li>
			<li class="breadcrumb-item active">Loại nghỉ phép</li>
		</ul>
	</div>
	
</div>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-striped custom-table datatable mb-0">
				<thead>
					<tr>
						<th>Lý do nghỉ</th>

						
					</tr>
				</thead>
				<tbody>
					@if(!empty($leave_types->count()))
						@foreach($leave_types as $leave_type)
						<tr>
							<td>{{$leave_type->type}}</td>
							
						   
							
						</tr>
						@endforeach
						<x-modals.delete :route="'leave-type.destroy'" :title="'Leave Type'" />
					@endif										
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Add Leavetype Modal -->
<div id="add_leavetype" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Thêm loại nghỉ phép</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{route('leave-type')}}" method="POST">
					@csrf
					<div class="form-group">
						<label>Loại nghỉ phép <span class="text-danger">*</span></label>
						<input class="form-control" name="type" type="text">
					</div>
					<!--<div class="form-group">
						<label>Number of days <span class="text-danger">*</span></label>
						<input class="form-control" name="days" type="text">
					</div>-->
					<div class="submit-section">
						<button class="btn btn-primary submit-btn">Thêm loại nghỉ phép</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /Add Leavetype Modal -->

<!-- Edit Leavetype Modal -->
<div id="edit_leavetype" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Chỉnh sửa loại nghỉ phép</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" action="{{route('leave-type')}}">
					@csrf
					@method('PUT')
					<input id="edit_id" type="hidden" name="id">
					<div class="form-group">
						<label>Loại nghỉ phép <span class="text-danger">*</span></label>
						<input class="form-control edit_type" name="type" type="text" >
					</div>
					<!--<div class="form-group">
						<label>Number of days <span class="text-danger">*</span></label>
						<input class="form-control edit_days" name="days" type="text" >
					</div>-->
					<div class="submit-section">
						<button type="submit" class="btn btn-primary submit-btn">Lưu</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /Edit Leavetype Modal -->
@endsection

@section('scripts')
<!-- Datatable JS -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script>
	$(document).ready(function (){
		
		$('.editbtn').on('click',function (){
			$('#edit_leavetype').modal('show');
			var id = $(this).data('id');
			var type = $(this).data('type');
			var days = $(this).data('days');
			
			$('#edit_id').val(id);
			$('.edit_type').val(type);
			$('.edit_days').val(days);

		});
	});
</script>
@endsection

