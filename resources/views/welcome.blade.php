<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>        

    <title>Login Admin</title>
  </head>
  <body>

    <div class="container">

      <div class="panel-group" id="api" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="heading-users">
            <h4 class="panel-title">
              <a role="button" data-toggle="collapse" data-parent="#api" href="#api-users" aria-expanded="true" aria-controls="api-users">
                Users
              </a>
            </h4>
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

           @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif

          <div class="panel-body" role="tab" id="heading-users">
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12"></div>
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
             <form method="post" name="login" action="{{url('login')}}">
              <input type="hidden"  name="csrf-token" content="{{ csrf_token() }}" value="{{ csrf_token() }}">
              <input type="hidden"  name="_token" content="{{ csrf_token() }}" value="{{ csrf_token() }}">

              <div class="row">
                <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">UserName/Email</div>
                <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                  <input type="text" name="email" class="form-control">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">Password</div>
                <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                  <input type="password" name="password" class="form-control">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6"></div>
                <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                  <input type="submit" name="Submit" class="btn btn-primary" value="Submit">
                </div>
              </div>
             </form>
           </div>
          </div>
        </div>
      </div>


    </div>

  </body>
</html>
