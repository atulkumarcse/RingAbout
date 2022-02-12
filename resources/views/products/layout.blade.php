<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RingAbout</title>

     <!-- CDNs -->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 
     <!-- Font awesome -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

     <!-- css styling -->
     <link rel="stylesheet" href="/RingAbout/assets/CSS/admin.css">

</head>
<body>
    <div class="main-container">
        <!-- Logout Modal -->
        <div class="modal fade logModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header my-1">
                  <h5 class="modal-title">LogOut</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <h4 class="text-center mb-3">Are you sure?</h4>
                  <div class="d-flex justify-content-center">
                    <button class="btn btn-success mx-2 px-5">Yes</button>
                    <button class="btn btn-danger mx-2 px-5">No</button>
                  </div>
                </div>
              </div>
            </div>
        </div>
        
        <!-- navbar -->
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #283b79;">
            <a class="navbar-brand text-white" href="#">RingAbout</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <!-- <span class="navbar-toggler-icon"></span> -->
                <i class="fas fa-bars open text-white fw-bold"></i>
                <i class="fas fa-times close text-white fw-bold"></i>
            </button>
            <div class="collapse navbar-collapse justify-content-end mr-3" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link " href="#posts" id="adhome">Posts </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#challenges" id="adchal">Challenges</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#eaderboards" id="adleaderboard">Leaderboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#lottery" id="lotpopup">Lottery-Popup</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="adlogout">Log Out</a>
                    </li>
                </ul>
            </div>
        </nav>

<div class="container">
    @yield('content')

    <!-- Lottery-Popup -->
        <div class="container-fluid a1 mt-5" id="lottery">
            <div class="w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                <h3 class="text-center text-white my-5">Click below button to trigger Lottery-Popup</h3>
                <a href="" class="btn lotbtn px-5">Lottery</a>
            </div>
        </div>
</div>
   
</div>


    <script src="/RingAbout/assets/JS/admin.js"></script>
</body>
</html>