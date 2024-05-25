@extends('includes.NhanVien.backend')
@section('styles')
<!-- Datatable CSS -->
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">

@endsection

@section('page-header')
<div class="row align-items-center">
    <div class="col">
        <h3 class="page-title">Gửi gmail</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">Nhân viên</li>
            <li class="breadcrumb-item active">Gửi mail</li>
        </ul>
    </div>
    
</div>
@endsection

@section('content')
<div class="row">
    <div class="container mt-5">
    @if($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible">
            <strong>{{ $message }}</strong>
        </div>       
    @endif    


    @if($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible">
            <strong>{{ $message }}</strong>
        </div>       
    @endif

    <form action="{{ route('guimail.store') }}" method="post">
         @csrf
        <div class="form-group">
            <label for="">Email người nhận: </label>
            <input type="text" name="email" class="form-control">
        </div>

        <div class="form-group">
            <label for="">Tiêu đề: </label>
            <input type="text" name="subject" class="form-control">
        </div>

        <div class="form-group">
            <label for="">Nội dung:</label>
            <textarea name="body" class="form-control" ></textarea>
        </div>
        <div class="form-group mt-3 mb-3">
            <button type="submit" class="btn btn-success btn-block">Gửi </button>
        </div>

    </form>
    </div>
</div>

@endsection


