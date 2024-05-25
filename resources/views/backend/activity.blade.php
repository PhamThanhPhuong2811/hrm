@extends('layouts.backend')

@section('styles')
	
@endsection

@section('page-header')
<div class="row">
	<div class="col-sm-12">
		<h3 class="page-title">Danh sách các hoạt động</h3>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Thống kê</a></li>
			<li class="breadcrumb-item active">Danh sách các hoạt động tháng này</li>
		</ul>
	</div>
</div>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="activity">
			<div class="activity-box">
				<ul class="activity-list">
					<li>
						<div class="activity-user">
							<a href="profile.html" title="Lesley Grauer" data-toggle="tooltip" class="avatar">
								<img src="assets/img/profiles/avatar-01.jpg" alt="">
							</a>
						</div>
						<div class="activity-content">
							<div class="timeline-content">
								<a href="profile.html" class="name">12/5</a> Thi cuối kì DLL <a href="#">Tại phòng H9.2</a>
								<span class="time">Đã ghi vào ngày 1/5</span>
							</div>
						</div>
					</li>
					<li>
						<div class="activity-user">
							<a href="profile.html" class="avatar" title="Jeffery Lalor" data-toggle="tooltip">
								<img src="assets/img/profiles/avatar-16.jpg" alt="">
							</a>
						</div>
						<div class="activity-content">
							<div class="timeline-content">
								<a href="profile.html" class="name">13/5</a> Thi cuối kì HDTNDN <a href="profile.html" class="name">Tại phòng X13.05</a>
								<span class="time">Đã ghi vào ngày 1/5</span>
							</div>
						</div>
					</li>
					<li>
						<div class="activity-user">
							<a href="profile.html" title="Catherine Manseau" data-toggle="tooltip" class="avatar">
								<img src="assets/img/profiles/avatar-08.jpg" alt="">
							</a>
						</div>
						<div class="activity-content">
							<div class="timeline-content">
								<a href="profile.html" class="name">23/5</a> Thi cuối kì QLDA <a href="#">Tại phòng V12.02</a>
								<span class="time">Đã ghi vào ngày 1/5</span>
							</div>
						</div>
					</li>
					<li>
						<div class="activity-user">
							<a href="#" title="Bernardo Galaviz" data-toggle="tooltip" class="avatar">
								<img src="assets/img/profiles/avatar-13.jpg" alt="">
							</a>
						</div>
						<div class="activity-content">
							<div class="timeline-content">
								<a href="profile.html" class="name">27/5</a> Báo cáo đồ án CNM <a href="#">Tại phòng A1.01B</a>
								<span class="time">Đã ghi vào ngày 1/5</span>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
@endsection


@section('scripts')
	
@endsection