@extends('layout')
 
@section('content')
<style type="text/css">
    .noned {
        display: none;
    }
</style>
 <link rel="stylesheet" href="/RingAbout/assets/CSS/main.css">
 <!-- Posts  -->
        <div class="container-fluid a1" id="posts">
            <div class="d-flex flex-column align-items-center">
                <h1 class="text-center pt-4 mb-5">Posts Dashboard</h1>
                <div style="width: 40%;" class="d-flex justify-content-center">

                    <select class="custom-select yourpost" name="title" >
                        <option selected>Select one from below</option>
                        <option class="one " {{ (old("title") == "1" ? "selected":"") }} value="1">Users classifieds</option>
                        <option class="two " {{ (old("title") == "2" ? "selected":"") }} value="2">Your advertisement</option>
                        <option class="two " {{ (old("title") == "3" ? "selected":"") }} value="3">Your classifieds</option>
                    </select>
                </div>

                <!-- Admin advertisements max 3 -->
                <div class=" mt-5" style="width: 100%;">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif

                      @if($message == Session::get('errors'))
                        <div class="alert alert-error">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <div class="pull-right mt-4 mb-5">
                         @if(old("title") == 2)
                        <a class="btn" href="{{ route('products.create') }}"> Create New Advertisement</a>
                        @elseif(old("title") == 3)
                         <a class="btn classified" id="exampleModalLongTitle">Create your classifieds</a>
                         @endif
                    </div>
                    
                    <table class="table">
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
                                @if($product->status == 1)
                                 <a class="btn btn-success {{ url()->current() == url('index') ? 'noned' : '' }} "  href="{{ url('status',$product->id) }}/2">Accept</a>
                                  <a class="btn btn-danger  " href="{{ url('status',$product->id) }}/0"> {{ url()->current() == url('index') ? 'Delete' : 'Reject' }} </a>
                                   @else
                                      <a class="btn btn-danger  " href="{{ url('status',$product->id) }}/0"> Delete </a>
                                  @endif

                                                                   {{--  <a class="btn {{ $product->status == '0' ? 'btn-warning' : 'btn-info' }} " href="{{ url('status',$product->id) }}/0">Delete</a> --}}
                                 
                                
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
        window.location.href = "{{ route('products.user') }}"+"?title="+optval
    }
    else if(optval==2){
        window.location.href = "{{ url('index') }}"+"?title="+optval
    }
    else if(optval==3){
        window.location.href = "{{ url('yourclassified') }}"+"?title="+optval
    }
    
    else{
        // $('.adposts').css('display','none');
        // $('.useposts').css('display','none');
    }
});


 </script>   
 
