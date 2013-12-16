@extends('layouts.no-sidebars')

{{-- Web site Title --}}
@section('html_title')
Register ::
@parent
@stop

@section('title')
Register
@stop

@section('content')
    @include('confide::signup')
@stop
