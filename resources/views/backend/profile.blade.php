@extends('layouts.backend')

@section('styles')
	
@endsection

@section('page-header')
<div class="row">
	<div class="col-sm-12">
		<h3 class="page-title">Thông tin cá nhân</h3>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Thống kê</a></li>
			<li class="breadcrumb-item active">Thông tin cá nhân</li>
		</ul>
	</div>
</div>
@endsection


@section('content')
<div class="card mb-0">
	<div class="card-body" style="height: 150px">
		<div class="row">
			<div class="col-md-12">
				<div class="profile-view">
					<div class="profile-img-wrap">
						<div class="profile-img">
							<a href="#"><img alt="avatar" src="{{!empty(auth()->user()->avatar) ? asset('storage/users/'.auth()->user()->avatar) : asset('assets/img/user.jpg') }}"></a>
						</div>
					</div>
					<div class="profile-basic">
						<div class="row">
							<div class="col-md-5">
								<div class="profile-info-left" style="margin-top: 15px">
									<h3 class="user-name m-t-0 mb-0">{{auth()->user()->name}}</h3>
									
								</div>
							</div>
							<div class="col-md-7">
								<ul class="personal-info">
									<li>
										<div class="title">Username:</div>
										<div class="text">{{auth()->user()->username}}</div>
									</li>
									<li>
										<div class="title">Email:</div>
										<div class="text">{{auth()->user()->email}}</div>
									</li>
									
								</ul>
								<div class="col-auto float-right ml-auto">
									<a href="{{route('change-password')}}" class="btn add-btn" >Cập nhật mật khẩu</a>
								</div>
							</div>
						</div>
					</div>
					<div class="pro-edit"><a data-target="#profile_info" data-toggle="modal" class="edit-icon" href="#"><i class="fa fa-pencil"></i></a></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Profile Modal -->
<div id="profile_info" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Thông tin cá nhân</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" enctype="multipart/form-data" action="{{route('profile')}}">
					@csrf
					<div class="row">
						<div class="col-md-12">
							<div class="profile-img-wrap edit-img">
								<img class="inline-block" src="{{!empty(auth()->user()->avatar) ? asset('storage/users/'.auth()->user()->avatar) : asset('assets/img/user.jpg') }}" alt="user">
								<div class="fileupload btn">
									<span class="btn-text">Chỉnh sửa </span>
									<input name="avatar" class="upload" type="file">
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Họ và tên </label>
										<input type="text" class="form-control" name="name" value="{{auth()->user()->name}}">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label> Username</label>
										<input type="text" class="form-control" name="username" value="{{auth()->user()->username}}">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label>Email</label>
										<input type="email" class="form-control" name="email" value="{{auth()->user()->email}}">
									</div>
								</div>
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
<!-- /Profile Modal -->
@endsection

@section('scripts')
	
@endsection
