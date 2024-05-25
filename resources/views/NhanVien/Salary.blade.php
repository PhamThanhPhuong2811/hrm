@extends('includes.NhanVien.backend')

@section('styles')
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
    <!-- Select2 CSS -->
    
@endsection


@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <h3 class="page-title">Danh sách lương</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">Nhân viên</li>
            <li class="breadcrumb-item active">Danh sách lương</li>
        </ul>
    </div>
   
</div>
@endsection

@section('content')

<div class="row">
    <div class="col-md-7">
        <form action="{{ route('Xemluong.filter') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Chọn tháng</label>
                        <select class="form-control select2" name="month">
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ (isset($month) && $month == $m) ? 'selected' : '' }}>{{ $m }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Chọn năm</label>
                        <select class="form-control select2" name="year">
                            @for ($y = 2024; $y <= Carbon\Carbon::now()->year; $y++)
                                <option value="{{ $y }}" {{ (isset($year) && $year == $y) ? 'selected' : '' }}>{{ $y }}</option>
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
                    
                    </tr>
                </thead>
                <tbody>
                    @foreach ($salarys as $salary)
                        <tr>
                            <td>
                                <h2 class="table-avatar">
                                    <a href="javascript:void(0)" class="avatar avatar-xs">
                                        <img alt="avatar" src="{{!empty($salary->employee->avatar) ? asset('storage/employees/'.$salary->employee->avatar) : asset('assets/img/user.jpg')}}">
                                    </a>
                                    <a href="#">{{$salary->employee->firstname}} {{$salary->employee->lastname}}</a>
                                </h2>
                            </td>
                            <td>
                                {{$salary->designation->name}}
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
                                {{ $salary->trangthai }}
                            </td>
                            
                        </tr>
                        @endforeach
                       
                </tbody>
              
            </table>
        </div>
    </div>
</div>
<!--Them modal them luong cho nhan vien-->



<!-- Edit Salary Modal -->

<!-- /Edit Salary Modal -->
@endsection


@section('scripts')

    <script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
    <!-- Datatable JS -->
    <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
    
    <script>
        $(document).ready(function(){
            $('.editbtn').click(function(){
                var id = $(this).data('id');
                var employee = $(this).data('employee');
                var designation = $(this).data('designation');
                var phucap = $(this).data('phucap');
                var ditre = $(this).data('ditre');
                var ngaynghi = $(this).data('ngaynghi');
                var status = $(this).data('status');
    
                $('#edit_salary').modal('show');
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