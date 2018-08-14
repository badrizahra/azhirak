@extends('admin.Layouts.master')
@section('title','ویرایش نمونه کار وب')
@section('header')

@endsection
@section('content')

    <div id="content">
        <div class="page-header">
            <div class="container-fluid">

                <div class="pull-right">

                    <a href="" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="بارگذاری مجدد"><i class="fa fa-refresh"></i></a>
                    <a href="" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="لغو"><i class="fa fa-reply"></i></a>
                </div>
                <ul class="breadcrumb">
                    <li><a href="">خانه</a></li>
                    <li><a href="">مدیریت تماس ها</a></li>
                    <li><a href="">تماس با بخش شبکه</a></li>
                </ul>
            </div>
        </div>

        <div class="container-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-pencil"></i> مشاهده پیام : {{ $item->subject }} از : {{ $item->name }}</h3>
                </div>
                <div class="panel-body">   
                    
                    <p>
                        {{ $item->description }}
                    </p>

                    {{--session messages--}}
                    @if(Session::has('message'))
                    @component('component.alert',['type'=> Session::get("type")  ])
                        {{ Session::get('message') }}
                    @endcomponent
                @endif
                </div>

            </div>
        </div>
    </div>
@endsection





