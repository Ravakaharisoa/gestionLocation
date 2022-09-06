<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <link rel="stylesheet" type="text/css" href="{{mix('css/app.css')}}">
  @livewireStyles
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
  <!-- Navbar -->
    <x-topnav />
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <span class="brand-text font-weight-bold" style="font-size: 1.3rem">GeLocation</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('photos_users/user1.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{userFullName()}}</a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <x-menu />
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row col-md-12">
          @yield('contenu')
        </div>
      </div>
    </section>
  </div>
  <x-footer />
  <!-- Control Sidebar -->
  <x-sidebar />
</div>
<script src="{{mix('js/app.js')}}"></script>
@livewireScripts
</body>
</html>
