@extends('layouts.backend')

@section('styles')
<!-- Datatable CSS -->
<link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">
@endsection

@section('page-header')
<div class="row align-items-center">
	<div class="col">
		<h3 class="page-title">Nhân viên</h3>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Thống kê</a></li>
			<li class="breadcrumb-item active">Nhân viên</li>
		</ul>
	</div>
	<div class="col-auto float-right ml-auto">
		<a href="javascript:void(0)" class="btn add-btn" data-toggle="modal" data-target="#add_employee"><i class="fa fa-plus"></i> Thêm nhân viên</a>
		<div class="view-icons">
			<a href="{{route('employees')}}" class="grid-view btn btn-link {{route_is(['employees','employees-list']) ? 'active' : ''}}"><i class="fa fa-th"></i></a>
			<a href="{{route('employees-list')}}" class="list-view btn btn-link {{route_is(['employees','employees-list']) ? 'active' : '' }}"><i class="fa fa-bars"></i></a>
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
						<th>Tên</th>
						<th>Mã nhân viên</th>
						<th>Email</th>
						<th>SĐT</th>
						<th class="text-nowrap">Ngày bắt đầu công việc</th>
						<th>Chức vụ</th>
						<th>Giới tính</th>
						<th>Học vấn</th>
						<th class="text-right no-sort">Hành động</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($employees as $employee)
					<tr>
						<td>
							<h2 class="table-avatar">
								<a href="javascript:void(0)" class="avatar"><img style="height: 40px;width: 40px" alt="avatar" src="@if(!empty($employee->avatar)) {{asset('storage/employees/'.$employee->avatar)}} @else assets/img/profiles/default.jpg @endif"></a>
								<a href="javascript:void(0)">{{$employee->firstname}} {{$employee->lastname}}</a>
							</h2>
						</td>
						<td>{{$employee->uuid}}</td>
						<td>{{$employee->email}}</td>
						<td>{{$employee->phone}}</td>
						<td class="text-center">{{$employee->start_date}}</td>
						<td>
							{{$employee->designation->name}}
						</td>
						<td class="text-center">
							{{$employee->gender}}
						</td>
						<td>
							{{$employee->education}}
						</td>
						<td class="text-right">
							<div class="dropdown dropdown-action">
								<a href="javascript:void(0)" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
								<div class="dropdown-menu dropdown-menu-right">
									<a data-id="{{$employee->id}}" data-firstname="{{$employee->firstname}}" data-lastname="{{$employee->lastname}}" data-email="{{$employee->email}}" data-phone="{{$employee->phone}}" data-start="{{$employee->start_date}}" data-avatar="{{$employee->avatar}}"  data-designation="{{$employee->designation_id}}" data-department="{{$employee->department_id}}" data-gender="{{$employee->gender}}" data-education="{{$employee->education}}" class="dropdown-item editbtn" href="javascript:void(0)" data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Chỉnh sửa</a>
									<a data-id="{{$employee->id}}" class="dropdown-item deletebtn" href="javascript:void(0)" data-toggle="modal" ><i class="fa fa-trash-o m-r-5"></i> Xóa</a>
								</div>
							</div>
						</td>
					</tr>
					@endforeach
					<x-modals.delete :route="'employee.destroy'" :title="'nhân viên'" />
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Add Employee Modal -->
<div id="add_employee" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Thêm nhân viên</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" action="{{route('employee.add')}}" enctype="multipart/form-data">
					@csrf
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Họ <span class="text-danger">*</span></label>
								<input class="form-control" name="firstname" type="text">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Tên <span class="text-danger">*</span></label>
								<input class="form-control" name="lastname" type="text">
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Email <span class="text-danger">*</span></label>
								<input class="form-control" name="email" type="email">
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">SĐT <span class="text-danger">*</span></label>
								<input class="form-control" name="phone" type="text">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Ngày bắt đầu công việc <span class="text-danger">*</span></label>
								<div class="cal-icon"><input type="text" class="form-control datetimepicker" name="start_date"></div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Phòng ban <span class="text-danger">*</span></label>
								<select class="select" name="department" title="Select Department">
									<option value="null" disabled selected>Vui lòng lựa chọn phòng ban</option>
									@if(!empty($departments->count()))
									@foreach($departments as $department)
										<option value="{{$department->id}}">{{$department->name}}</option>
									@endforeach
									@endif
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Chức vụ <span class="text-danger">*</span></label>
								<select class="select" name="designation" title="Select Designation">
									<option value="null" disabled selected>Vui lòng lựa chọn chức vụ</option>
									@if(!empty($designations->count()))
									@foreach($designations as $designation)
										<option value="{{$designation->id}}">{{$designation->name}}</option>
									@endforeach
									@endif
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label">Ảnh thẻ<span class="text-danger">*</span></label>
								<input class="form-control floating" name="avatar" type="file">
							</div>
						</div>
						 {{-- Thêm ngày 25/4 --}}
						<div class="col-md-6">
							<div class="form-group">
								<label>Giới tính <span class="text-danger">*</span></label>
								<select name="gender" class="select">
									<option value="null" disabled selected>Vui lòng lựa chọn giới tính</option>
									<option value="Nam">Nam</option>
									<option value="Nữ">Nữ</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Học vấn <span class="text-danger">*</span></label>
								<select name="education" class="select">
									<option value="null" disabled selected>Vui lòng lựa chọn học vấn</option>
									<option value="Đại học">Đại học</option>
									<option value="Trung cấp">Trung cấp</option>
									<option value="Cao đẳng">Cao đẳng</option>
								</select>
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
<!-- /Add Employee Modal -->
<!-- Edit Employee Modal -->
<!-- Edit Employee Modal -->
<div id="edit_employee" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa thông tin nhân viên</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('employee.update')}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Họ <span class="text-danger">*</span></label>
                                <input class="form-control edit_firstname" name="firstname" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Tên</label>
                                <input class="form-control edit_lastname" name="lastname" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                <input class="form-control edit_email" name="email" type="email">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">SĐT </label>
                                <input class="form-control edit_phone" name="phone" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Ngày bắt đầu công việc</label>
                                <input type="text" class="form-control datetimepicker edit_date" name="start_date">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phòng ban <span class="text-danger">*</span></label>
                                <select name="department" class="form-control edit_department">
                                    @foreach ($departments as $department)
                                        <option value="{{$department->id}}">{{$department->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Chức vụ <span class="text-danger">*</span></label>
                                <select name="designation" class="form-control edit_designation">
                                    @foreach ($designations as $designation)
                                        <option value="{{$designation->id}}">{{$designation->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Giới tính <span class="text-danger">*</span></label>
                                <select name="gender" class="select2 form-control" id="edit_gender">
                                    <option value="Nam">Nam</option>
                                    <option value="Nữ">Nữ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Học vấn <span class="text-danger">*</span></label>
                                <select name="education" class="select2 form-control" id="edit_education">
                                    <option value="Đại học">Đại học</option>
                                    <option value="Trung cấp">Trung cấp</option>
                                    <option value="Cao đẳng">Cao đẳng</option>
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">Tên tệp ảnh hiện tại</label>
                                <input class="form-control edit_avatar_display" type="text" readonly>
                            </div>
                        </div> --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">Cập nhật ảnh đại diện</label>
                                <input class="form-control" id="edit_avatar" name="avatar" type="file">
                                <small class="form-text text-muted" id="current_avatar_text"></small>
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
<!-- /Edit Employee Modal -->

<!-- /Edit Employee Modal -->

@endsection

@section('scripts')
<!-- Datatable JS -->
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('.editbtn').on('click', function () {
            $('#edit_employee').modal('show');

            var id = $(this).data('id');
            var firstname = $(this).data('firstname');
            var lastname = $(this).data('lastname');
            var email = $(this).data('email');
            var phone = $(this).data('phone');
            var avatar = $(this).data('avatar');
            var start = $(this).data('start');
            var designation = $(this).data('designation');
            var department = $(this).data('department');
            var gender = $(this).data('gender');
            var education = $(this).data('education');

            $('#edit_id').val(id);
            $('.edit_firstname').val(firstname);
            $('.edit_lastname').val(lastname);
            $('.edit_email').val(email);
            $('.edit_phone').val(phone);
            $('.edit_date').val(start);
            $('.edit_designation').val(designation);
            $('.edit_department').val(department);
            $('#edit_gender').val(gender).trigger('change');
            $('#edit_education').val(education).trigger('change');

            // Hiển thị tên tệp ảnh đại diện hiện tại
            if (avatar) {
                $('#current_avatar_text').text('Tệp hiện tại: ' + avatar);
            } else {
                $('#current_avatar_text').text('No file chosen');
            }
        });

        // Cập nhật tên tệp khi người dùng chọn tệp mới
        $('#edit_avatar').on('change', function () {
            var fileName = $(this).val().split('\\').pop();
            if (fileName) {
                $('#current_avatar_text').text('Tệp mới: ' + fileName);
            } else {
                $('#current_avatar_text').text('No file chosen');
            }
        });
    });
</script>



@endsection
