<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    
    <link href="{{ asset('css/login/icomoon/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toaster.min.css') }}" rel="stylesheet">
    

    <!-- Bootstrap CSS -->
   
    
    <!-- Style -->
    

    <title>Loteca 2.0</title>
  </head>
  <body>
  

  
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img src="{{ asset('storage/LogInImages/undraw_remotely_2j6y.svg') }}" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
              <h3>Sign In</h3>
              <p class="mb-4">Lorem ipsum dolor sit amet elit. Sapiente sit aut eos consectetur adipisicing.</p>
            </div>
            <form action="{{ route('submit.login') }}" method="POST" >
                @csrf
            {{-- <form action="#" method="post"> --}}
              <div class="form-group first">
                <label for="username">Username</label>
                <input name="email" type="text" class="form-control" id="username">

              </div>
              <div class="form-group last mb-4">
                <label for="password">Password</label>
                <input name="password" type="password" class="form-control" id="password">
                
              </div>
              <input name="admin" type="hidden" class="form-control" value="1" >
              
              <div class="d-flex mb-5 align-items-center">
                <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                  <input type="checkbox" checked="checked"/>
                  <div class="control__indicator"></div>
                </label>
                <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span> 
              </div>
              
              <input type="submit" class="btn btn-block btn-primary">
              {{-- </form> --}}

              
            </form>
            </div>
          </div>
          
        </div>
        
      </div>
    </div>
  </div>

  <script src="{{ asset('css/login/js/jquery-3.3.1.min.js') }}"></script>
  <script src="{{ asset('css/login/js/popper.min.js') }}"></script>
  <script src="{{ asset('css/login/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('css/login/js/main.js') }}"></script>
  <script src="{{ asset('js/toaster.min.js') }}"></script>
  <script>
    @if(Session::has('success'))
   // console.log('Hi');
   toastr.success("{{ Session::get('success') }}") ;
@endif
@if(Session::has('error'))
   // console.log('Hi');
   toastr.error("{{ Session::get('error') }}") ;
@endif
 </script>
    
  </body>
</html>