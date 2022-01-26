
@extends('leaderboards.layout')

@section('content')
<div class=" a1 px-5" >
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                 <h1 class="text-center text-white pt-4">Leaderboard Dashboard</h1>
            </div>
            <div class="pull-right  mt-4 mb-5">
                <a class="btn btn-success" href="{{ route('leaderboards.create') }}"> Create New Leaderboard</a>
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
   
   <table id="table" class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Order.</th>
            <th>Name</th>
            <th>Money</th>
            <th width="280px">Action</th>
        </tr>
    </thead>
        <tbody id="tablecontents">
        @foreach ($leaderboards as $product)
         <tr class="row1" data-id="{{ $product->id }}">
            <td class="pl-3"><i class="fa fa-sort"></i></td>
            <td>{{ $product->order }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->money }}</td>
            <td>
                   <a class="btn btn-info" href="{{ url('leaderboards.status',$product->id) }}/0">Delete</a>
                 
                
            </td>
        </tr>
       
        @endforeach
        </tbody>
    </table>
    <button class="btn btn-success btn-sm" onclick="window.location.reload()">REFRESH</button>
    {!! $leaderboards->links() !!}

      </div>

      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script> 
    <script type="text/javascript">
      $(function () {
        $("#table").DataTable();

        $( "#tablecontents" ).sortable({
          items: "tr",
          cursor: 'move',
          opacity: 0.6,
          update: function() {
             //console.log("this");
              sendOrderToServer();
          }
        });

        function sendOrderToServer() {
          var order = [];
          var token = $('meta[name="csrf-token"]').attr('content');
          $('tr.row1').each(function(index,element) {
            order.push({
              id: $(this).attr('data-id'),
              position: index+1
            });
          });
         // console.log(position)
          $.ajax({
            type: "POST", 
            dataType: "json", 
            url: "{{ url('post-sortable') }}",
                data: {
               order: order,
              _token: token
            },
            success: function(response) {
                if (response.status == "success") {
                  console.log(response);
                } else {
                  console.log(response);
                }
            }
          });
        }
      });
    </script>
@endsection