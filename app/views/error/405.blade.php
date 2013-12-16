@extends('layouts.no-sidebars')

{{-- Web site Title --}}
@section('html_title')
Error ::
@parent
@stop

@section('title')
Error 405
@stop

@section('content')
    <p>Sorry, but that action is not supported.</p>
@stop
