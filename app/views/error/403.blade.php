@extends('layouts.no-sidebars')

{{-- Web site Title --}}
@section('html_title')
Error
@overwrite

@section('title')
Error 403
@stop

@section('content')
    <p>Sorry, but you are not authorized.</p>
@stop