<!-- advertisement Modal -->
        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 650px;">
                <div class="modal-content" style="min-height: 500px;">
                    <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLongTitle">Create your classifieds</h3>
                   
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <h1 id="uploadmsg"></h1>
                            <form action="" id="formadv">
                                 <input type="hidden"  name="csrf-token" content="{{ csrf_token() }}" value="{{ csrf_token() }}">
                                 <input type="hidden"  name="_token" content="{{ csrf_token() }}" value="{{ csrf_token() }}">

                                <h5>Choose from the options below to create your classified</h5>
                                <select name="name" class="custom-select">
                                    <option selected >Select one from below</option>
                                    <option class="one opts" value="1">Image</option>
                                    <option class="two opts" value="2">Text</option>
                                    <option class="three opts" value="3">Image & Text</option>
                                </select>
                                <div>
                                    <!-- image option -->
                                    <div class="img-opt mt-5">
                                        <p class="note"><strong>*** Image should be of 2:1 (width:height) aspect ratio (Svg format recommended)</strong></p>
                                        <div class="d-flex mb-4">
                                            <div class="uadphoto">
                                                <img src="" class="uadpic" alt="photo">
                                            </div>
                                            <div class="upbtn ml-4">
                                                <button class="btn igUpload">Upload Picture</button>
                                                <input type="file" id="imgUpload" onchange="loadAdvFile(event)" name="file" style="display: none;">
                                            </div> 
                                        </div>
                                        <button class="btn submitbtn submitbtnadv ">Submit</button>
                                    </div>
                                    <!-- text option -->
                                    <div class="text-opt mt-5">
                                        <p class="mb-1 note"><strong>*** Maximum 150 characters</strong></p>
                                        <textarea class="ptext" placeholder="Your classified's text will be here..." style="resize: none; width: 100%; height: 150px;padding: 0.5rem 1rem;" name="detail" onchange="turncatesting(this)" ></textarea>
                                        <button class="btn txtsubmitbtn submitbtnadv">Submit</button>
                                    </div>

                                    </form>
                                    <form action="" id="formadvimg">
                                        <input type="hidden"  name="csrf-token" content="{{ csrf_token() }}" value="{{ csrf_token() }}">
                                 <input type="hidden"  name="_token" content="{{ csrf_token() }}" value="{{ csrf_token() }}">
                                    <!-- text over pattern option -->
                                    <div class="patt-opt mt-5">
                                        <div class="d-flex justify-content-center mb-4">
                                            <div id="image" class="d-flex justify-content-center align-items-center text-center" style="width: 80%; height: 180px; border:1px solid #000;">
                                                Click on an image below to display here.
                                            </div>
                                        </div>
                                        <p class="mb-3 note"><strong>Choose the pattern for your classified's background</strong> </p>
                                        <div class="patterns">
                                            <div class="row">
                                                <div class="col-md-4" style="height: 100px;margin-bottom: 30px;">
                                                    <div class="h-100 d-flex" style="border:1px solid #000; ">
                                                        <img src="/RingAbout/assets/SVG/bubbles.svg" class="img-fluid w-100" style="object-fit: cover; background-color: #283b79;" onclick="upDate(this)" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="height: 100px;margin-bottom: 30px;">
                                                    <div class="h-100 d-flex" style="border:1px solid #000;">
                                                        <img src="/RingAbout/assets/SVG/hideout.svg" class="img-fluid w-100" style="object-fit: cover;background-color: #283b79;"onclick="upDate(this)" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="height: 100px;margin-bottom: 30px;">
                                                    <div class="h-100 d-flex" style="border:1px solid #000;">    
                                                        <img src="/RingAbout/assets/SVG/i-like-food.svg" class="img-fluid w-100" style="object-fit: cover;background-color: #283b79;"onclick="upDate(this)" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="height: 100px;margin-bottom: 30px;">
                                                    <div class="h-100 d-flex" style="border:1px solid #000; ">
                                                        <img src="/RingAbout/assets/SVG/jigsaw.svg" class="img-fluid w-100" style="object-fit: cover;background-color: #283b79;"onclick="upDate(this)" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="height: 100px;margin-bottom: 30px;">
                                                    <div class="h-100 d-flex" style="border:1px solid #000;">
                                                        <img src="/RingAbout/assets/SVG/temple.svg" class="img-fluid w-100" style="object-fit: cover;background-color: #283b79;"onclick="upDate(this)" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="imageUrl" name="imageUrl">
                                            <div>
                                                <p class="mb-1 note"><strong>*** Maximum 150 characters</strong></p>
                                                <textarea id="pattext" class="ptext" onchange="turncatesting(this)" name ="detail" placeholder="Your classified's text will be here..." style="resize: none; width: 100%; height: 150px;padding: 0.5rem 1rem;"></textarea>
                                                <button class="btn pattsubmitbtn">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- advertisement submitted after popup -->
        <div class="modal fade" id="adafterModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 600px;">
              <div class="modal-content">
                <div class="modal-header my-1">
                  <button type="button" class="close closemodal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                 <div class="container">
                    <h2 class="text-white text-center">Your classified is successfully submitted. It will flash on the user side.</h2>
                 </div>
                </div>
              </div>
            </div>
        </div>   



        <script>
         imageUrl = "";
         $('#logOut').on('click',function(){
            $('#logoutModal').modal({
    backdrop: 'static',
    keyboard: false
});
        });


        $('.classified').on('click',function(){
            $('#exampleModalLong').modal({
    backdrop: 'static',
    keyboard: false
});
        });


        $('.igUpload').on('click',function(e){
            e.preventDefault();
            $('#imgUpload').click();
        });

        

        $('select').on('click',function(e){
            console.log(e);
            var optval = e.target.value;
            console.log(optval);
            if(optval==1){
                $('.patt-opt').css('display','none');
                $('.text-opt').css('display','none');
                $('.img-opt').css('display','block');
            }
            else if(optval==2){
                $('.patt-opt').css('display','none');
                $('.img-opt').css('display','none');
                $('.text-opt').css('display','block');
            }
            else if(optval==3){
                $('.text-opt').css('display','none');
                $('.img-opt').css('display','none');
                $('.patt-opt').css('display','block');
            }
            else{
                $('.patt-opt').css('display','none');
                $('.img-opt').css('display','none');
                $('.text-opt').css('display','none');
            }
        });

         // advertisements divs
        var w1 = document.getElementById('advert1').offsetWidth;
        var w2 = document.getElementById('advert2').offsetWidth;
        var w3 = document.getElementById('advert3').offsetWidth;

        var h1 = w1 / 4;
        var h2 = w2 / 4;
        var h3 = w3 / 4;


        document.getElementById('advert1').style.height = h1 +'px';
        document.getElementById('advert2').style.height = h2 +'px';
        document.getElementById('advert3').style.height = h3 +'px';

        // classified divs
        var uw = $('.clsf').outerWidth();
        var uh = uw / 2;
        var uhh = uh + 'px';
        $('.clsf').css('height', uhh);


        function upDate(x){
            imageUrl = x.src;
            document.getElementById('image').style.backgroundImage="url("+ x.src +")";
            document.getElementById('imageUrl').value = x.src 
            document.getElementById('image').innerHTML="Your classified's text will be here...";
        }

    </script>
            <script type="text/javascript">
          

           var loadAdvFile = function(event) {
    var image = document.getElementsByClassName('uadpic');
    image[0].src = URL.createObjectURL(event.target.files[0]);
    //image[1].src = URL.createObjectURL(event.target.files[0]);
};

