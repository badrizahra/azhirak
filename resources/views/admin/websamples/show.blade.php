@extends('admin.Layouts.master')
@section('content')
<img class="card-img-top" src="{{url( $webSample->image )}}" alt="{{ $webSample->image }}">
@endsection()