@extends('admin.Layouts.master')
@section('title','درج نمونه کار گرافیک')
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
                    <li><a href="">مدیریت نمونه کارهای گرافیک</a></li>
                </ul>
            </div>
        </div>

        <div class="container-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-pencil"></i>لیست نمونه کار گرافیک</h3>
                </div>
                <div class="panel-body">
                    <div class="box-body">
                        <ul>
                            @foreach ($graphicSamples as $graphicSample)
                                <li><a href="graphicsamples/{{ $graphicSample->id }}/edit"> {{ $graphicSample->title }} </a> </li>
                            @endforeach
                        </ul>
                    </div>

                    @if (session()->has('message'))
                        <div style="width: 80%; margin: auto;" class="alert {{ session()->get('type') }}">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection


