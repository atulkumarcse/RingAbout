@extends('layout')
@section('content')
<div class="row">
<div class="col-lg-12 margin-tb">
 <br>
 <a class="btn backbtn px-4" style="float:right" href="{{ route('products.index') }}"><i class="fas fa-backspace"></i> Back</a>
</div>
</div>
<div class="row">

    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2 class="text-center text-white mb-5">Add New Advertisement
</h2>
        </div>
        
    </div>
</div>
   
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
   
<form action="{{ route('products.store') }}" method="POST" multipart="true" enctype="multipart/form-data">
    
    
  <input type="hidden"  name="csrf-token" content="{{ csrf_token() }}" value="{{ csrf_token() }}">
    <input type="hidden"  name="_token" content="{{ csrf_token() }}" value="{{ csrf_token() }}">

     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
               <!--  <strong>Name:</strong> -->
                <input type="hidden" name="name" value="admin" class="form-control" placeholder="Name">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Detail:</strong>
                <textarea class="form-control" style="height:150px" name="detail" placeholder="Detail"></textarea>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <p class="mb-1 text-white">Select File (Image should be of 4:1 (width:height) aspect ratio):</p>
                <input type="file" name="file" class="form-control" >
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn subbtn">Submit</button>
        </div>
    </div>
   
</form>
@endsection