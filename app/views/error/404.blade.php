@extends('layouts.no-sidebars')

{{-- Web site Title --}}
@section('html_title')
Error
@overwrite

@section('title')
Error 404
@stop

@section('content')
    <p>Sorry, but that page could not be found.</p>
@stop
