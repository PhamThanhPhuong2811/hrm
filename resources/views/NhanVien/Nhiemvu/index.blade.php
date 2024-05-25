@extends('includes.NhanVien.backend')

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
			<li class="breadcrumb-item">Nhân viên</li>
			<li class="breadcrumb-item active">Danh sách nhiệm vụ</li>
		</ul>
	</div>
	
</div>
@endsection


@section('content')
<div class="row">
    
    @foreach ($tickets as $ticket)
    <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h4 class="ticket-title">Tên nhiệm vụ: <a href="{{route('Xemnhiemvu.show',$ticket->id)}}">{{$ticket->subject}}</a></h4>
                {{-- <div class="pro-deadline m-b-15">
                    <div class="sub-title">
                       Nội dung:
                    </div>
                    <span class="text-muted">
                         {!! substr($ticket->description,0,120).' ........'!!}
                    </span>
                </div> --}}
                <div class="pro-deadline m-b-15">
                    <div class="sub-title">
                        Ngày tạo:
                    </div>
                    <div class="text-muted">
                        {{date_format(date_create($ticket->created_at),"d/m/Y")}}
                    </div>
                </div>

                <div class="pro-deadline m-b-15">
                    <div class="sub-title">
                        Thuộc dự án:
                    </div>
                    <div class="text-muted">
                        {{ $ticket->project->name }}
                    </div>
                </div>

                 <div class="pro-deadline m-b-15">
                    <div class="sub-title">
                        Trạng thái:
                    </div>
                    <div class="text-muted">
                        {{$ticket->status}}
                    </div>
                </div>
                
                <p class="m-b-5">Tiến triển <span class="text-success float-end">{{$ticket->propress}}%</span></p>
                
                <div class="progress progress-xs mb-0">
                    <div class="progress-bar bg-success" role="progressbar" data-bs-toggle="tooltip" title="{{$ticket->propress}}%" style="width: {{$ticket->propress}}%"></div>
                </div><br>
                @php
                $qrcode_url = url('Xemnhiemvu/show/'.$ticket->id);
                @endphp
                <p class="qrcode_style">{{QrCode::size(50)->generate($qrcode_url)}}</p>
            </div>
        </div>
    </div>
    @endforeach            
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
                                <option value="null" disabled>-</option>
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
                                    <option value="high">Cao</option>
                                    <option value="medium">Vừa</option>
                                    <option value="low">Thấp</option>
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
                                <label>Nhân viên giám sát</label>
                                <select class="select2" multiple name="followers[]">
                                    <option value="null" disabled>-</option>
                                    @foreach (\App\Models\Employee::get() as $employee)
                                        <option value="{{$employee->id}}"> {{$employee->firstname.' '.$employee->lastname}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <select class="select" name="status">
                                    <option value="null" disabled>-</option>
                                    <option value="New">Mới</option>
                                    <option value="Open">Mở</option>
                                    <option value="Closed">Kết thúc</option>
                                    <option value="Reopen">Mở lại</option>
                                    <option value="OnHold">Giữ lại</option>
                                    <option value="InProgress">Đang thực hiện</option>
                                </select>
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Mã nhiệm vụ</label>
                                <input class="form-control" id="edit_tkid" name="ticket_id" type="text">
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
                                    <option value="high">Cao</option>
                                    <option value="medium">Vừa</option>
                                    <option value="low">Thấp</option>
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
                                <label>Nhân viên giám sát</label>
                                <select class="select" id="edit_followers" multiple name="followers[]">
                                    <option value="null" disabled>-</option>
                                    @foreach (\App\Models\Employee::get() as $employee)
                                        <option value="{{$employee->id}}"> {{$employee->firstname.' '.$employee->lastname}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <select class="select" id="edit_status" name="status">
                                    <option value="null" disabled>-</option>
                                    <option value="New">Mới</option>
                                    <option value="Open">Mở</option>
                                    <option value="Closed">Đóng</option>
                                    <option value="Reopen">Mở lại</option>
                                    <option value="OnHold">Giữ lại</option>
                                    <option value="InProgress">Đang thực hiện </option>
                                </select>
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

<x-modals.delete route="tickets" title="Ticket" />
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
            var tkid = $(this).data('tk_id');
            var employee = $(this).data('employee');
            var client = $(this).data('client');
            var followers = $(this).data('followers');
            var project = $(this).data('project');
            var description = $(this).data('description');
            var priority = $(this).data('priority');
            var status = $(this).data('status');
            $('#edit_ticket').modal('show');
            $('#edit_id').val(id);
            $('#edit_subject').val(subject);
            $('#edit_tkid').val(tkid);
            $('#edit_emp').val(employee).trigger('change');
            $('#edit_client').val(client).trigger('change');
            $('#edit_priority').val(priority).trigger('change');
            $('#edit_project').val(project).trigger('change');
            $('#edit_followers').val(followers).trigger('change');
            $('#edit_status').val(status).trigger('change');
            $('#edit_description').summernote('code', description);

        }));
    });
</script>
@endsection