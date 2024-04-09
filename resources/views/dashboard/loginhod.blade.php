@include('dashboard.header')
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

      

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar  static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <div class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">


                    <li class="nav-item ">
                            <a class="nav-link" href="{{URL('/')}}/login" >
                                Student login
                                </a>
                            </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{URL('/')}}/supervisorlogin" >
                                Supervisor login
                                </a>
                            </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{URL('/')}}/hodlogin" >
                               Hod login
                                </a>
                            </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{URL('/')}}/deanlogin" >
                                dean login
                                </a>
                            </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{URL('/')}}/graduatelogin" >
                                Graduate sector login
                                </a>
                            </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{URL('/')}}/adminlogin" >
                                Admin login
                                </a>
                            </li>
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
                                <img class="img-profile rounded-circle"
                                    src="{{url('/')}}/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>
                </nav>
                



                <style>
    /* Custom styles for the login page */
    body {
        background-color: #f8f9fa;
    }

    .login-container {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        margin-top: 100px;
    }

    .login-btn {
        transition: all 0.3s ease;
    }

    .login-btn:hover {
        transform: scale(1.1);
    }
</style>
</head>
<body>
<div class="container p-3">
    @if(session('message'))
    <div class="alert {{session('alert-class')}} text-center">{{session('message')}}</div>
    @endif
</div>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="login-container">
                <h3 class="text-center mb-4">HOD LOGIN</h3>
                <form method="POST">
                @csrf
                    <div class="form-group">
                        <label for="username">PAYROLL NUMBER</label>
                        <input type="text" name="payroll_no" id="regno" class="form-control mb-2" placeholder="Enter your registration number">
                        @if($errors->has('payroll_no'))
                        <span class="errormsg alert alert-danger text-danger">{{ $errors->first('payroll_no') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password">
                    </div>
                    @if($errors->has('password'))
                    <span class="errormsg alert alert-danger text-danger">{{ $errors->first('password') }}</span>
                    @endif
                    <button type="submit" class="btn btn-primary btn-block login-btn">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>



@include('dashboard.footer')

