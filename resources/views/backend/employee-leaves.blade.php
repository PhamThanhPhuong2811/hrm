@extends('layouts.backend')

@section('styles')    
<!-- Select2 CSS -->
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">

<!-- Datatable CSS -->
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
@endsection

@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <h3 class="page-title">Nhân viên nghỉ phép</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Thống kê</a></li>
            <li class="breadcrumb-item active">Xin nghỉ phép</li>
        </ul>
    </div>
    <div class="col-auto float-right ml-auto">
        <a href="javascript:void(0)" class="btn add-btn" data-toggle="modal" data-target="#add_leave"><i class="fa fa-plus"></i> Thêm nhân viên nghỉ phép</a>
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
                            <th>Nhân viên xin nghỉ</th>
                            <th>Nghỉ từ</th>
                            <th>Nghỉ đến</th>
                            <th>Số lượng ngày nghỉ</th>
                            <th>Số ngày nghỉ cho phép còn lại</th>
                            <th>Mô tả</th>
                            <th class="text-center">Trạng thái</th>
                            <th>Lý do nghỉ phép</th>
                            <th class="text-right">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leaves as $leave)
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="javascript:void(0)" class="avatar avatar-xs">
                                            <img style="width: 30px; height: 30px;" alt="avatar" src="{{!empty($leave->employee->avatar)? asset('storage/employees/'.$leave->employee->avatar): asset('assets/img/user.jpg')}}">
                                        </a>
                                        <a href="#">{{$leave->employee->firstname}} {{$leave->employee->lastname}}</a>
                                    </h2>
                                </td>
                                <td>{{date_format(date_create($leave->from),"d/m/Y")}}</td>
                                <td>{{date_format(date_create($leave->to),"d/m/Y")}}</td>
                                <td>
                                    @php
                                        $start = new DateTime($leave->from);
                                        $end_date = new DateTime($leave->to);
                                    @endphp
                                    {{ ($start->diff($end_date)->days + 1) . ' ngày' }}
                                </td>
                                <td>
                                    @php
                                        // Tính số ngày nghỉ phép còn lại cho nhân viên (mặc định là 15 ngày)
                                        $remaining_leave_days = 15 - $leave->employee->used_leave_days;
                                    @endphp
                                    {{ $remaining_leave_days }} ngày
                                </td>
                                <td>{{substr($leave->reason,0,10).' ........'}}</td>
                                <td class="text-center">
                                    <div class="dropdown action-label">
                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-dot-circle-o @if ($leave->status === 'Chấp nhận') text-success @elseif($leave->status === 'Đang chờ') text-info @else text-danger @endif"></i>
                                            {{ $leave->status }}
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <form action="{{ route('employee-leave.update-status', ['id' => $leave->id]) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="id" value="{{ $leave->id }}">
                                                <button class="dropdown-item btn btn-small" style="font-size: 13.5px" type="submit" name="status" value="Chấp nhận">
                                                    <i class="fa fa-dot-circle-o text-success"></i> Chấp nhận
                                                </button>
                                                <button class="dropdown-item btn btn-small" style="font-size: 13.5px" type="submit" name="status" value="Từ chối">
                                                    <i class="fa fa-dot-circle-o text-danger"></i> Từ chối
                                                </button>
                                                <button class="dropdown-item btn btn-small" style="font-size: 13.5px" type="submit" name="status" value="Đang chờ">
                                                    <i class="fa fa-dot-circle-o text-info"></i> Đang chờ
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                                <td>{{$leave->leaveType->type}}</td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a data-id="{{$leave->id}}" data-from="{{$leave->from}}"
                                                data-to="{{$leave->to}}" data-employee="{{$leave->employee_id}}"
                                                data-leave_type="{{$leave->leave_type_id}}" data-status="{{$leave->status}}"
                                                data-reason="{{$leave->reason}}" class="dropdown-item editbtn" href="javascript:void(0)" data-toggle="modal" data-target="#edit_leave"><i class="fa fa-pencil m-r-5"></i> Chỉnh sửa</a>
                                            <a data-id="{{$leave->id}}" class="dropdown-item deletebtn" href="javascript:void(0)" data-toggle="modal" ><i class="fa fa-trash-o m-r-5"></i> Xóa</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach    
                        <!-- delete Leave Modal -->
                        <x-modals.delete :route="'leave.destroy'" :title="'nhân viên nghỉ phép'" />
                        <!-- /delete Leave Modal -->                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<!-- Add Leave Modal -->
