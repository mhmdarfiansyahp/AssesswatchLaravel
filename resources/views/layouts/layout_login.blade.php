<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />

	{{-- <title><?php echo isset($title) ? $title . ' - ' . $this->config->item('title_app') : $this->config->item('title_app'); ?></title> --}}

    <link rel="shortcut icon" href="{{ asset('assets/image/Logo_ASTRAtech.png') }}">
    <link href="{{ asset('assets/Plugins/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/Plugins/font-awesome-4.7.0/css/font-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/Content/jquery.fancybox.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/Content/bootstrap-select.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/Styles/Style.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/Scripts/tether/tether.min.js') }}"></script>
    <script src="{{ asset('assets/Scripts/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('assets/Scripts/jquery-ui-1.12.1.min.js') }}"></script>
    <script src="{{ asset('assets/Plugins/bootstrap-4.0.0-alpha.6-dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/Plugins/Highcharts-5.0.14/code/highcharts.js') }}"></script>
    <script src="{{ asset('assets/Plugins/Highcharts-5.0.14/code/highcharts-more.js') }}"></script>
    <script src="{{ asset('assets/Plugins/Highcharts-5.0.14/code/modules/solid-gauge.js') }}"></script>
    <script src="{{ asset('assets/Scripts/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/Scripts/jquery.fancybox.pack.js') }}"></script>
    <script src="{{ asset('assets/Scripts/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('assets/Scripts/LetterAvatar.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>
    <!-- jangan lupa menambahkan script js sweet alert di bawah ini  -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>

    <style type="text/css">
        .btn:hover {
          cursor: pointer;
        }
    </style>
</head>

<body style="background-image: url('assets/Images/IMG_Background.jpg'); background-repeat: no-repeat; background-size: cover;">
    <div class="polman-nav-static-top" style="opacity: 0.9;">
        <div class="float-left">
            <a>
                <img src="{{asset('assets/image/palingbaru_logo.png') }}" style="height: 50px;" />
            </a>
        </div>
    </div>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('login.action')}}" method="POST">
        @csrf
        <div class="polman-form-login">
            <h4>Please Login</h4>
            <hr />
    
            <div class="form-group">
                <label for="Username">
                    Username
                    <span style="color: red;">*</span>
                </label>
                <input type="text" id="Username" name="Username" value="{{ old ('Username')}}" maxlength="10" class="form-control">
            </div>
    
            <div class="form-group">
                <label for="Password">
                    Password
                    <span style="color: red;">*</span>
                </label>
                <input id="Password" type="Password" name="Password" class="form-control">
            </div>
    
            <a href="{{ route('dashboard1.index') }}" class="btn btn-secondary mb-1">Kembali</a>
            <button type="submit" id="btnLogin" class="btn btn-primary">Masuk</button>
        </div> 
    </form>
    <div class="mb-5"></div>
    

	<div class="mt-5" style="background-color: white; width: 100%; position: fixed; left: 0; bottom: 0;">
        <div class="container-fluid">
            <footer class="d-flex flex-wrap pt-3 pb-3 border-top">
                {{-- Copyright &copy; <?php echo date('Y'); ?> - MIS Politeknik Astra --}}
            </footer>
        </div>
    </div>

</body>
</html>

@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2000
    });
</script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif