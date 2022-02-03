@extends('layout')
 
@section('content')



 <!-- Posts  -->
        <div class="container-fluid a1" id="posts">
            <div class="d-flex flex-column align-items-center">
                <h1 class="text-center text-white pt-4 mb-5">Posts Dashboard</h1>
                <div style="width: 40%;" class="d-flex justify-content-center">

                    <select class="custom-select yourpost" name="title" >
                        <option selected>Select one from below</option>
                        <option class="one " {{ (old("title") == "1" ? "selected":"") }} value="1">User Posts</option>
                        <option class="two " {{ (old("title") == "2" ? "selected":"") }} value="2">Your Posts</option>
                    </select>
                </div>

                <!-- Admin advertisements max 3 -->
                <div class=" mt-5" style="width: 100%;">
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
                    <div class="pull-right mt-4 mb-5">
                        <a class="btn" href="{{ route('products.create') }}"> Create New Advertisement</a>
                    </div>
                    
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Details</th>
                            
                            <th>Image</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($products as $product)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->detail }}</td>
                            
                            <td><img width="120px" src="{{ URL::asset($product->url) }}" /></td>
                            <td>
                                 <a class="btn {{ $product->status == '2' ? 'btn-warning' : 'btn-info' }} "  href="{{ url('status',$product->id) }}/2">Accept</a>
                                  <a class="btn {{ $product->status == '3' ? 'btn-warning' : 'btn-info' }} " href="{{ url('status',$product->id) }}/3">Reject</a>
                                   <a class="btn {{ $product->status == '0' ? 'btn-warning' : 'btn-info' }} " href="{{ url('status',$product->id) }}/0">Delete</a>
                                 
                                
                            </td>
                        </tr>
                        @endforeach
                    </table>
  
    {!! $products->links() !!}

                </div>
                
            </div>
        </div>
   
   
   
 <script type="text/javascript">
    
     $('.yourpost').on('change',function(e){
    var optval = e.target.value;
   
    if(optval==1){
        window.location.href = "{{ route('user.post') }}"+"?title="+optval
    }
    else if(optval==2){
        window.location.href = "{{ url('index') }}"+"?title="+optval
    }
    else{
        // $('.adposts').css('display','none');
        // $('.useposts').css('display','none');
    }
});
 </script>   
      
@endsection