<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{{ trans('panel.site_title') }}</title>
	<!-- core:css -->
	<link rel="stylesheet" href="{{ asset('assets/vendors/core/core.css') }}">
	<!-- endinject -->
	<!-- plugin css for this page -->
	<link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/DataTables-1.10.25/css/dataTables.bootstrap4.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Select-1.3.3/css/select.bootstrap4.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Scroller-2.0.4/css/scroller.bootstrap4.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Responsive-2.2.9/css/responsive.bootstrap4.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/RowReorder-1.2.8/css/rowReorder.bootstrap4.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/SearchBuilder-1.1.0/css/searchBuilder.bootstrap4.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Buttons-1.7.1/css/buttons.bootstrap4.css') }}">
	<!-- end plugin css for this page -->
	<!-- inject:css -->
	<link rel="stylesheet" href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
	<!-- endinject -->
  <!-- Layout styles -->  
	<link rel="stylesheet" href="{{ asset('assets/css/demo_1/style.css') }}">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">

  @if(app()->getLocale() == 'kh')
    <style>
      @font-face {
        font-family: khmerFOnt;
        src: url(../../assets/fonts/khmer-font/Normal/OpenKhmerSchool-Regular.ttf);
      }
      body{
        font-family: khmerFOnt;
      }
    </style>
  @endif

  @yield('styles')
</head>
<body>
	<div class="main-wrapper">

		<!-- partial:../../partials/menu.blade.php -->
    @include('partials.menu')

    <nav class="settings-sidebar">
      <div class="sidebar-body">
        <a href="#" class="settings-sidebar-toggler">
          <i data-feather="settings"></i>
        </a>
        <h6 class="text-muted">Sidebar:</h6>
        <div class="form-group border-bottom">
          <div class="form-check form-check-inline">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarLight" value="sidebar-light" checked>
              Light
            </label>
          </div>
          <div class="form-check form-check-inline">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarDark" value="sidebar-dark">
              Dark
            </label>
          </div>
        </div>
        <div class="theme-wrapper">
          <h6 class="text-muted mb-2">Light Theme:</h6>
          <a class="theme-item active" href="demo_1/dashboard-one.html">
            <img src="{{ asset('assets/images/screenshots/light.jpg') }}" alt="light theme">
          </a>
          <h6 class="text-muted mb-2">Dark Theme:</h6>
          <a class="theme-item" href="demo_2/dashboard-one.html">
            <img src="{{ asset('assets/images/screenshots/dark.jpg') }}" alt="light theme">
          </a>
        </div>
      </div>
    </nav>
		<!-- partial -->
	
		<div class="page-wrapper">
				
			<!-- partial:../../partials/_navbar.html -->
			<nav class="navbar">
				<a href="#" class="sidebar-toggler">
					<i data-feather="menu"></i>
				</a>
				<div class="navbar-content">
					<form class="search-form">
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text">
									<i data-feather="search"></i>
								</div>
							</div>
							<input type="text" class="form-control" id="navbarForm" placeholder="Search here...">
						</div>
					</form>
					<ul class="navbar-nav">
            <!-- Nav bar dropdown Lang-switch part --> 
            @include('partials.nav-lang')

            <!-- Nav bar dropdown alert part --> 
            @include('partials.nav-notify')

            <!-- Nav bar dropdown profile part --> 
            @include('partials.nav-profile')

					</ul>
				</div>
			</nav>
			<!-- partial -->

			<div class="page-content">
        @yield('content')
			</div>

			<!-- partial:../../partials/_footer.html -->
			<footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between">
				<p class="text-muted text-center text-md-left">Copyright © 2021 <a href="https://www.nobleui.com" target="_blank">NobleUI</a>. All rights reserved</p>
				<p class="text-muted text-center text-md-left mb-0 d-none d-md-block">Handcrafted With <i class="mb-1 text-primary ml-1 icon-small" data-feather="heart"></i></p>
			</footer>
			<!-- partial -->
      <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
      </form>
	
		</div>
	</div>

	<!-- core:js -->
	<script src="{{ asset('assets/vendors/core/core.js') }}"></script>
	<!-- endinject -->
	<!-- plugin js for global -->
	<script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
	<script src="{{ asset('assets/vendors/DataTables/DataTables-1.10.25/js/jquery.dataTables.js') }}"></script>
	<script src="{{ asset('assets/vendors/DataTables/DataTables-1.10.25/js/dataTables.bootstrap4.js') }}"></script>
	<script src="{{ asset('assets/vendors/DataTables/Select-1.3.3/js/dataTables.select.js') }}"></script>
	<script src="{{ asset('assets/vendors/DataTables/Select-1.3.3/js/select.bootstrap4.js') }}"></script>
	<script src="{{ asset('assets/vendors/DataTables/Scroller-2.0.4/js/scroller.bootstrap4.js') }}"></script>
	<script src="{{ asset('assets/vendors/DataTables/Responsive-2.2.9/js/dataTables.responsive.js') }}"></script>
	<script src="{{ asset('assets/vendors/DataTables/Responsive-2.2.9/js/responsive.bootstrap4.js') }}"></script>
	<script src="{{ asset('assets/vendors/DataTables/RowReorder-1.2.8/js/dataTables.rowReorder.js') }}"></script>
	<script src="{{ asset('assets/vendors/DataTables/RowReorder-1.2.8/js/rowReorder.bootstrap4.js') }}"></script>
	<script src="{{ asset('assets/vendors/DataTables/SearchBuilder-1.1.0/js/dataTables.searchBuilder.js') }}"></script>
	<script src="{{ asset('assets/vendors/DataTables/SearchBuilder-1.1.0/js/searchBuilder.bootstrap4.js') }}"></script>
	<script src="{{ asset('assets/vendors/DataTables/Buttons-1.7.1/js/dataTables.buttons.js') }}"></script>
	<script src="{{ asset('assets/vendors/DataTables/Buttons-1.7.1/js/buttons.bootstrap4.js') }}"></script>
	<script src="{{ asset('assets/vendors/DataTables/Buttons-1.7.1/js/buttons.colVis.js') }}"></script>
	<script src="{{ asset('assets/vendors/DataTables/Buttons-1.7.1/js/buttons.html5.js') }}"></script>
	<script src="{{ asset('assets/vendors/DataTables/Buttons-1.7.1/js/buttons.print.js') }}"></script>
	<script src="{{ asset('assets/vendors/DataTables/JSZip-2.5.0/jszip.js') }}"></script>
	<script src="{{ asset('assets/vendors/DataTables/pdfmake-0.1.36/pdfmake.js') }}"></script>
	
  	<!-- end plugin js for global -->
	<!-- inject:js -->
	<script src="{{ asset('assets/vendors/feather-icons/feather.min.js') }}"></script>
	<script src="{{ asset('assets/js/template.js') }}"></script>
	{{-- <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.js') }}"></script> --}}
	<!-- endinject -->
	<!-- custom js for this page -->
  	<!-- end custom js for this page -->
	<script src="{{ asset('assets/js/select2.js') }}"></script>
	{{-- <script src="{{ asset('assets/js/data-table.js') }}"></script> --}}
  
  @yield('scripts')
</body>
</html>