text_truncate = function(str, length, ending) {
    if (length == null) {
      length = 150;
    }
    if (ending == null) {
      ending = '...';
    }
    if (str.length > length) {
      return str.substring(0, length - ending.length) + ending;
    } else {
      return str;
    }
  };

function turncatesting(e){
   var string = text_truncate(e.value,150);
   $('.ptext').val(string);
}

$('.submitbtnadv').on('click',function(e){
    e.preventDefault();
    //var formData = $("#formadv").serialize();
    var form = $('#formadv')[0];
    var formData = new FormData(form);
    bearertoken = "";
    // Fire off the request to /form.php
    request = $.ajax({
        url: "/ring_about/AdvertiseStore",
        type: "post",
        processData: false,
        contentType: false,
        headers: {
            "Authorization": "Bearer  " + bearertoken 
          },
        data: formData
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        if(response.status == true || response.status == 'true')
           {
            $("#exampleModalLong").modal('hide');
            $("#adafterModal").modal();
            //$("#uploadmsg").html("Advertise Created Succefully"); 
            //window.location.reload();
            //return true;
           }
        else{
             
        }
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
           if(jqXHR.responseJSON.error == "token_expired" || jqXHR.responseJSON.error == "token_not_provided" || jqXHR.responseJSON.error == "token_invalid"){
            //window.location.href = "/RingAbout";
           }

           
           //  var  i=0; 
           //  Object.entries(jqXHR.responseJSON.error.errors).forEach(([key, val]) => {
           //    if(i==0){
           //     $("#loginmsg").html(val); 
           //     i++;
           //    }     
           //  });
    });

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputs
       // $inputs.prop("disabled", false);
    });
});




$('.pattsubmitbtn').on('click',function(e){
    e.preventDefault();
    //var formData = $("#formadv").serialize();
    var form = $('#formadvimg')[0];
    var formData = new FormData(form);
    bearertoken = "";
    // Fire off the request to /form.php
    request = $.ajax({
        url: "/ring_about/AdvertiseStorepattern",
        type: "post",
        processData: false,
        contentType: false,
        headers: {
            "Authorization": "Bearer  " + bearertoken 
          },
        data: formData
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        if(response.status == true || response.status == 'true')
           {
            // $("#uploadmsg").html("Advertise Created Succefully"); 
            // window.location.reload();
            $("#exampleModalLong").modal('hide');
            $("#adafterModal").modal();
            //return true;
           }
        else{
             
        }
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
           if(jqXHR.responseJSON.error == "token_expired" || jqXHR.responseJSON.error == "token_not_provided" || jqXHR.responseJSON.error == "token_invalid"){
            //window.location.href = "/RingAbout";
           }

           
           //  var  i=0; 
           //  Object.entries(jqXHR.responseJSON.error.errors).forEach(([key, val]) => {
           //    if(i==0){
           //     $("#loginmsg").html(val); 
           //     i++;
           //    }     
           //  });
    });

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputs
       // $inputs.prop("disabled", false);
    });
});


       </script>
       <style type="text/css">
           .u-para {
                position: absolute;
            }
       </style>
   
@endsection