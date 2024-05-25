@extends('layouts.backend')

@section('styles')	
<!-- Select2 CSS -->
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">
<!-- Datatable CSS -->
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<!-- Summernote CSS -->
<link rel="stylesheet" href="{{asset('assets/plugins/summernote/dist/summernote-bs4.css')}}">

@endsection

@section('page-header')
<div class="row align-items-center">
	<div class="col">
		<h3 class="page-title">Nhiệm vụ</h3>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Thống kê</a></li>
			<li class="breadcrumb-item active">Nhiệm vụ</li>
		</ul>
	</div>
	<div class="col-auto float-right ml-auto">
		<a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_ticket"><i class="fa fa-plus"></i> Thêm nhiệm vụ</a>
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
                        <th>STT</th>
                        <th>Tên nhiệm vụ</th>
                        <th>Nhân viên được phân công</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Ưu tiên</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                    @endphp
                    @foreach ($tickets as $ticket)
                    <tr>
                        <td>{{$count}}</td>
                       
                        <td><a href="{{route('ticket-view',$ticket->subject)}}">{{$ticket->subject}}</a></td>
                       
                        <td>
                            <h2 class="table-avatar">
                                <a class="avatar avatar-xs" href="#">
                                    <img alt="avatar"  src="{{!empty($ticket->employee->avatar) ? asset('storage/employees/'.$ticket->employee->avatar): asset('assets/img/profiles/avatar-19.jpg')}}"></a>
                                <a href="#">{{$ticket->employee->firstname.' '.$ticket->employee->lastname}}</a>
                            </h2>
                        </td>
                        <td>{{ date_format(date_create($ticket->start_date),'d/m/Y') }}</td>
                        <td>{{ date_format(date_create($ticket->end_date),'d/m/Y') }}</td>
                        <td>
                            {{ucfirst($ticket->priority)}}
                        </td>
                        <td class="text-center">
                            {{$ticket->status}}
                        </td>
                        <td class="text-end">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item editbtn" href="javascript:void(0)" data-id="{{$ticket->id}}" data-subject="{{$ticket->subject}}" data-employee="{{$ticket->employee_id}}" data-client="{{$ticket->client_id}}" data-project="{{$ticket->project_id}}"
                                         data-priority="{{$ticket->priority}}" data-status="{{$ticket->status}}" data-tk_id="{{$ticket->tk_id}}" 
                                         data-description="{{$ticket->description}}" data-start="{{$ticket->start_date}}" data-end="{{$ticket->end_date}}"
                                         data-followers="{{json_encode($ticket->followers)}}"><i class="fa fa-pencil m-r-5"></i> Chỉnh sửa</a>
                                    <a class="dropdown-item deletebtn" href="javascript:void(0)" data-id="{{$ticket->id}}"><i class="fa fa-trash-o m-r-5"></i> Xóa</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @php
                        $count++;
                    @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div> 

{{-- modals starts here  --}}

