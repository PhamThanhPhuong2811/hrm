@extends('layouts.backend')

@section('styles')
<!-- Datatable CSS -->
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">

@endsection

@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <h3 class="page-title">Chức vụ</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Thống kê</a></li>
            <li class="breadcrumb-item active">Chức vụ</li>
        </ul>
    </div>
    <div class="col-auto float-right ml-auto">
        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_designation"><i class="fa fa-plus"></i> Thêm chức vụ</a>
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
                        <th style="width: 30px;">STT</th>
                        <th>Chức vụ </th>
                        <th>Phòng ban </th>
                        <th class="text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @php $stt = 1 @endphp <!-- Khởi tạo biến đếm -->
                   @if (!empty($designations->count()))
                       @foreach ($designations as $designation)
                        <tr>
                            <td>{{ $stt++ }}</td>
                            <td>{{$designation->name}}</td>
                            <td>{{$designation->department->name}}</td>
                            <td class="text-right">
                            <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a data-id="{{$designation->id}}" data-name="{{$designation->name}}" data-department="{{$designation->department_id}}" class="dropdown-item editbtn" href="javascript:void(0)" data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Chỉnh sửa</a>
                                    <a data-id="{{$designation->id}}" class="dropdown-item deletebtn" href="javascript:void(0)" data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Xóa</a>  
                                </div>
                                </div>
                            </td>
                        </tr>
                       @endforeach
                       <x-modals.delete :route="'designation.destroy'" :title="'Chức vụ'"/>
                   @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Designation Modal -->
<div id="add_designation" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm chức vụ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('designations')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Tên chức vụ <span class="text-danger">*</span></label>
                        <input class="form-control" name="designation" type="text" placeholder="Nhập tên chức vụ">
                    </div>
                    <div class="form-group">
                        <label>Phòng ban <span class="text-danger">*</span></label>
                        <select class="select" name="department" title="Select Department">
                            <option value="null" disabled selected>Vui lòng lựa chọn phòng ban</option>
                            @if(!empty($departments->count()))
                            @foreach($departments as $department)
                                <option value="{{$department->id}}">{{$department->name}}</option>
                            @endforeach
                            @endif
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
<!-- /Add Designation Modal -->

<!-- Edit Designation Modal -->
<div id="edit_designation" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa thông tin chức vụ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('designations')}}">
                    @csrf
                    @method("PUT")
                    <input type="hidden" name="id" id="edit_id">
                    <div class="form-group">
                        <label>Tên chức vụ <span class="text-danger">*</span></label>
                        <input class="form-control edit_designation" name="designation" type="text">
                    </div>
                    <div class="form-group">
                        <label>Phòng ban <span class="text-danger">*</span></label>
                        <select name="department" class="form-control edit_department">
                            @foreach ($departments as $department)
                                <option value="{{$department->id}}">{{$department->name}}</option>
                            @endforeach
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
<!-- /Edit Designation Modal -->
@endsection

@section('scripts')
<!-- Datatable JS -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>

<script>
    $(document).ready(function(){
        $('.table').on('click','.editbtn',function(){
            $('#edit_designation').modal('show');
            var id = $(this).data('id');
            var designation = $(this).data('name');
            var department = $(this).data('department');
            $('#edit_id').val(id);
            $('.edit_designation').val(designation);
            $('.edit_department').val(department);
        })
    });
</script>
@endsection
