@extends('admin.Layouts.master')
@section('title',$title)
@section('content')
    <div id="content">
        <div class="page-header">
            <div class="container-fluid">
                {{--<div class="pull-right">--}}
                {{--<button type="button" data-toggle="tooltip" title="Filter" onclick="$('#filter-customer').toggleClass('hidden-sm hidden-xs');" class="btn btn-default hidden-md hidden-lg"><i class="fa fa-filter"></i></button>--}}

                {{--<a href="" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="بارگذاری مجدد"><i class="fa fa-refresh"></i></a>--}}
                {{--<a href="" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="بارگذاری مجدد"><i class="fa fa-refresh"></i></a>--}}

                {{--<a href="" data-toggle="tooltip" title="" class="btn btn-primary"><i class="fa fa-plus"></i></a>--}}
                {{--</div>--}}
                <ul class="breadcrumb">
                    <li><a href="">خانه</a></li>
                    <li><a href="">{{ $title }}</a></li>
                </ul>
            </div>

        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12  col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <h3 class="panel-title"><i class="fa fa-list"></i> {{ $title }} </h3>
                        </div>
                        <div class="panel-body">
                            {!! $grid !!}

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
        </div>
    </div>
@endsection