<!-- Add Ticket Modal -->
<div id="add_ticket" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm nhiệm vụ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('tickets')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tên nhiệm vụ</label>
                                <input class="form-control" name="subject" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                        <div class="form-group">
                            <label> Nhân viên được phân công</label>
                            <select class="select" name="staff" >
                                <option value="null" disabled selected>Vui lòng lựa chọn nhân viên</option>
                                @foreach (\App\Models\Employee::get() as $employee)
                                    <option value="{{$employee->id}}"> {{$employee->firstname.' '.$employee->lastname}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Ưu tiên</label>
                                <select class="select" name="priority">
                                    <option value="null" disabled selected>Vui lòng lựa chọn độ ưu tiên</option>
                                    <option value="Cao">Cao</option>
                                    <option value="Trung bình">Trung bình</option>
                                    <option value="Thấp">Thấp</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Dự án được phân công</label>
                                <select class="select" multiple name="project">
                                    <option value="null" disabled>-</option>
                                    @foreach (\App\Models\Project::get() as $project)
                                        <option value="{{$project->id}}"> {{$project->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                       
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Khách hàng</label>
                                <select class="select" name="client" required>
                                    <option value="" disabled selected>Vui lòng lựa chọn khách hàng</option>
                                    @foreach (\App\Models\Client::get() as $client)
                                        <option value="{{ $client->id }}">{{ $client->firstname . ' ' . $client->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <select class="select" name="status">
                                    <option value="null" disabled selected>Vui lòng lựa chọn trạng thái</option>
                                    <option value="Mới">Mới</option>
                                    <option value="Kết thúc">Kết thúc</option>
                                    <option value="Mở lại">Mở lại</option>
                                    <option value="Đang thực hiện">Đang thực hiện</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Ngày bắt đầu</label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" name="start_date">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Ngày kết thúc</label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" name="end_date" type="text">
                                </div>
                            </div>
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea class="form-control summernote" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>File đính kèm</label>
                                <input class="form-control" name="files[]" type="file">
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Ticket Modal -->

<!-- Edit Ticket Modal -->
<div id="edit_ticket" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa nhiệm vụ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('tickets')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="row">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tên nhiệm vụ</label>
                                <input class="form-control" id="edit_subject" name="subject" type="text">
                            </div>
                        </div>
                        {{-- <div class="col-sm-6">
                            <div class="form-group">
                                <label>Mã nhiệm vụ</label>
                                <input class="form-control" id="edit_tkid" name="ticket_id" type="text">
                            </div>
                        </div> --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <select class="select" id="edit_status" name="status">
                                    <option value="null" disabled>-</option>
                                    <option value="Mới">Mới</option>
                                    <option value="Kết thúc">Kết thúc</option>
                                    <option value="Mở lại">Mở lại</option>
                                    <option value="Đang thực hiện">Đang thực hiện </option>
                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nhân viên được phân công</label>
                                <select class="select" id="edit_emp" name="staff">
                                    <option value="null" disabled>-</option>
                                    @foreach (\App\Models\Employee::get() as $employee)
                                        <option value="{{$employee->id}}"> {{$employee->firstname.' '.$employee->lastname}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Khách hàng</label>
                                <select class="select" id="edit_client" name="client">
                                    <option value="null" disabled>-</option>
                                    @foreach (\App\Models\Client::get() as $client)
                                        <option value="{{$client->id}}">{{$client->firstname.' '.$client->lastname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Ưu tiên</label>
                                <select class="select" id="edit_priority" name="priority">
                                    <option value="Cao">Cao</option>
                                    <option value="Trung bình">Trung bình</option>
                                    <option value="Thấp">Thấp</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Dự án được phân công</label>
                                <select class="select" id="edit_project" name="project">
                                    <option value="null" disabled>-</option>
                                    @foreach (\App\Models\Project::get() as $project)
                                        <option value="{{$project->id}}">{{$project->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                        
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Ngày bắt đầu</label>
                                <div class="cal-icon">
                                    <input id="edit_startdate" class="form-control datetimepicker" type="text" name="start_date">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Ngày kết thúc</label>
                                <div class="cal-icon">
                                    <input id="edit_enddate" class="form-control datetimepicker" name="end_date" type="text">
                                </div>
                            </div>
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea class="form-control summernote" id="edit_description" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Files đính kèm</label>
                                <input class="form-control" name="files[]" type="file">
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Edit Ticket Modal -->

<x-modals.delete route="tickets" title="Nhiệm vụ" />
{{-- modals ends here  --}}
@endsection

@section('scripts')
<!-- Datatable JS -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<!-- Select2 JS -->
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<!-- summernote JS -->
<script src="{{asset('assets/plugins/summernote/dist/summernote-bs4.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $('.table').on('click','.editbtn',(function(){
            var id = $(this).data('id');
            var subject = $(this).data('subject');
            // var tkid = $(this).data('tk_id');
            var employee = $(this).data('employee');
            var client = $(this).data('client');
            // var followers = $(this).data('followers');
            var project = $(this).data('project');
            var description = $(this).data('description');
            var priority = $(this).data('priority');
            var status = $(this).data('status');
            var startdate = $(this).data('start');
            var enddate = $(this).data('end');

            $('#edit_ticket').modal('show');
            $('#edit_id').val(id);
            $('#edit_subject').val(subject);
            // $('#edit_tkid').val(tkid);
            $('#edit_emp').val(employee).trigger('change');
            $('#edit_client').val(client).trigger('change');
            $('#edit_priority').val(priority).trigger('change');
            $('#edit_project').val(project).trigger('change');
            // $('#edit_followers').val(followers).trigger('change');
            $('#edit_status').val(status).trigger('change');
            $('#edit_description').summernote('code', description);
            $('#edit_startdate').val(startdate);
            $('#edit_enddate').val(enddate);
        }));
    });
</script>
@endsection