<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>@yield('title')</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <script src="{{ asset('/assets/files/jquery/jquery-2.1.1.min.js') }}"></script>
    <script src="{{ asset('/assets/files/bootstrap/js/bootstrap.min.js') }}"></script>
    <link href="{{ asset('/stylesheet/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/files/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <script src="{{ asset('/assets/files/jquery/datetimepicker/moment/moment.min.js') }}"></script>
    <script src="{{ asset('/assets/files/jquery/datetimepicker/moment/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('/assets/files/jquery/datetimepicker/persian-date.min.js') }}"></script>
    <script src="{{ asset('/assets/files/jquery/datetimepicker/persian-datepicker.min.js') }}"></script>
    <link href="{{ asset('/assets/files/jquery/datetimepicker/persian-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/stylesheet/stylesheet.css') }}" rel="stylesheet">
    <script src="{{ asset('/assets/files/common.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('/assets/files/select2/css/select2.min.css') }}">
    <script src="{{ asset('/assets/files/select2/js/select2.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('/stylesheet/bootstrap-rtl.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main-front.css') }}">
    @yield('header')
</head>

<body>
<div id="container">
    <header id="header" class="navbar navbar-static-top">

        <div class="container-fluid">
            <div id="header-logo" class="navbar-header">
                <a href=""
                   class="navbar-brand" style="float: right !important;"><img style="width: 100px !important;" src="{{ asset('/image/logo.png') }}" alt="" title=""/></a>
            </div>
            <a href="#" id="button-menu" class="hidden-md hidden-lg"><span class="fa fa-bars"></span></a>


            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><img
                                src="{{ asset($user->img)}}" alt="" title="admin"
                                id="user-profile" class="img-circle"/>{{$user->first_name}}  {{$user->last_name}} <i
                                class="fa fa-caret-down fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <a href="">
                                    <i class="fa fa-user-circle-o fa-fw"></i>                                       ویرایش پروفایل
                                 </a>
                            </li>

                    </ul>
                </li>
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out"></i> <span class="hidden-xs hidden-sm hidden-md">خروج</span></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </div>
    </header>