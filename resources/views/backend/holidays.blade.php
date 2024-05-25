@extends('layouts.backend')

@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <h3 class="page-title">Các ngày lễ</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Thống kê</a></li>
            <li class="breadcrumb-item active">Danh sách ngày lễ</li>
        </ul>
    </div>
    <div class="col-auto float-right ml-auto">
        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_holiday"><i class="fa fa-plus"></i> Thêm ngày lễ</a>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table mb-0">
                <thead>
                    <tr>
                        <th>Tên ngày lễ </th>
                        <th>Nghỉ từ</th>
                        <th>Nghỉ đến</th>
                        <th>Số lượng ngày nghỉ</th>
                        <th class="text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($holidays->count()))
                        @foreach ($holidays as $holiday)
                            <tr class="@if($holiday->completed) holiday-completed @endif holiday-upcoming">
                                <td>{{$holiday->name}}</td>
                                <td>{{date_format(date_create($holiday->from),"d/m/Y")}}</td>
								<td>{{date_format(date_create($holiday->to),"d/m/Y")}}</td>
								<td>
                                    @php
                                        // Tạo các đối tượng DateTime từ chuỗi ngày
                                        $start = new DateTime($holiday->from);
                                        $end = new DateTime($holiday->to);
                                
                                        // Sử dụng phép trừ để tính số ngày nghỉ
                                        $interval = $start->diff($end);
                                
                                        // Lấy số ngày nghỉ từ phép trừ
                                        $num_days = $interval->days + 1; // Phải cộng thêm 1 vì phép trừ không tính ngày bắt đầu
                                
                                        // Kiểm tra và hiển thị số ngày nghỉ
                                        echo $num_days . ' ' . ($num_days > 1 ? 'ngày' : 'ngày');
                                    @endphp
                                </td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if(!$holiday->completed)
                                                <form action="{{route('completed',$holiday)}}" method="post">
                                                    @csrf
                                                    <button data-id="{{$holiday->id}}" class="dropdown-item btn mark_as_complete" type="submit"><i class="fa fa-star m-r-5"></i>Đã kết thúc</button>
                                                    <input type="hidden" id="complete_id" name="id">
                                                </form>
                                            @endif
                                            <a data-id="{{$holiday->id}}" data-name="{{$holiday->name}}" data-from="{{$holiday->from}}"
												data-to="{{$holiday->to}}" class="dropdown-item editbtn" href="javascript:void(0);" data-toggle="modal" data-target="#edit_holiday"><i class="fa fa-pencil m-r-5"></i> Chỉnh sửa</a>
                                            <a data-id="{{$holiday->id}}" class="dropdown-item deletebtn" href="javascript:void(0);" data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Xóa</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <x-modals.delete :route="'holiday.destroy'" :title="'Ngày lễ'" />
                        <!-- Edit Holiday Modal -->
                        <div class="modal custom-modal fade" id="edit_holiday" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Chỉnh sửa thông tin ngày lễ</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('holidays')}}" method="post">
                                            @method("PUT")
                                            @csrf
                                            <input type="hidden" id="edit_id" name="id">
                                            <div class="form-group">
                                                <label>Tên ngày lễ <span class="text-danger">*</span></label>
                                                <input class="form-control" id="edit_name" name="name" type="text">
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
                                            <div class="submit-section">
                                                <button class="btn btn-primary submit-btn">Lưu</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Edit Holiday Modal -->
                    @endif                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Holiday Modal -->
<div class="modal custom-modal fade" id="add_holiday" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm ngày lễ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Tên ngày lễ <span class="text-danger">*</span></label>
                        <input name="name" class="form-control" type="text">
                    </div>
                    <div class="form-group">
						<label>Nghỉ từ <span class="text-danger">*</span></label>
						<div class="cal-icon">
							<input name="from" class="form-control datetimepicker" type="text">
						</div>
					</div>
					<div class="form-group">
						<label>Nghỉ đến <span class="text-danger">*</span></label>
						<div class="cal-icon">
							<input name="to" class="form-control datetimepicker" type="text">
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
<!-- /Add Holiday Modal -->


@endsection

@section('scripts')
<script>
    $(document).ready(function (){
        // mark as complete 
        $('.mark_as_complete').on('click',function (){
            var id = $(this).data('id');
            console.log(id);
            $('#.complete_id').val(id);
        })
        // edit holiday 
        $('.editbtn').on('click',function (){
            $('#edit_holiday').modal('show');
            var id = $(this).data('id');
            var name = $(this).data('name');
            var from  = $(this).data('from');
			var to  = $(this).data('to');
            $('#edit_id').val(id);
            $('#edit_name').val(name);
            $('#edit_from').val(from);
			$('#edit_to').val(to)
        });
    });
</script>
@endsection