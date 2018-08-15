@extends('admin.Layouts.master')
@section('title','ویرایش نمونه کار گرافیک')
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
                    <h3 class="panel-title"><i class="fa fa-pencil"></i> ویرایش نمونه کار گرافیک : {{ $graphicSample->title }}</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ route('graphicsamples.update', $graphicSample->id) }}" method="POST" enctype="multipart/form-data">

                        {{ csrf_field() }}

                        {{ method_field('PUT') }}

                    <div class="box-body">
                        <div class="form-group row">
                            <label class="col-md-2"> عنوان</label>
                            <input type="text" name="title" id="title" class="form-control col-md-7" value="{{ $graphicSample->title }}">
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2"> توضیحات</label>
                            <textarea name="description" id="description" cols="30" rows="10" class="form-control col-md-7"> {{ $graphicSample->description }} </textarea>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2"> آدرس وب سایت</label>
                            <input type="text" name="url" id="url" class="form-control col-md-7" value="{{ $graphicSample->url }}">
                        </div>
                        @if ($graphicSample->image)
                            <div class="form-group row">
                                <label class="col-md-2">تصویر فعلی</label>
                                <img src="{{ $graphicSample->image }}" alt="{{ $graphicSample->image }}">
                            </div>
                        @else
                            <div class="form-group row">
                                <label class="col-md-2">تصویر فعلی</label>
                                <img src="/sample_default.jpg" alt="بدون تصویر">
                            </div>
                        @endif
                        <div class="form-group row">
                            <label class="col-md-2"> آپلود تصویر</label>
                            <input type="file" name="image">
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2">وضعیت</label>
                            <select name="status_id" id="status_id" class="form-control col-md-7">
                                @foreach ($status as $stat)
                                    <option value="{{ $stat->id }}" @if($graphicSample->status_id == $stat->id)  selected  @endif >{{ $stat->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2">تگ ها</label>
                            @foreach ($graphicTags as $graphicTag)
                                <input type="checkbox" name="graphicTags[{{ $graphicTag->id }}]" value="{{ $graphicTag->id }}" class="form-control col-md-7" <?php foreach($graphicSample->graphictags()->get()->toArray() as $tag) { if($tag['id'] == $graphicTag->id) { echo "checked"; } } ?> >{{ $graphicTag->title }}
                            @endforeach
                        </div>
                        <div class="box-tools">
                            <button type="submit" class="btn btn-info btn-sm">ارسال</button>
                        </div>
                    </div>

                    </form>

                    <form action="/admin/graphicsamples/{{ $graphicSample->id }}" method="POST">
                    <form action="{{ route('graphicsamples.destroy', $graphicSample->id) }}" method="POST">
    
                        {{ csrf_field() }}
                        
                        {{ method_field('DELETE') }}
                        
                        &nbsp;

                        <div class="box-tools">
                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
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





