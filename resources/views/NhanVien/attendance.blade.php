@extends('includes.NhanVien.backend')

@section('styles')
<!-- Select2 CSS -->
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">
<!-- Datatable CSS -->
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
@endsection

@section('page-header')
<div class="row align-items-center">
	<div class="col">
		<h3 class="page-title">Chấm công nhân viên</h3>
		<ul class="breadcrumb">
			<li class="breadcrumb-item">Nhân viên</li>
			<li class="breadcrumb-item active">Chấm công</li>
		</ul>
	</div>
	
</div>
@endsection


@section('content')
<div class="row">
	<div class="col-md-7">
		<form action="{{ route('Xemchamcong.filter') }}" method="post">
			@csrf
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>Chọn tháng</label>
						<select class="form-control select2" name="month">
							@for ($m = 1; $m <= 12; $m++)
								<option value="{{ $m }}" {{ ($month == $m) ? 'selected' : '' }}>{{ $m }}</option>
							@endfor
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Chọn năm</label>
						<select class="form-control select2" name="year">
							@for ($y = 2024; $y <= Carbon\Carbon::now()->year; $y++)
								<option value="{{ $y }}" {{ ($year == $y) ? 'selected' : '' }}>{{ $y }}</option>
							@endfor
						</select>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label>&nbsp;</label>
						<button type="submit" class="btn btn-primary form-control" style="width: 80px; margin-top: 30px; height: 35px;">Lọc</button>
					</div>
				</div>
			</div>
		</form>
	</div>
	
	
	<div class="col-lg-12">
		<div class="table-responsive">
			<table class="table datatable table-striped custom-table mb-0">
				<thead>
					<tr>
						<th>Nhân viên</th>
						<th>Thời gian vào</th>
						<th>Thời gian ra</th>
						<th>Ngày</th>
						<th>Trạng thái</th>
						<th>Số lần đi trễ/tháng {{ $month }}</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($attendances as $attendance) 
					<tr>
					   <td>
							<h2 class="table-avatar">
								<a href="#" class="avatar"><img alt="avatar"  src="{{ !empty($attendance->employee->avatar) ? asset('storage/employees/'.$attendance->employee->avatar): asset('assets/img/profiles/avatar-19.jpg') }}"></a>
								<a href="#">{{$attendance->employee->firstname.' '. $attendance->employee->lastname}}<span>{{$attendance->employee->designation->name}}</span></a>
							</h2>
						</td>
					   <td>{{date_format(date_create($attendance->checkin),'H:i a')}}</td>
					   <td>{{!empty($attendance->checkout) ? date_format(date_create($attendance->checkout),'H:i a'): ' '}}</td>
					   <td>{{date_format(date_create($attendance->created_at),'d/m/Y')}}</td>
					   <td>{{$attendance->status}}</td>
					   <td>{{ \App\Models\LateCount::where('employee_id', $attendance->employee_id)->where('month', date('m'))->where('year', date('Y'))->value('late_count') ?? 0 }}</td>
							
						
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

<x-modals.delete route="employees.attendance" title="Attendance"/>
<x-modals.popup />
@endsection


@section('scripts')
<!-- Select2 JS -->
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<!-- Datatable JS -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script>
	$(document).ready(function(){
		$('.editbtn').click(function(){
			var id = $(this).data('id');
			var checkin = $(this).data('checkin');
			var checkout = $(this).data('checkout');
			var employee = $(this).data('employee');
			$('#edit_attendance').modal('show');
			$('#edit_id').val(id);
			$('#edit_employee').val(employee).trigger('change');
			$('#edit_checkin').val(checkin);
			$('#edit_checkout').val(checkout);
		});
	});
	</script>
@endsection