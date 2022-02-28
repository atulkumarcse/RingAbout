@extends('layout')
@section('content')
<!-- <div class="row">
<div class="col-lg-12 margin-tb">
 <br>
 <a class="btn backbtn px-4" style="float:right" href="{{ route('products.index') }}"><i class="fas fa-backspace"></i> Back</a>
</div>
</div> -->
<div class="row">

    <div class="col-lg-12 margin-tb mt-5">
        <div class="pull-left">
            <h1 class="text-center mb-5">Add New Advertisement
</h1>
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
                <input type="hidden" name="name" value="Admin" class="form-control" placeholder="Name">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
            <div class="form-group">
                <!-- <strong>Detail:</strong> -->
                <textarea class="form-control" style="height:150px" name="detail" placeholder="Detail"></textarea>
               <!--  <select class="pos-select form-control" name="detail" >
                        <option selected value="">Select advertisement's position from below</option>
                        <option class="one " value="Top">Top</option>
                        <option class="two " value="Middle">Middle</option>
                        <option class="two " value="Bottom">Bottom</option>
                </select> -->
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-4" id="imagediv">
            <div class="h-100 d-flex" style="border:1px solid #ffffff">
                <img src="" class="img-fluid w-100 imgshow">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <p class="mb-1 text-white">Select File (Image should be of 4:1 (width:height) aspect ratio):</p>
                <input type="file" value="" name="file" onchange="loadFile(event)"  class="form-control" >
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center mb-5">
                <button type="submit" class="btn subbtn">Submit</button>
        </div>
    </div>
   
</form>
<script>
    var w = $('#imagediv').outerWidth();
    var h = w / 4;
     document.getElementById('imagediv').style.height = h +'px';

     var loadFile = function(event) {
    var image = document.getElementsByClassName('imgshow');
    image[0].src = URL.createObjectURL(event.target.files[0]);
    //image[1].src = URL.createObjectURL(event.target.files[0]);
};
</script>

@endsection