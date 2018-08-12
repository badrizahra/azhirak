@extends('admin.Layouts.master')
@section('title','درج نمونه کار شبکه')
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
                    <li><a href="">مدیریت نمونه کارهای شبکه</a></li>
                </ul>
            </div>
        </div>

        <div class="container-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-pencil"></i>درج نمونه کار شبکه</h3>
                </div>
                <div class="panel-body">
                    <form action="/admin/networksamples" method="POST" enctype="multipart/form-data">

                        {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group row">
                            <label class="col-md-2"> عنوان</label>
                            <input type="text" name="title" id="title" class="form-control col-md-7">
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2"> توضیحات</label>
                            <input type="text" name="description" id="description" class="form-control col-md-7">
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2"> آدرس شبکه سایت</label>
                            <input type="text" name="url" id="url" class="form-control col-md-7">
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2"> آپلود تصویر</label>
                            <input type="file" name="image">
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2">وضعیت</label>
                            <select name="status_id" id="status_id" class="form-control col-md-7">
                                @foreach ($status as $stat)
                                    <option value="{{ $stat->id }}">{{ $stat->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2">تگ ها</label>
                            @foreach ($networkTags as $networkTag)
                                <input type="checkbox" name="networkTags[{{ $networkTag->id }}]" value="{{ $networkTag->id }}" class="form-control col-md-7">{{ $networkTag->title }}
                            @endforeach
                        </div>
                        <div class="box-tools">
                            <button type="submit" class="btn btn-info btn-sm">ارسال</button>
                        </div>
                    </div>

                    </form>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection


