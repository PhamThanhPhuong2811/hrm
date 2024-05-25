@extends('layouts.backend')

@section('styles')
<!-- Select2 CSS -->
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">
  
@endsection

@section('page-header')
<div class="row align-items-center">
	<div class="col">
		<h3 class="page-title">{{ucwords($title)}}</h3>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Thống kê</a></li>
			<li class="breadcrumb-item active">Xem nhiệm vụ</li>
		</ul>
	</div>
</div>
@endsection


@section('content')
<div class="chat-main-row">
    <div class="chat-main-wrapper mt-4">
        <div class="col-lg-8 message-view task-view">
            <div class="chat-window">
                <div class="fixed-header">
                    <div class="navbar">
                        <div class="float-left ticket-view-details">
                            <div class="ticket-header">
                                
                                
                                <span class="m-l-15 text-muted">Khách hàng: </span>
                                <td>
                                    @if ($ticket->client)
                                        {{$ticket->client->firstname.' '.$ticket->client->lastname}}
                                    @else
                                        <span class="text-danger">Không có thông tin khách hàng</span>
                                    @endif
                                </td>                                   
                                <span class="m-l-15 text-muted">Ngày tạo: </span>
                                <span>{{date_format(date_create($ticket->created_at),'d/m/Y, H:i')}} </span> 
                                <span class="m-l-15 text-muted">Trạng thái: </span> <span class="badge badge-warning">{{$ticket->status}}</span>
                            </div>
                        </div>
                        <div class="task-assign">
                            <span class="assign-title">Nhân viên được phân công </span> 
                            @if (!empty($ticket->employee))
                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="{{$ticket->employee->firstname.' '.$ticket->employee->lastname}}" class="avatar">
                                <img src="{{!empty($ticket->employee->avatar) ? asset('storage/employees/'.$ticket->employee->avatar): asset('assets/img/profiles/avatar-19.jpg')}}" alt="avatar">
                            </a>
                            @endif
                        </div>

                    </div>
                </div>
                <div class="chat-contents">
                    <div class="chat-content-wrap">
                        <div class="chat-wrap-inner">
                            <div class="chat-box">
                                <div class="task-wrapper">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="project-title">
                                                <div class="m-b-20">
                                                    <span class="h5 card-title ">Tên nhiệm vụ: {{$ticket->subject}}</span>
                                                    <div class="float-right ticket-priority"><span>Ưu tiên:</span>
                                                        <div class="btn-group">
                                                            
                                                            @switch($ticket->priority)
                                                                @case('Cao')
                                                                     <a href="#" class="badge badge-danger dropdown-toggle" data-toggle="dropdown"> Cao </a>
                                                                    @break
                                                                @case('Trung bình')
                                                                    <a href="#"><i class="fa fa-dot-circle-o text-primary"></i> Vừa</a>
                                                                    @break
                                                                @case('Thấp')
                                                                    <a href="#"><i class="fa fa-dot-circle-o text-success"></i> Thấp</a>
                                                                    @break
                                                            @endswitch
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            Nội dung nhiệm vụ: {!! $ticket->description !!}
                                        </div>
                                    </div>
                                   
                                    <div class="card mb-0">
                                        <div class="card-body">
                                            <h5 class="card-title m-b-20">File đính kèm</h5>
                                            <ul class="files-list">
                                                @if (!empty($ticket->files)) 
                                                    @foreach ($ticket->files as $file) 
                                                        <li>
                                                            <div class="files-cont">
                                                                <div class="file-type">
                                                                    <span class="files-icon"><i class="fa fa-file-o"></i></span>
                                                                </div>
                                                                <div class="files-info">
                                                                    <span class="file-name text-ellipsis">
                                                                    <a href="#">{{$file}}</a></span>
                                                                    <div class="file-size">Size: {{is_file(asset('storage/tickets/'.$ticket->subject.'/'.$file)) ? \Storage::size(public_path('storage/tickets/'.$ticket->subject.'/'.$file)): ''}}</div>
                                                                </div>
                                                                <ul class="files-action">
                                                                    <li class="dropdown dropdown-action">
                                                                        <a href="" class="dropdown-toggle btn btn-link" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_horiz</i></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a class="dropdown-item" href="{{!empty($file) ? asset('storage/tickets/'.$ticket->subject.'/'.$file): '#'}}">Tải về</a>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                    @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
</div>

@endsection


@section('scripts')
<!-- Select2 JS -->
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>

@endsection