<div id="add_leave" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm nhân viên nghỉ phép</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('employee-leave')}}">
                    @csrf

                    <div class="form-group">
                        <label>Nhân viên xin nghỉ <span class="text-danger">*</span></label>
                        <select name="employee" class="select">
                        <option value="null" disabled selected>Vui lòng lựa chọn nhân viên</option>
                            @foreach ($employees as $employee)
                                <option value="{{$employee->id}}">{{$employee->firstname}} {{$employee->lastname}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Lý do nghỉ phép <span class="text-danger">*</span></label>
                        <select name="leave_type" class="select">
                        <option value="null" disabled selected>Vui lòng lựa chọn lý do</option>
                            @foreach ($leave_types as $leave_type)
                                <option value="{{$leave_type->id}}">{{$leave_type->type}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nghỉ từ <span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input name="from" id="fromDate" class="form-control datetimepicker" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nghỉ đến <span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input name="to" id="toDate" class="form-control datetimepicker" type="text">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Mô tả <span class="text-danger">*</span></label>
                        <textarea name="reason" rows="4" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Trạng thái </label>
                        <select name="status" class="select">
                            <option value="null" disabled selected>Vui lòng lựa chọn trạng thái</option>
                            <option>Chấp nhận</option>
                            <option>Đang chờ</option>
                            <option>Từ chối</option>
                        </select>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Leave Modal -->

<!-- Edit Leave Modal -->
<div id="edit_leave" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa thông tin nhân viên nghỉ phép</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('employee-leave')}}" method="post">
                    @csrf
                    @method("PUT")
                    <input type="hidden" name="id" id="edit_id">
					<input type="hidden" name="employee" id="hidden_employee_id">
                    <div class="form-group">
                        <label>Nhân viên nghỉ phép<span class="text-danger">*</span></label>
                        <select name="employee" class="select2" id="edit_employee" disabled>
                            @foreach ($employees as $employee)
                                <option value="{{$employee->id}}">{{$employee->firstname.' '.$employee->lastname}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Lý do nghỉ phép <span class="text-danger">*</span></label>
                        <select name="leave_type" class="select2" id="edit_leave_type">
                            @foreach ($leave_types as $leave_type)
                                <option value="{{$leave_type->id}}">{{$leave_type->type}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Nghỉ từ <span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input name="from" class="form-control datetimepicker" type="text" id="edit_from">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nghỉ đến <span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input name="to" class="form-control datetimepicker" type="text" id="edit_to">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Mô tả <span class="text-danger">*</span></label>
                        <textarea name="reason" rows="4" class="form-control" id="edit_reason"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Trạng thái </label>
                        <select name="status" class="select2 form-control" id="edit_status">
                            <option value="null">Vui lòng lựa chọn</option>
                            <option>Chấp nhận</option>
                            <option>Đang chờ</option>
                            <option>Từ chối</option>
                        </select>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Edit Leave Modal -->
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
            var employee = $(this).data('employee');
            var leave_type = $(this).data('leave_type');
            var status = $(this).data('status');
            var from  = $(this).data('from');
            var to  = $(this).data('to');
            var reason = $(this).data('reason');
            
            $('#edit_leave').modal('show');
            $('#edit_id').val(id);
            $('#edit_employee').val(employee).trigger('change');
			$('#hidden_employee_id').val(employee)
            $('#edit_leave_type').val(leave_type).trigger('change');
            $('#edit_status').val(status).trigger('change');
            $('#edit_from').val(from);
            $('#edit_to').val(to);
            $('#edit_reason').val(reason);

            validateDates('#edit_from', '#edit_to');
        });

        validateDates('#fromDate', '#toDate');

        function validateDates(fromSelector, toSelector) {
            $(fromSelector).on('change', function() {
                var fromDate = new Date($(this).val());
                var toDate = new Date($(toSelector).val());

                if (toDate && (toDate <= fromDate || isNaN(toDate))) {
                    alert('Ngày kết thúc phải sau ngày bắt đầu. Vui lòng chọn lại.');
                    $(this).val('');
                    $(toSelector).val('');
                }
            });

            $(toSelector).on('change', function() {
                var toDate = new Date($(this).val());
                var fromDate = new Date($(fromSelector).val());

                if (fromDate && (toDate <= fromDate || isNaN(fromDate))) {
                    alert('Ngày kết thúc phải sau ngày bắt đầu. Vui lòng chọn lại.');
                    $(this).val('');
                    $(fromSelector).val('');
                }
            });
        }
    });
</script>
@endsection
