<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav   sidebar  accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center mb-2" href="{{url('/')}}/dashboard/">
            <img data-aos="flip-up" style="width:40%;" class="img-fluid" src="{{url('/')}}/img/logo.jpg" alt="">
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
     
            @if( session('role') == "admin")
            <li class="nav-item ">
            <div class="sidebar-heading ">
               ADMIN SECTION
            </div>
                <a class="nav-link" href="{{url('/')}}/dashboard/">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
                    <a class="nav-link " href="{{url('/')}}/dashboard/students"  
                   >
                    <i class="fas fa-fw fa-users"></i>
                    <span>Assign Students</span>
                   
                </a>
            </li>
            @endif
           


            @if( session('role') != "student")
            <li class="nav-item">
            <div class="sidebar-heading">
              STUDENT PROGRESS REPORT
            </div>
                <a class="nav-link " href="{{url('/')}}/dashboard/report"  
                   >
                    <i class="fa fa-flag"></i>
                    <span>Report section</span>
                   
                </a>
             
            </li>
            @endif

            @if( session('role') == "graduate")
            <!-- Divider -->
            
            <div class="sidebar-heading">
               GRADUATE SECTION
            </div>
            <li class="nav-item">
                <a class="nav-link " href="{{url('/')}}/graduate/section"  
                   >
                    <i class="fas fa-fw fa-users"></i>
                    <span>Graduate section</span>
                   
                </a>
             
            </li>
            @endif


            @if( session('role') == "dean")
            <!-- Divider -->
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
            SUPERVISOR(DEAN)
            </div>
            <li class="nav-item">
                <a class="nav-link " href="{{url('/')}}/dean/section"  
                   >
                    <i class="fas fa-fw fa-users"></i>
                    <span>SUPERVISOR(DEAN)</span>
                   
                </a>
             
            </li>
            @endif

            @if( session('role') == "hod")
             <!-- Divider -->
             <hr class="sidebar-divider">
              <!-- Heading -->
              <div class="sidebar-heading">
              SUPERVISOR(HOD)
            </div>

            <!-- Nav Item - Pages Collapse Menu -->

            
            <li class="nav-item">
                <a class="nav-link " href="{{url('/')}}/hod/section"  
                   >
                    <i class="fas fa-fw fa-users"></i>
                    <span>SUPERVISOR(HOD)</span>
                   
                </a>
             
            </li>
            @endif

            <!-- Divider -->
            @if( session('role') == "supervisor")
            <hr class="sidebar-divider">

            
            <!-- Heading -->
            <div class="sidebar-heading">
                SUPERVISOR SECTION
            </div>

            <!-- Nav Item - Pages Collapse Menu -->

            <li class="nav-item">
                <a class="nav-link " href="{{url('/')}}/supervisors/section"  
                   >
                    <i class="fas fa-fw fa-users"></i>
                    <span>Supervisors section</span>
                   
                </a>
             
            </li>
            @endif

        


            <!-- Divider -->
            @if( session('role') == "student")
            <hr class="sidebar-divider">

            
            <!-- Heading -->
            <div class="sidebar-heading">
               Student Section
            </div>
            <li class="nav-item">
                <a class="nav-link" href="{{URL('/')}}/dashboard/assignedSupervisors" >
                    <i class="fas fa-fw fa-users"></i>
                    <span>Assigned Supervisors</span>
                </a>

            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{URL('/')}}/student/upload" >
                    <i class="fas fa-fw fa-users"></i>
                    <span>Upload Document</span>
                </a>

            </li>
            @endif

            <!-- Nav Item - Pages Collapse Menu -->
            <!--
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pages</span>
                </a>
            </li>
            -->

        
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

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
                        <li class="nav-item">
                        <a class="nav-link " href="{{url('/')}}/logout">Logout</a>
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
                