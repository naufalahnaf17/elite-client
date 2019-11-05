<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('asset_elite/node_modules/bootstrap/dist/css/bootstrap.min.css') }}" >

    <title>Login Admin</title>
  </head>
  <body>
  <div class="row" style='margin:100px;'>
       <div class="col-md-4" style='margin:0px auto'>
            <h3 class='my-4'>Login Form</h3>
            <form id='loginForm' action="{{ url('/login') }}" method='post'>
                @csrf
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
       </div>
  </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('asset_elite/node_modules/jquery/jquery-3.2.1.min.js') }}" ></script>
    <script src="{{ asset('asset_elite/node_modules/popper/popper.min.js') }}" ></script>
    <script src="{{ asset('asset_elite/node_modules/bootstrap/dist/js/bootstrap.min.js') }}" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        $('#email').on('keydown',function(e){
            if (e.which == 13) {
                $('#password').focus();
                return false;
            }
        })
        $('#password').on('keydown', function(i) {
            if (i.which == 13) {
                $('#loginForm').submit();
            }
        });
    </script>
  </body>
</html>
