@extends('layouts.backend')


@section('styles')	
<!-- Datatable CSS -->
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
@endsection


@section('page-header')
<div class="row align-items-center">
	<div class="col">
		<h3 class="page-title">Danh sách người dùng</h3>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Thống kê</a></li>
			<li class="breadcrumb-item active">Người dùng </li>
		</ul>
	</div>
	<div class="col-auto float-right ml-auto">
		<a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_user"><i class="fa fa-plus"></i> Thêm người dùng</a>
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
						<th>Họ và tên</th>
						<th>Tên tài khoản</th>
						<th>Phân quyền</th>
						<th>Email</th>
						<th>Ngày tạo</th>
						<th>Mã nhân viên</th> <!-- Thêm cột hiển thị employee_id -->
						<th class="text-right">Hành động</th>
					</tr>
				</thead>
				<tbody>

					@foreach ($users as $user)
					<tr>
						<td>
							<h2 class="table-avatar">
								<a href="javascript:void(0)" class="avatar"><img width="38px" height="38px" src="{{!empty(auth()->user()->avatar) ? asset('storage/users/'.$user->avatar) : asset('assets/img/haha.jpg') }}" ></a>
								{{$user->name}}
							</h2>
						</td>
						<td>{{$user->username}}</td>
						<td>
							@if($user->role == 0)
								Admin
							@else
								Nhân viên
							@endif
						</td>
						<td>{{$user->email}}</td>
						<td>{{date_format(date_create($user->created_at),'d/m/Y')}}</td>
						<td>{{$user->employee->uuid ?? 'N/A'}}</td> <!-- Hiển thị employee_id nếu có -->
						<td class="text-right">
							<div class="dropdown dropdown-action">
								<a href="javascript:void(0)" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
								<div class="dropdown-menu dropdown-menu-right">
									<a data-id="{{$user->id}}" data-name="{{$user->name}}" data-username="{{$user->username}}" data-email="{{$user->email}}" data-gender="{{$user->gender}}" data-role="{{$user->role}}" class="dropdown-item editbtn" href="javascript:void(0)" data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Chỉnh sửa</a>
									<a data-id="{{$user->id}}" class="dropdown-item deletebtn" href="javascript:void(0)" data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Xóa</a>
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
<!-- Add User Modal -->
<!-- Add User Modal -->
<div id="add_user" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm người dùng </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" method="post" action="{{route('users')}}">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Họ và tên <span class="text-danger">*</span></label>
                                <input class="form-control" name="name" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Avt</label>
                                <input class="form-control" name="avatar" type="file">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tên tài khoản <span class="text-danger">*</span></label>
                                <input class="form-control" name="username" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input class="form-control" name="email" type="email">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Quyền</label>
                                <select class="select" name="role">
                                    <option value="null" disabled selected>Vui lòng lựa chọn quyền</option>
                                    <option value="0">Admin</option>
                                    <option value="1">Nhân viên</option>
                                </select>
                            </div>
                        </div>
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Mật khẩu</label>
                                <input class="form-control" name="password" type="password">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Xác nhận lại mật khẩu vừa tạo</label>
                                <input class="form-control" name="password_confirmation" type="password">
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
<!-- /Add User Modal -->


<!-- Edit User Modal -->
<!-- Edit User Modal -->
<div id="edit_user" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa thông tin người dùng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" action="{{route('users')}}">
                    @csrf
                    @method("PUT")
                    <div class="row">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Họ và tên <span class="text-danger">*</span></label>
                                <input class="form-control edit_name" name="name" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Avt</label>
                                <input class="form-control edit_avatar" name="avatar" type="file">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tên tài khoản <span class="text-danger">*</span></label>
                                <input class="form-control edit_username" name="username" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input class="form-control edit_email" name="email" type="email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Giới tính <span class="text-danger">*</span></label>
                                <select name="gender" class="select edit_gender">
                                    <option value="null" disabled selected>Vui lòng lựa chọn giới tính</option>
                                    <option value="Nam">Nam</option>
                                    <option value="Nữ">Nữ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quyền</label>
                                <select class="select edit_role" name="role">
                                    <option value="null" disabled selected>Vui lòng lựa chọn quyền</option>
                                    <option value="0">Admin</option>
                                    <option value="1">Nhân viên</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Mật khẩu</label>
                                <input class="form-control edit_password" name="password" type="password">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Xác nhận lại mật khẩu</label>
                                <input class="form-control edit_password" name="password_confirmation" type="password">
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
<!-- /Edit User Modal -->

<!-- /Edit User Modal -->
<x-modals.delete :route="'users'" :title="'Người dùng'" />
@endsection


@section('scripts')
	<!-- Datatable JS -->
	<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
	<script>
		$(document).ready(function(){
			$('.table').on('click', '.editbtn', function(){
				$('#edit_user').modal('show');
				var id = $(this).data('id');
				var name = $(this).data('name');
				var username = $(this).data('username');
				var email = $(this).data('email');
				var gender = $(this).data('gender');
				var role = $(this).data('role');
	
				$('#edit_id').val(id);
				$('.edit_name').val(name);
				$('.edit_username').val(username);
				$('.edit_email').val(email);
				$('.edit_gender').val(gender); // Đặt giá trị cho select giới tính
				$('.edit_role').val(role); // Đặt giá trị cho select quyền
	
				// Đặt giá trị cho select giới tính
				$('.edit_gender').val(gender).change();
				// Đặt giá trị cho select quyền
				$('.edit_role').val(role).change();
			});
		});
	</script>
	
@endsection	


