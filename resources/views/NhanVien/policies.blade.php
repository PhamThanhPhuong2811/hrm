@extends('includes.NhanVien.backend')

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
            <li class="breadcrumb-item">Nhân viên</li>
            <li class="breadcrumb-item active">Chính sách</li>
        </ul>
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
                        <th>File đính kèm </th>
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
                            </tr>                        
                        @endforeach
                       
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection

@section('scripts')
    <!-- Select2 JS -->
    <script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
    <!-- Datatable JS -->
    <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
@endsection