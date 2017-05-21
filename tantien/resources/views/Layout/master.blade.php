<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link href="{{ TUrl::asset('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link href="{{ TUrl::asset('plugins/adminLTE/css/AdminLTE.min.css') }}" rel="stylesheet">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link href="{{ TUrl::asset('plugins/adminLTE/css/skins/_all-skins.min.css') }}" rel="stylesheet">
  <link href="{{ TUrl::asset('plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet">
  <!-- Customer -->
  <link href="{{ TUrl::asset('css/main.css') }}" rel="stylesheet">
  <!-- Select 2 -->
  <link href="{{ TUrl::asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="../../index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>TT</b>sl</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>TanTien </b>solution</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li>
          <a href="#">
            <i class="fa fa-th"></i><span>{{ __('index.drugOrder') }}</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
        <div>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-home"></i></a></li>
                <li class="active">@yield('title')</li>
            </ol>
        </div>
    </section>
    <section class="content search-form">
        @include($controller . '.search')
    </section>
    <section class="content data-list" id="{{$controller}}DataList"></section>
    <section class="content">
        <div class="modal fade {{$controller}}" role="dialog" id="add{{$controller}}Modal"></div>
    </section>
    <section class="content">
        <div class="modal fade {{$controller}}" role="dialog" id="edit{{$controller}}Modal"></div>
    </section>
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; 2017-2020</strong> quoctung1194@gmail.com.
  </footer>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<script>
    var base_url = "{{ App::make('url')->to('/') }}";
    var logoutAlert = "{{ __('index.Your session is end. You will be redirected to login page!') }}";
    var notFoundAlert = "{{ __('index.The required page is not found. Please contact IT for supporting') }}"
    var base_controller = "{{ $controller }}";
</script>
<!-- jQuery 2.2.3 -->
<script src="{{ TUrl::asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ TUrl::asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ TUrl::asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ TUrl::asset('plugins/fastclick/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ TUrl::asset('plugins/adminLTE/js/app.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ TUrl::asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ TUrl::asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<!-- Select 2 -->
<script src="{{ TUrl::asset('plugins/select2/js/select2.min.js') }}"></script>
<!-- JQuery Validator -->
<script src="{{ TUrl::asset('plugins/jQueryValidator/jquery.validate.min.js') }}"></script>
<!-- Main javascript -->
<script src="{{ TUrl::asset('js/functions.js') }}"></script>
<script src="{{ TUrl::asset('js/main.js') }}"></script>
@yield('javascript')
</body>
</html>
