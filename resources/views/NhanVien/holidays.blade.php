@extends('includes.NhanVien.backend')

@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <h3 class="page-title">Các ngày lễ</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">Nhân viên</li>
            <li class="breadcrumb-item active">Danh sách ngày lễ</li>
        </ul>
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
                        <th class="text-center">Số lượng ngày nghỉ</th>
                        <th class="text-center">Đã kết thúc</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($holidays->count()))
                        @foreach ($holidays as $holiday)
                            <tr class="@if($holiday->completed) holiday-completed @endif holiday-upcoming">
                                <td>{{$holiday->name}}</td>
                                <td>{{date_format(date_create($holiday->from),"d/m/Y")}}</td>
								<td>{{date_format(date_create($holiday->to),"d/m/Y")}}</td>
								<td class="text-center">
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
                                <td class="text-center">
                                    @if ($holiday->completed == 1)
                                        ✓ <!-- Hiển thị dấu "✓" nếu hoàn thành -->
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <x-modals.delete :route="'holiday.destroy'" :title="'holiday'" />
                        <!-- Edit Holiday Modal -->
                        <div class="modal custom-modal fade" id="edit_holiday" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Holiday</h5>
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
                                                <label>Holiday Name <span class="text-danger">*</span></label>
                                                <input class="form-control" id="edit_name" name="name" type="text">
                                            </div>
                                            <div class="form-group">
                                                <label>Holiday Date <span class="text-danger">*</span></label>
                                                <div class="cal-icon"><input id="edit_date" class="form-control datetimepicker" name="holiday_date" type="text"></div>
                                            </div>
                                            <div class="submit-section">
                                                <button class="btn btn-primary submit-btn">Save</button>
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
                <h5 class="modal-title">Add Holiday</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Holiday Name <span class="text-danger">*</span></label>
                        <input name="name" class="form-control" type="text">
                    </div>
                    <div class="form-group">
                        <label>Holiday Date <span class="text-danger">*</span></label>
                        <div class="cal-icon">
                        <input name="holiday_date" class="form-control datetimepicker" type="text"></div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
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
            var date = $(this).data('date');
            $('#edit_id').val(id);
            $('#edit_name').val(name);
            $('#edit_date').val(date);
        });
    });
</script>
@endsection