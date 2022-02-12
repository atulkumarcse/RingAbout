@extends('layout')
@section('content')

<!-- <div class="row">
<div class="col-lg-12 margin-tb">
 <br>
 <a class="btn backbtn px-4" style="float:right" href="{{ route('leaderboards.index') }}"><i class="fas fa-backspace"></i> Back</a>
</div>
</div>  -->       
<div class="row">
    <div class="col-lg-12 margin-tb mt-5">
        <div class="pull-left">
        <h1 class="text-center mb-5">Add New Entry</h1>
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
   
<form action="{{ route('leaderboards.store') }}" method="POST" multipart="true">
    
    
  <input type="hidden"  name="csrf-token" content="{{ csrf_token() }}" value="{{ csrf_token() }}">
    <input type="hidden"  name="_token" content="{{ csrf_token() }}" value="{{ csrf_token() }}">

     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 mb-4">
            <div class="form-group">
                <!-- <strong>Name:</strong> -->
                <input type="text" name="name" class="form-control" placeholder="Enter name">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
            <div class="form-group">
                <!-- <strong>Money:</strong> -->
                <input class="form-control" type="number" name="money" placeholder="Enter money"/>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn subbtn">Submit</button>
        </div>
    </div>
   
</form>
<!-- <script type="text/javascript">
    $(".navbar ").css("display","none");
</script> -->
@endsection