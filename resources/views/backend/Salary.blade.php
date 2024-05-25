@extends('layouts.backend')


@section('styles')
<!-- Datatable CSS -->
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">

@endsection



@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <h3 class="page-title">Danh sách lương</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Thống kê</a></li>
            <li class="breadcrumb-item active">Danh sách lương</li>
        </ul>
    </div>
    <div class="col-auto float-right ml-auto">
        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_salary"><i class="fa fa-plus"></i> Thêm lương</a>
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
                        <th>Nhân viên</th>
                        <th>Chức vụ</th>
                        <th>Lương cơ bản</th>
                        <th>Phụ cấp</th>
                        <th>Trễ | Thành tiền</th>
                        <th>Nghỉ | Thành tiền</th>
                        <th>Tổng</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($salarys as $salary)
                        <tr>
                            <td>
                                <h2 class="table-avatar">
                                    <a href="javascript:void(0)" class="avatar avatar-xs">
                                        <img style="width: 25px; height: 25px;" alt="avatar" src="{{!empty($salary->employee->avatar) ? asset('storage/employees/'.$salary->employee->avatar) : asset('assets/img/user.jpg')}}">
                                    </a>
                                    <a href="#">{{$salary->employee->firstname}} {{$salary->employee->lastname}}</a>
                                </h2>
                            </td>
                            <td>
                                {{ $salary->employee->designation->name }}
                            </td>
                            
                            <td>
                                {{ number_format($salary_basic, 0, '.', '.') }} VND
                            </td>
                            <td>
                                {{ number_format($salary->phucap, 0, '.', '.') }} VND
                            </td>
                            <td>
                                @php
                                    $tienTre = isset($salary->tre) ? $salary->tre * 50000 : 0;
                                @endphp    
                                {{ $salary->tre }} lần | @if(isset($salary->tre))
                                    {{ number_format($tienTre, 0, '.', '.') }} VND
                                @else
                                    0 VND
                                @endif
                            </td>
                            <td>
                                @php
                                    $tienNghi = isset($salary->nghi) ? $salary->nghi * 150000 : 0;
                                @endphp
                                {{ $salary->nghi }} ngày | @if(isset($salary->nghi))
                                    {{ number_format($tienNghi, 0, '.', '.') }} VND
                                @else
                                    0 VND
                                @endif
                            </td>
                            <td>
                                @if(is_numeric($salary_basic) && is_numeric($salary->phucap) && is_numeric($tienTre) && is_numeric($tienNghi))
                                    @php
                                        $tong = $salary_basic + $salary->phucap - $tienTre - $tienNghi;
                                    @endphp
                                    {{ number_format($tong, 0, '.', '.') }} VND
                                @endif
                            </td>
                            


                            <td class="text-center">
                                <div class="dropdown action-label">
                                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa fa-dot-circle-o @if ($salary->status === 'Đã thanh toán') text-success @else text-danger @endif"></i>
                                        {{ $salary->status }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <form action="{{ route('salary.update-status', ['id' => $salary->id]) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="id" value="{{ $salary->id }}">
                                            <button class="dropdown-item btn btn-small" style="font-size: 13.5px" type="submit" name="status" value="Đã thanh toán">
                                                <i class="fa fa-dot-circle-o text-success"></i> Đã thanh toán
                                            </button>
                                            <button class="dropdown-item btn btn-small" style="font-size: 13.5px" type="submit" name="status" value="Chưa thanh toán">
                                                <i class="fa fa-dot-circle-o text-danger"></i> Chưa thanh toán
                                            </button>
                                        </form>
                                        
                                    </div>
                                </div>
                            </td>
                            <td class="text-right">
                                <div class="dropdown dropdown-action">
                                    <a href="javascript:void(0)" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a data-id="{{$salary->id}}" 
                                            data-employee="{{$salary->employee_id}}" 
                                            data-designation="{{$salary->designation_id}}" 
                                            data-phucap="{{$salary->phucap}}"
                                            data-tre="{{$salary->tre}}" 
                                            data-nghi="{{$salary->nghi}}" 
                                            data-status="{{$salary->status}}" 
                                            class="dropdown-item editbtn" 
                                            href="javascript:void(0)" 
                                            data-toggle="modal">
                                            <i class="fa fa-pencil m-r-5"></i> Chỉnh sửa
                                         </a>
                                         
										<a data-id="{{$salary->id}}" class="dropdown-item deletebtn" href="javascript:void(0)" data-toggle="modal" ><i class="fa fa-trash-o m-r-5"></i> Xóa</a>
										</div>
									</div>
							</td>
                        </tr>
                        @endforeach
                        <!-- delete Leave Modal -->
						<x-modals.delete :route="'salary.destroy'" :title="'lương nhân viên'" />
						<!-- /delete Leave Modal -->
                </tbody>
              
            </table>
        </div>
    </div>
</div>
<!--Them modal them luong cho nhan vien-->
<!-- Thêm modal thêm lương cho nhân viên -->
<div id="add_salary" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                 <h5 class="modal-title">Thêm lương cho nhân viên</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
         </div>
         <div class="modal-body">
             <form method="POST" action="{{route('salary')}}" >
             @csrf
             <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                       <label>Nhân viên <span class="text-danger">*</span></label><br>
                       <select name="employee" class="select">
                       <option value="null" disabled selected>Vui lòng lựa chọn nhân viên</option>
                           @foreach ($employees as $employee)
                               <option value="{{$employee->id}}">{{$employee->firstname}} {{$employee->lastname}}</option>
                           @endforeach
                       </select>
                   </div>
               </div>
                   <!-- Loại bỏ trường chọn chức vụ -->
                   <!-- <div class="col-sm-12">
                       <div class="form-group">
                           <label>Chức vụ <span class="text-danger">*</span></label>
                           <select name="designation" class="select">
                               <option>Lựa chọn chức vụ</option>
                               @foreach ($designations as $designation)
                                   <option value="{{$designation->id}}">{{$designation->name}}</option>
                               @endforeach
                           </select>
                       </div>
                   </div> -->
                       <div class="col-sm-12">
                           <div class="form-group">
                               <label class="col-form-label">Phụ cấp <span class="text-danger">*</span></label>
                               <input class="form-control" name="phucap" type="text">
                           </div>  
                       </div>
                       <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label">Số ngày đi trễ <span class="text-danger">*</span></label>
                            <input class="form-control" name="ditre" type="text">
                        </div>  
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label">Số ngày nghỉ <span class="text-danger">*</span></label>
                            <input class="form-control" name="ngaynghi" type="text">
                        </div>  
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Trạng thái </label>
                            <select name="status" class="select">
                                <option value="null" disabled selected>Vui lòng lựa chọn trạng thái</option>
                                <option>Đã thanh toán</option>
                                <option>Chưa thanh toán</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-sm-12">
					<div class="submit-section">
						<button class="btn btn-primary submit-btn">Thêm</button>
					</div>
                    </div>
             </div>
            </form>
        </div>
    </div>
</div>



<!-- Edit Salary Modal -->
<!-- Edit Salary Modal -->
<div id="edit_salary" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa thông tin lương</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('salary') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nhân viên <span class="text-danger">*</span></label><br>
                                <select name="employee" class="select2" id="edit_employee" disabled>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->firstname }} {{ $employee->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Phụ cấp <span class="text-danger">*</span></label>
                        <input class="form-control" name="phucap" type="text" id="edit_phucap">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Số ngày đi trễ <span class="text-danger">*</span></label>
                        <input class="form-control" name="ditre" type="text" id="edit_ditre">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Số ngày nghỉ <span class="text-danger">*</span></label>
                        <input class="form-control" name="ngaynghi" type="text" id="edit_ngaynghi">
                    </div>
                    <div class="form-group">
                        <label>Trạng thái </label>
                        <select name="status" class="select2 form-control" id="edit_status">
                            <option value="Đã thanh toán">Đã thanh toán</option>
                            <option value="Chưa thanh toán">Chưa thanh toán</option>
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


<!-- /Edit Salary Modal -->

@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
    <script>
        $(document).ready(function(){
    // Use event delegation to ensure dynamically added elements are captured
    $('.table').on('click', '.editbtn', function() {
        $('#edit_salary').modal('show');
        var id = $(this).data('id');
        var employee = $(this).data('employee');
        var designation = $(this).data('designation');
        var phucap = $(this).data('phucap');
        var ditre = $(this).data('tre');
        var ngaynghi = $(this).data('nghi');
        var status = $(this).data('status');

        $('#edit_id').val(id);
        $('#edit_employee').val(employee).trigger('change');
        $('#edit_designation').val(designation).trigger('change');
        $('#edit_phucap').val(phucap);
        $('#edit_ditre').val(ditre);
        $('#edit_ngaynghi').val(ngaynghi);
        $('#edit_status').val(status).trigger('change');
    });
});

    </script>
@endsection
