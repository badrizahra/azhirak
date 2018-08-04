@extends('admin.Layouts.master')
@section('title','سطح دسترسی')
@section('content')
    <div id="content">
        <div class="page-header">
            <div class="container-fluid">
                <div class="pull-right">
                    <a href="" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="بارگذاری مجدد"><i class="fa fa-refresh"></i></a>
                </div>
                <ul class="breadcrumb">
                    <li><a href="">خانه</a></li>
                    <li><a href="">مدیریت دسترسی ها</a></li>
                </ul>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-list">مدیریت دسترسی ها</i> </h3>
                        </div>

                        <div class="panel-body">
                            {!! Form::open(['method'=>'PUT','route'=>['permission.update'],'class'=>'form-horizontal','id'=>'form-update']) !!}
                                <div class="table-responsive">
                                    @php
                                        $counterRole=0;
                                        $arrRole=array();
                                    @endphp
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <td class="text-right">option</td>
                                            @foreach($roles as $role)
                                                <td class="text-center">{{$role->title}}</td>
                                                @php
                                                    $counterRole++;
                                                    $arrRole[]=$role->id;
                                                @endphp
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
//                                        dd($modules);
                                        ?>
                                    {{--@if(is_array($modules) && count($modules))--}}
                                        @foreach($modules as $module)
                                            <input type="checkbox" name="selected[]" value="1" />
                                            <tr style="background: #5fa2db">
                                                <td class="text-right"><b>{{$module->title}}</b></td>
                                                @for($i=0;$i<$counterRole;$i++)
                                                   <td class="text-center"><input type="checkbox" id="role{{$arrRole[$i]}}-module{{$module->id}}" class="r{{$arrRole[$i]}}-{{$module->id}}" onclick="setPer('{{$arrRole[$i]}}','{{$module->id}}')" /></td>
                                                @endfor
                                            </tr>
                                                @foreach($module->permission as $value)
                                                    <tr>
                                                        <td class="text-right">{{$value->title}}</td>
                                                    @for($i=0;$i<$counterRole;$i++)
                                                        <td class="text-center">
                                                            <input type="checkbox" class="r{{$arrRole[$i]}}-{{$module->id}}" id="role{{$arrRole[$i]}}-permission{{$value->id}}"  name="{{$arrRole[$i]}}-{{$value->id}}"  {{$listChecked[$arrRole[$i]][$value->id]}} />
                                                        </td>
                                                    @endfor
                                                    </tr>
                                                @endforeach

                                        @endforeach
                                    {{--@endif--}}

                                        </tbody>
                                    </table>
                                    @if(Session::has('message'))
                                        @component('components.alert',['type'=> Session::get("type")  ])
                                            {{ Session::get('message') }}
                                        @endcomponent
                                    @endif

                                    <div class="box-tools">{{ Form::submit('ثبت',['class'=>'btn btn-primary']) }}</div>
                                </div>
                            {{ Form::close() }}
                      </div>
                 </div>
             </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        function setPer(rolId,modueId) {
            var flag=$("#role"+rolId+"-module"+modueId).prop('checked');
            if(flag){
                $(".r"+rolId+"-"+modueId).prop('checked', true);
            }else{
                $(".r"+rolId+"-"+modueId).prop('checked', false);
            }
        }
    </script>
@endsection