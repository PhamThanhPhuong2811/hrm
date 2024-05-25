@extends('layouts.backend')

@section('styles')
<!-- Select2 CSS -->
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
<!-- Datatable CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <h3 class="page-title">Chấm công nhân viên</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Thống kê</a></li>
            <li class="breadcrumb-item active">Chấm công</li>
        </ul>
    </div>
    <div class="col-auto float-right ml-auto">
        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_attendance"><i class="fa fa-plus"></i> Thêm phiếu chấm công</a>
    </div>
</div>
@endsection

@section('content')
<div class="row">
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
                        <th>Số lần đi trễ/ tháng</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendances as $attendance)
                    <tr>
                        <td>
                            <h2 class="table-avatar">
                                <a href="#" class="avatar">
                                    <img style="width: 40px; height: 40px;" alt="avatar" src="{{ !empty($attendance->employee->avatar) ? asset('storage/employees/' . $attendance->employee->avatar) : asset('assets/img/profiles/avatar-19.jpg') }}">
                                </a>
                                <a href="#">
                                    {{ $attendance->employee->firstname . ' ' . $attendance->employee->lastname }}
                                    <span>{{ $attendance->employee->designation->name }}</span>
                                </a>
                            </h2>
                        </td>
                        <td>{{ date_format(date_create($attendance->checkin), 'H:i a') }}</td>
                        <td>{{ !empty($attendance->checkout) ? date_format(date_create($attendance->checkout), 'H:i a') : ' ' }}</td>
                        <td>{{ date_format(date_create($attendance->created_at), 'd/m/Y') }}</td>
                        <td>{{ $attendance->status }}</td>
                        <td>{{ \App\Models\LateCount::where('employee_id', $attendance->employee_id)->where('month', date('m'))->where('year', date('Y'))->value('late_count') ?? 0 }}</td>
                        <td class="text-end">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item editbtn" href="javascript:void(0)" data-id="{{ $attendance->id }}" data-checkin="{{ $attendance->checkin }}" data-checkout="{{ $attendance->checkout }}" data-employee="{{ $attendance->employee_id }}"><i class="fa fa-pencil m-r-5"></i> Chỉnh sửa</a>
                                    <a class="dropdown-item deletebtn" href="javascript:void(0)" data-id="{{ $attendance->id }}"><i class="fa fa-trash-o m-r-5"></i> Xóa</a>
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

<x-modals.delete route="employees.attendance" title="Phiếu chấm công"/>

<!-- Add Attendance Modal -->
<div class="modal custom-modal fade" id="add_attendance" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm chấm công </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('employees.attendance') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Nhân viên</label>
                        <select name="employee" class="select2">
                            <option value="null">Lựa chọn nhân viên</option>
                            @foreach (\App\Models\Employee::get() as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->firstname . ' ' . $employee->lastname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Thời gian vào <span class="text-danger">*</span></label>
                        <input type="time" name="checkin" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Thời gian ra <span class="text-danger">*</span></label>
                        <input name="checkout" class="form-control" type="time">
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Attendance Modal -->

<!-- Edit Attendance Modal -->
<div class="modal custom-modal fade" id="edit_attendance" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa phiếu chấm công</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('employees.attendance') }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit_id">
                    <div class="form-group">
                        <label>Nhân viên</label>
                        <input type="hidden" name="employee" id="edit_employee_hidden">
                        <select name="employee" id="edit_employee" class="select2" disabled>
                            <option value="null">Lựa chọn nhân viên</option>
                            @foreach (\App\Models\Employee::get() as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->firstname . ' ' . $employee->lastname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Thời gian vào <span class="text-danger">*</span></label>
                        <input type="time" name="checkin" id="edit_checkin" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Thời gian ra <span class="text-danger">*</span></label>
                        <input name="checkout" id="edit_checkout" class="form-control" type="time">
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Edit Attendance Modal -->

@endsection

@section('scripts')
<!-- Select2 JS -->
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<!-- Datatable JS -->
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
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
            $('#edit_employee_hidden').val(employee); // hidden input để giữ giá trị employee_id
            $('#edit_checkin').val(checkin);
            $('#edit_checkout').val(checkout);
        });
    });
</script>
@endsection
