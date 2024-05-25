@if (route_is(['projects','project-list']))
    <!-- Create Project Modal -->
    <div id="create_project" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm dự án</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('projects')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tên dự án</label>
                                    <input class="form-control" type="text" name="name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Khách hàng</label>
                                   
                                    <select class="select2" name="client">
                                        <option>Vui lòng chọn khách hàng của dự án</option>
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
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Chi phí dự án</label>
                                    <input placeholder="Ví dụ: 50 triệu đồng" name="rate" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Ưu tiên</label>
                                    <select class="select" name="priority">
                                        <option>Chọn độ ưu tiên cho dự án</option>
                                        <option>Cao </option>
                                        <option>Trung bình</option>
                                        <option>Thấp</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Lãnh đạo dự án</label>
                                    <select class="select2" name="leader">
                                        <option>Chọn lãnh đạo dự án</option>
                                        @foreach (\App\Models\Employee::get() as $employee)
                                            <option value="{{$employee->id}}">{{$employee->firstname.' '.$employee->lastname}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Thêm đội nhóm</label>
                                    <select class="select select2" multiple name="team[]">
                                       
                                        @foreach (\App\Models\Employee::get() as $employee)
                                            <option value="{{$employee->id}}">{{$employee->firstname.' '.$employee->lastname}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea name="description" rows="4" class="form-control summernote" placeholder="Enter your message here"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Tài liệu đính kèm</label>
                            <input class="form-control" name="project_files[]" multiple type="file">
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Thêm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Create Project Modal -->

    <!-- Edit Project Modal -->
    <div id="edit_project" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chỉnh sửa thông tin dự án</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('projects')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <input type="hidden" name="id" id="edit_id">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tên dự án</label>
                                    <input class="form-control" type="text" id="edit_name" name="name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Khách hàng</label>
                                    <select id="edit_client" class="select2" name="client">
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
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Giá tiền</label>
                                    <input id="edit_rate" placeholder="Ví dụ 5 triệu" name="rate" class="form-control" type="text">
                                </div>
                            </div>
                           
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Độ ưu tiên</label>
                                    <select class="select" id="edit_priority" name="priority">
                                        <option>Cao</option>
                                        <option>Trung bình</option>
                                        <option>Thấp</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Lãnh đạo dự án</label>
                                    <select class="select2" id="edit_leader" name="leader">
                                        <option>Vui lòng lựa chọn lãnh đạo dự án</option>
                                        @foreach (\App\Models\Employee::get() as $employee)
                                            <option value="{{$employee->id}}">{{$employee->firstname.' '.$employee->lastname}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Nhân viên thực hiện</label>
                                    <select class="select select2" id="edit_team" multiple name="team[]">
                                       
                                        @foreach (\App\Models\Employee::get() as $employee)
                                            <option value="{{$employee->id}}">{{$employee->firstname.' '.$employee->lastname}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea name="description" id="edit_description" rows="4" class="form-control summernote" placeholder="Enter your message here"></textarea>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label for="edit_progress">Thực hiện được</label>
                                <input type="range" class="form-control-range form-range" name="progress" id="edit_progress">
                                <div class="mt-2"><b id="progress_result">Tiến triển:</b></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>File mô tả</label>
                            <input class="form-control" name="project_files[]" multiple type="file">
                            <div id="current_files" class="mt-2">
                                <!-- Current files will be appended here by JavaScript -->
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
    <!-- /Edit Project Modal -->
@endif

