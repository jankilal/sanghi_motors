<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- Styles -->
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

      <!-- Bootstrap -->
    <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('css/font-awesome/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('css/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    
    <link href="{{ asset('plugins/iCheck/skins/flat/green.css') }}" rel="stylesheet">
   
    <!-- JQVMap -->
    <link href="{{ asset('plugins/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
   
    <!-- JQVMap -->
    <link href="{{ asset('plugins/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}" />
     <!-- Datatables -->
    <link href="{{ asset('plugins/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    @yield('style_script')
    <script type="text/javascript">
        var csrfToken = '{!! csrf_token() !!}';
    </script>
</head>
<body class="nav-md">
<div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                  <a href="#" class="site_title"><i class="fa fa-paw"></i> <span>Sanghi Motors</span></a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile clearfix">
                  <div class="profile_pic">
                    <img src="{{ asset('images/user.png') }}" alt="..." class="img-circle profile_img">
                  </div>
                  <div class="profile_info">
                    <span>Welcome,</span>
                    <h2> 
                        @if(Auth::check())
                            {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                        @endif
                    </h2>
                  </div>
                </div>
                <!-- /menu profile quick info -->
                <br />
               
                <!-- Navigation Section -->
                @include('layouts.admin.navigation',array('items' => \Config::get('navigation.admin'), 'level' => 'third'))
                <!-- end of navigation section -->
            </div>
        </div>
         <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="assets/images/img.jpg" alt=""> @if(Auth::check())
                            {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                        @endif &nbsp;&nbsp;
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"><i class="fa fa-user pull-right"></i> Profile</a></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

<!-- Main Wrapper -->
<div id="wrapper">
    @yield('content')
    @include('layouts.admin.footer')
</div>
<!-- End of Main Wrapper -->

<!-- Bootstrap -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('plugins/fastclick/fastclick.js') }}"></script>
<!-- NProgress -->
<script src="{{ asset('js/nprogress.js') }}"></script>
<!-- Chart.js -->
<script src="{{ asset('plugins/Chart/Chart.min.js') }}"></script>
<!-- gauge.js -->
<script src="{{ asset('plugins/gauge/gauge.min.js') }}"></script>
 <!-- Flot -->
<script src="{{ asset('plugins/Flot/jquery.flot.js') }}"></script>
<script src="{{ asset('plugins/Flot/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('plugins/Flot/jquery.flot.time.js') }}"></script>
<script src="{{ asset('plugins/Flot/jquery.flot.stack.js') }}"></script>
<script src="{{ asset('plugins/Flot/jquery.flot.resize.js') }}"></script>
<!-- Flot plugins -->
<script src="{{ asset('plugins/flot-orderbars/js/jquery.flot.orderBars.js') }}"></script>
<script src="{{ asset('plugins/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
<script src="{{ asset('plugins/flot-curvedlines/curvedLines.js') }}"></script>
<!-- DateJS -->
<script src="{{ asset('plugins/DateJS/build/date.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/dist/jquery.vmap.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/dist/jquery.vmap.sampledata.js') }}"></script>
<!-- bootstrap-daterangepicker -->
<script src="{{ asset('plugins/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>


<!-- bootstrap-progressbar -->
<script src="{{ asset('plugins/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>

<!-- Bootstrap Datatables Scripts -->
<script src="{{ asset('plugins/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-bs/js/responsive.bootstrap.js') }}"></script>
<!-- Datatables -->
<script src="{{ asset('plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
<!-- Skycons -->
<script src="{{ asset('plugins/skycons/skycons.js') }}"></script>

<!-- Custom Theme Scripts -->
<script src="{{ asset('js/custom.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

<script src="{{ asset('plugins/toastr/build/toastr.min.js') }}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });
    $('.dataTable').DataTable();
</script>
<script>
    $("#msg_div").fadeOut(4000);
    $(document).ready(function(){
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 4000
        };

        @if(session('success'))
        toastr.success("{!! session('success') !!}", "{!! trans('admin.success') !!}");
        @endif
        @if(session('error'))
        toastr.error("{!! session('error') !!}", "{!! trans('admin.error') !!}");
        @endif

        $('.childUl li.active').parent().closest('li').addClass('active');
        $('.childUl li.active').parent().addClass('in');
    });
    setInterval(function(){ $('#demo-star').toggleClass('text-success'); }, 300);

    $(document).ready(function () {

        $(document).on("click", ".btn-delete", function (e) {
            $url = $(this).attr('href');
            $id = $(this).data('id');
            alert(url);
            return false;
            e.preventDefault();
            swal({
                    title: "Are you sure you wish to perform this action?",
                    text: "Your will not be able to recover this Record!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!"
                },
                function () {
                    $.ajax({
                        url: $url,
                        type: 'POST',  // Destroy records
                        dataType: 'json',
                        data: {_token: csrfToken, _method: 'delete'},
                        success: function (response) {
                            afterDeleteSuccess(response)
                        },
                        error: function () {
                            afterDeleteError();
                        }
                    });
                });
        });

    })
</script>
@yield('footer_script')

</body>
</html>
