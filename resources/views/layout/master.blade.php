<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    @yield('meta')
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('asset_elite/images/favicon.png') }}">
    <title>@yield('title')</title>
    <!-- This page CSS -->
    <!-- chartist CSS -->
    <link href="{{ asset('asset_elite/node_modules/morrisjs/morris.css') }}" rel="stylesheet">
    <!--Toaster Popup message CSS -->
    <link href="{{ asset('asset_elite/node_modules/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('asset_elite/dist/css/style.min.css') }}" rel="stylesheet">
    <!-- Dashboard 1 Page CSS -->
    <link href="{{ asset('asset_elite/dist/css/pages/dashboard1.css') }}" rel="stylesheet">
    <style media="screen">
      a.rumah:hover{
        background-color: salmon;
        border-radius: 8px;
        padding: 2px;
      }

      .treeitem{
        cursor: pointer;
      }
    </style>

    <!-- Font Awesome CSS -->
    <link href="{{ asset('asset_elite/icons/font-awesome/css/fa-brands.css') }}" rel="stylesheet">
    <link href="{{ asset('asset_elite/icons/font-awesome/css/fa-regular.css') }}" rel="stylesheet">
    <link href="{{ asset('asset_elite/icons/font-awesome/css/fa-solid.css') }}" rel="stylesheet">
    <link href="{{ asset('asset_elite/icons/font-awesome/css/fontawesome.css') }}" rel="stylesheet">
    <link href="{{ asset('asset_elite/icons/font-awesome/css/fontawesome-all.css') }}" rel="stylesheet">
    <link href="{{ asset('asset_elite/icons/font-awesome/webfonts/fa-solid-900.woff2') }}" rel="stylesheet">
    <link href="{{ asset('asset_elite/icons/font-awesome/webfonts/fa-solid-900.ttf') }}" rel="stylesheet">
    <link href="{{ asset('asset_elite/icons/font-awesome/webfonts/fa-solid-900.woff') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('asset_elite/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
    <!-- Select 2 -->
    <link href="{{ asset('asset_elite/node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- SAI CSS -->
    <link href="{{ asset('asset_elite/dist/css/sai.css') }}" rel="stylesheet">
    <!-- Quill Theme included stylesheets -->
    <!-- Selectize -->
    <!-- <link href="{{ asset('asset_elite/selectize.bootstrap3.css') }}" rel="stylesheet"> -->
    <!-- Datepicker -->
    <link rel="stylesheet" href="{{ asset('asset_elite/bootstrap-datepicker.min.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

         <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('asset_elite/node_modules/jquery/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap popper Core JavaScript -->
    <script src="{{ asset('asset_elite/node_modules/popper/popper.min.js') }}"></script>
    <script src="{{ asset('asset_elite/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('asset_elite/dist/js/perfect-scrollbar.jquery.min.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('asset_elite/dist/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('asset_elite/dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('asset_elite/dist/js/custom.min.js') }}"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--morris JavaScript -->
    <script src="{{ asset('asset_elite/node_modules/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('asset_elite/node_modules/morrisjs/morris.min.js') }}"></script>
    <script src="{{ asset('asset_elite/node_modules/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <!-- Popup message jquery -->
    <script src="{{ asset('asset_elite/node_modules/toast-master/js/jquery.toast.js') }}"></script>
    <!-- Chart JS -->
    <script src="{{ asset('asset_elite/dist/js/dashboard1.js') }}"></script>
    <script src="{{ asset('asset_elite/node_modules/toast-master/js/jquery.toast.js') }}"></script>
    <!-- Datatable -->

    <script src="{{ asset('asset_elite/node_modules/datatables.net/js/jquery.dataTables.min.js') }}"></script>
</head>

<body class="skin-default fixed-layout">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Elite admin</p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header bg-blue">
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="{{ asset('asset_elite/images/logo-icon.png') }}" alt="homepage" class="dark-logo" />
                            <!-- Light Logo icon -->
                            <img src="{{ asset('asset_elite/images/logo-light-icon.png') }}" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text --><span>
                         <!-- dark Logo text -->
                         <img src="{{ asset('asset_elite/images/logo-text.png') }}" alt="homepage" class="dark-logo" />
                         <!-- Light Logo text -->
                         <img src="{{ asset('asset_elite/images/logo-light-text.png') }}" class="light-logo" alt="homepage" /></span> </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <li class="nav-item">
                            <form class="app-search d-none d-md-block d-lg-block">
                                <input type="text" class="form-control" placeholder="Search & enter">
                            </form>
                        </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="ti-email"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <!-- Message -->
                                            <a href="javascript:void(0)">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Luanch Admin</h5> <span class="mail-desc">Just see the my new admin!</span> <span class="time">9:30 AM</span> </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="javascript:void(0)">
                                                <div class="btn btn-success btn-circle"><i class="ti-calendar"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Event today</h5> <span class="mail-desc">Just a reminder that you have event</span> <span class="time">9:10 AM</span> </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="javascript:void(0)">
                                                <div class="btn btn-info btn-circle"><i class="ti-settings"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Settings</h5> <span class="mail-desc">You can customize this template as you want</span> <span class="time">9:08 AM</span> </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="javascript:void(0)">
                                                <div class="btn btn-primary btn-circle"><i class="ti-user"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center link" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->

                        <!-- User Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('asset_elite/images/users/1.jpg') }}" alt="user" class=""> <span class="hidden-md-down">{{ Session::get('nama') }} &nbsp;<i class="fa fa-angle-down"></i></span> </a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                <!-- text-->
                                <a href="javascript:void(0)" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
                                <!-- text-->
                                <a href="javascript:void(0)" class="dropdown-item"><i class="ti-wallet"></i> My Balance</a>
                                <!-- text-->
                                <a href="javascript:void(0)" class="dropdown-item"><i class="ti-email"></i> Inbox</a>
                                <!-- text-->
                                <div class="dropdown-divider"></div>
                                <!-- text-->
                                <a href="javascript:void(0)" class="dropdown-item"><i class="ti-settings"></i> Account Setting</a>
                                <!-- text-->
                                <div class="dropdown-divider"></div>
                                <!-- text-->
                                <a href="{{url('/logout')}}"  class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                                <!-- text-->
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End User Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item right-side-toggle"> <a class="nav-link  waves-effect waves-light" href="javascript:void(0)"><i class="ti-settings"></i></a></li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav id="nav" class="sidebar-nav">
                    <ul id="sidebar-nav">


                      <?php if (Session::get('menu_siswa')): ?>

                        <li>
                          <a class="waves-effect waves-dark" aria-expanded="false" href="{{ url('/') }}">
                            <span class="hide-menu">Dashboard</span>
                          </a>
                        </li>

                          <li id="menu-1"> <a class="has-arrow waves-effect waves-dark" aria-expanded="false"><i class="icon-notebook"></i><span class="hide-menu">Master Data</span></a>
                              <ul id="list-1" aria-expanded="false" class="collapse">
                                <?php $i = 0 ?>
                                <?php foreach ($menu_siswa['MenuSatu'] as $a): ?>
                                  <li><a href="{{ url($form_siswa['FormSatu'][$i++]['nama_form']) }}">{{ $a['nama'] }}</a></li>
                                <?php endforeach; ?>
                              </ul>
                          </li>

                          <li id="menu-2"> <a class="has-arrow waves-effect waves-dark" aria-expanded="false"><i class="icon-notebook"></i><span class="hide-menu">Transaksi</span></a>
                              <ul id="list-2" aria-expanded="false" class="collapse">
                                <?php $i = 0 ?>
                                <?php foreach ($menu_siswa['MenuDua'] as $a): ?>
                                  <li><a href="{{ url($form_siswa['FormDua'][$i++]['nama_form']) }}">{{ $a['nama'] }}</a></li>
                                <?php endforeach; ?>
                              </ul>
                          </li>

                          <li id="menu-3"> <a class="has-arrow waves-effect waves-dark" aria-expanded="false"><i class="icon-notebook"></i><span class="hide-menu">Laporan</span></a>
                              <ul id="list-3" aria-expanded="false" class="collapse">
                                <?php $i = 0 ?>
                                <?php foreach ($menu_siswa['MenuTiga'] as $a): ?>
                                  <li><a href="{{ url($form_siswa['FormTiga'][$i++]['nama_form']) }}">{{ $a['nama'] }}</a></li>
                                <?php endforeach; ?>
                              </ul>
                          </li>

                      <?php endif; ?>

                      <?php if (Session::get('menu_admin')): ?>

                        <li>
                          <a class="waves-effect waves-dark" aria-expanded="false" href="{{ url('/') }}">
                            <span class="hide-menu">Dashboard</span>
                          </a>
                        </li>

                        <li id="menu-3"> <a class="has-arrow waves-effect waves-dark" aria-expanded="false"><i class="icon-notebook"></i><span class="hide-menu">Laporan</span></a>
                            <ul id="list-3" aria-expanded="false" class="collapse">
                              <?php $i = 0 ?>
                              <?php foreach ($menu_admin['AdminMenu'] as $a): ?>
                                <li><a href="{{ url($form_admin['FormSatu'][$i++]['nama_form']) }}">{{ $a['nama'] }}</a></li>
                              <?php endforeach; ?>
                            </ul>
                        </li>

                      <?php endif; ?>

                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                @yield('container')
                <!-- End Page Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->

    <script type="text/javascript">

      $('#list-1').hide();

      $('#menu-1').on('click' , function(){
          $('#list-1').toggle();
      });

      $('#list-2').hide();

      $('#menu-2').on('click' , function(){
          $('#list-2').toggle();
      });

      $('#list-3').hide();

      $('#menu-3').on('click' , function(){
          $('#list-3').toggle();
      });

      $('#list-4').hide();

      $('#menu-4').on('click' , function(){
          $('#list-4').toggle();
      });

      $('#list-5').hide();

      $('#menu-5').on('click' , function(){
          $('#list-5').toggle();
      });

      $('#list-6').hide();

      $('#menu-6').on('click' , function(){
          $('#list-6').toggle();
      });

      $('#list-7').hide();

      $('#menu-7').on('click' , function(){
          $('#list-7').toggle();
      });

      $('#list-8').hide();

      $('#menu-8').on('click' , function(){
          $('#list-8').toggle();
      });

      $('#list-9').hide();

      $('#menu-9').on('click' , function(){
          $('#list-9').toggle();
      });

      $('#list-10').hide();

      $('#menu-10').on('click' , function(){
          $('#list-10').toggle();
      });


    </script>

</body>

</html>
