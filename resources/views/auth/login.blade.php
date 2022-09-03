<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{!! asset('logo.png') !!}" type="image/x-icon" />
    <!-- Fonts and icons -->
    <script src="{!! asset('public/atlantis/assets/js/plugin/webfont/webfont.min.js') !!}"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ['{!! asset('public/atlantis/assets/css/fonts.min.css') !!}']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{!! asset('public/atlantis/assets/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('public/atlantis/assets/css/atlantis.css') !!}">
</head>

<body class="login">
    <div class="wrapper wrapper-login">
        <div class="container container-login animated fadeIn">
            <p style="text-align: center"><img src="{{ asset('logo.png') }}" style="width: 70%" alt=""></p>
            {{-- <h3 class="text-center">Tiket Online</h3> --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="login-form">
                    <div class="form-group">
                        <label for="username" class="placeholder"><b>Email</b></label>
                        <input id="email" name="email" type="text"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                            required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password" class="placeholder"><b>Password</b></label>
                        <a href="#" class="link float-right">Forget Password ?</a>
                        <div class="position-relative">
                            <input id="password" name="password" type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                autocomplete="current-password" required>
                            <div class="show-password">
                                <i class="icon-eye"></i>
                            </div>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group form-action-d-flex mb-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="rememberme">
                            <label class="custom-control-label m-0" for="rememberme">Remember Me</label>
                        </div>
                        <button type="submit" class="btn btn-primary col-md-5 float-right mt-3 mt-sm-0 fw-bold">Sign
                            In</button>
                    </div>
                    {{-- <div class="view-profile">
                        <a href="{!! route('google.login') !!}"
                            class="btn btn-danger btn-block float-right mt-3 mt-sm-0">Login With Gmail</a>
                    </div> --}}
                    {{-- <div class="login-account">
					<span class="msg">Don't have an account yet ?</span>
					<a href="#" id="show-signup" class="link">Sign Up</a>
				</div> --}}
                </div>
            </form>
        </div>



    </div>
    <script src="{!! asset('public/atlantis/assets/js/core/jquery.3.2.1.min.js') !!}"></script>
    <script src="{!! asset('public/atlantis/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') !!}"></script>

    <script src="{!! asset('public/atlantis/assets/js/core/popper.min.js') !!}"></script>
    <script src="{!! asset('public/atlantis/assets/js/core/bootstrap.min.js') !!}"></script>
    <script src="{!! asset('public/atlantis/assets/js/atlantis.min.js') !!}"></script>
</body>

</html>
