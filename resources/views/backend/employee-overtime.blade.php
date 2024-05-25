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
        <h3 class="page-title">Nhân viên làm thêm giờ</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Thống kê</a></li>
            <li class="breadcrumb-item active">Làm thêm giờ</li>
        </ul>
    </div>
    <div class="col-auto float-right ml-auto">
        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_overtime"><i class="fa fa-plus"></i> Thêm nhân viên làm thêm</a>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <div class="col-md-7">
                <form action="{{ route('overtimes.filter') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Chọn tháng</label>
                                <select class="form-control select2" name="month">
                                    @for ($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}" {{ (isset($currentMonth) && $currentMonth == $m) ? 'selected' : '' }}>{{ $m }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Chọn năm</label>
                                <select class="form-control select2" name="year">
                                    @for ($y = 2024; $y <= Carbon\Carbon::now()->year; $y++)
                                        <option value="{{ $y }}" {{ (isset($currentYear) && $currentYear == $y) ? 'selected' : '' }}>{{ $y }}</option>
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
            <table class="table table-striped custom-table mb-0 datatable">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Nhân viên</th>
                        <th>Ngày làm thêm giờ</th>
                        <th class="text-center">Số giờ làm thêm</th>
                        <th>Số tiền tăng ca</th>
                        <th>Tổng tiền tăng ca tháng này</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                    @endphp
                    @foreach ($overtimes as $overtime)
                    <tr>
                        <td>{{$count}}</td>
                        <td>
                            <h2 class="table-avatar blue-link">
                                <a href="javascript:void(0)" class="avatar"><img style="width: 40px; height: 40px;" alt="avatar" src="{{ !empty($overtime->employee->avatar) ? asset('storage/employees/'.$overtime->employee->avatar): asset('assets/img/user.jpg') }}"></a>
                                <a href="javascript:void(0)">{{ !empty($overtime->employee) ? $overtime->employee->firstname.' '.$overtime->employee->lastname: ' '}}</a>
                            </h2>
                        </td>
                        <td>{{date_format(date_create($overtime->overtime_date),'d/m/Y')}}</td>
                        <td class="text-center">{{$overtime->hours}}</td>
                        <td>{{ number_format($overtime->earnings, 0, ',', '.') }} VND</td>
                        <td>
                            {{ number_format($totalEarningsByEmployee[$overtime->employee_id] ?? 0, 0, ',', '.') }} VND
                        </td>
                        <td class="text-end">
                            <div class="dropdown dropdown-action">
                                <a href="javascript:void(0)" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item editbtn" href="javascript:void(0)" data-id="{{$overtime->id}}"
                                    data-employee="{{$overtime->employee_id}}" data-date="{{$overtime->overtime_date}}" data-hours="{{$overtime->hours}}"
                                    data-description="{{$overtime->description}}"
                                    ><i class="fa fa-pencil m-r-5"></i> Chỉnh sửa</a>
                                    <a class="dropdown-item deletebtn" data-id="{{$overtime->id}}" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Xóa</a>
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
</div>
<!-- /Page Content -->

<!-- Add Overtime Modal -->
<div id="add_overtime" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm nhân viên làm thêm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('overtime')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Lựa chọn nhân viên <span class="text-danger">*</span></label>
                        <select class="select2" name="employee">
                            <option value="null">Vui lòng lựa chọn nhân viên</option>
                            @foreach (\App\Models\Employee::get() as $employee)
                                <option value="{{$employee->id}}">{{$employee->firstname.' '.$employee->lastname}} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Ngày làm thêm giờ <span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input class="form-control datetimepicker" name="date" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Số giờ làm thêm <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="hours">
                    </div>
                    <div class="form-group">
                        <label>Mô tả </label>
                        <textarea rows="4" class="form-control" name="description"></textarea>
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Overtime Modal -->

<!-- Edit Overtime Modal -->
<div id="edit_overtime" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa thông tin nhân viên làm thêm giờ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('overtime')}}" method="post">
                    @csrf
                    @method("PUT")
                    <input type="hidden" name="id" id="edit_id">
                    <!-- Input ẩn để lưu giá trị ID nhân viên -->
                    <input type="hidden" name="employee_id" id="hidden_employee_id">
                    <div class="form-group">
                        <label>Lựa chọn nhân viên <span class="text-danger">*</span></label>
                        <select class="select" id="edit_employee" name="employee" disabled>
                            <option>-</option>
                            @foreach (\App\Models\Employee::get() as $employee)
                                <option value="{{$employee->id}}">{{$employee->firstname.' '.$employee->lastname}} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Ngày làm thêm giờ <span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input class="form-control datetimepicker" name="date" id="edit_date" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Số giờ làm thêm <span class="text-danger">*</span></label>
                        <input class="form-control" name="hours" id="edit_hours" type="text">
                    </div>
                    <div class="form-group">
                        <label>Mô tả <span class="text-danger">*</span></label>
                        <textarea rows="4" class="form-control" id="edit_description" name="description"></textarea>
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- /Edit Overtime Modal -->

<x-modals.delete route="overtime" title="nhân viên làm thêm" />

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
        var date = $(this).data('date');
        var hours = $(this).data('hours');
        var description = $(this).data('description');

        $('#edit_overtime').modal('show');
        $('#edit_id').val(id);
        $('#hidden_employee_id').val(employee); // Gán giá trị cho input ẩn
        $('#edit_employee').val(employee).trigger('change');
        $('#edit_date').val(date);
        $('#edit_hours').val(hours);
        $('#edit_description').val(description);
    });
});

</script>
    
@endsection
