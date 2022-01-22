@extends('products.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Challenge Details</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('challenges.create') }}"> Create New Challenge</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

      @if ($message = Session::get('errors'))
        <div class="alert alert-error">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Details</th>
             <th>Image</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($challenges as $product)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->detail }}</td>
            <td><img src= '{{ $product->url }}' /></td>
            <td>
                 <a class="btn btn-info" href="{{ url('challenges.edit',$product->id) }}">Edit</a>
                   <a class="btn btn-info" href="{{ url('challenges.delete',$product->id) }}/0">Delete</a>
                 
                
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $challenges->links() !!}
      
@endsection