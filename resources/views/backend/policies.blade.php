@extends('layouts.backend')

@section('styles')
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">

@endsection

@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <h3 class="page-title">Chính sách</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Thống kê</a></li>
            <li class="breadcrumb-item active">Chính sách</li>
        </ul>
    </div>
    <div class="col-auto float-right ml-auto">
        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_policy"><i class="fa fa-plus"></i> Thêm chính sách</a>
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
                        <th>Tên chính sách </th>
                        <th>Phòng ban </th>
                        <th>Mô tả </th>
                        <th>File đính kèm</th>
                        <th>Ngày tạo </th>
                        <th class="text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($policies->count()))
                        @foreach ($policies as $policy)
                            <tr>
                                <td>{{$policy->name}}</td>
                                <td>{{$policy->department->name}}</td>
                                <td style="width: 400px">{{$policy->description}}</td>
                                <td>
                                    @php
                                        $files = json_decode($policy->file);
                                    @endphp
                                    @if(!empty($files))
                                        @foreach($files as $file)
                                            <a href="{{ asset('storage/policies/' . $file) }}" target="_blank">{{ $file }}</a><br>
                                        @endforeach
                                    @else
                                        Không có file đính kèm nào
                                    @endif
                                </td>
                                <td>{{date_format(date_create($policy->created_at),"d/m/Y")}}</td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            
                                            <a data-id="{{$policy->id}}"
                                                data-name="{{$policy->name}}"
                                                data-department="{{$policy->department_id}}"
                                                data-description="{{$policy->description}}"
                                                 href="javscript:void(0)" class="dropdown-item editbtn" data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Chỉnh sửa</a>
                                            <a data-id="{{$policy->id}}" class="dropdown-item deletebtn" href="#" data-toggle="modal" ><i class="fa fa-trash-o m-r-5"></i> Xóa</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>                        
                        @endforeach
                        <x-modals.delete :route="'policy.destroy'" :title="'Chính sách'" />
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Policy Modal -->
<!-- Add Policy Modal -->
<div id="add_policy" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm chính sách</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('policies')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Tên chính sách <span class="text-danger">*</span></label>
                        <input class="form-control" name="name" type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Mô tả <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Phòng ban <span class="text-danger">*</span></label>
                        <select name="department" class="select" required>
                            <option value="null" disabled selected>Vui lòng lựa chọn phòng ban</option>
                            @foreach($departments as $department)
                                <option value="{{$department->id}}">{{$department->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>File thông tin <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="policy_upload" name="policy_files[]" multiple>
                            <label class="custom-file-label" for="policy_upload">Chọn file</label>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- /Add Policy Modal -->

<!-- Edit Policy Modal -->
<div id="edit_policy" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa chính sách</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('policies') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit_policy_id">
                    <div class="form-group">
                        <label for="edit_name">Tên chính sách <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="name" id="edit_name">
                    </div>
                    <div class="form-group">
                        <label for="edit_description">Mô tả <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="4" name="description" id="edit_description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_department">Phòng ban <span class="text-danger">*</span></label>
                        <select name="department" class="form-control edit_department">
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_policy_upload">File thông tin <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="edit_policy_upload" name="policy_files[]" multiple>
                            <label class="custom-file-label" for="edit_policy_upload">Vui lòng chọn file</label>
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



<!-- /Edit Policy Modal -->

@endsection

@section('scripts')
    <!-- Select2 JS -->
    <script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
    <!-- Datatable JS -->
    <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(document).ready(function() {
    $('.table').on('click', '.editbtn', function() {
        $('#edit_policy').modal('show');
        var id = $(this).data('id');
        var name = $(this).data('name');
        var description = $(this).data('description');
        var department = $(this).data('department');
        var files = $(this).data('file'); // This should be a JSON array of file names

        $('#edit_policy_id').val(id);
        $('#edit_name').val(name);
        $('#edit_description').val(description);
        $('.edit_department').val(department);

        // Reset file input
        $('#edit_policy_upload').val(null);

        // Display existing files
        var fileList = $('#existing_files');
        fileList.empty(); // Clear previous file list
        if (files && files.length > 0) {
            files.forEach(function(file) {
                var fileLink = '<a href="' + baseUrl + '/storage/policies/' + file + '" target="_blank">' + file + '</a><br>';
                fileList.append(fileLink);
            });
        } else {
            fileList.append('No file chosen');
        }
    });
});
s
    </script>
    
@endsection