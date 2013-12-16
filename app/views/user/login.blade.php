@extends('layouts.no-sidebars')

{{-- Web site Title --}}
@section('html_title')
Login ::
@parent
@stop

@section('title')
Login
@stop

@section('content')
    @include('confide::login')
@stop
