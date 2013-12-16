@extends('layouts.no-sidebars')

@section('html_title')
{{ $page->title }} ::
@parent
@stop

@section('title')
{{ $page->title }}
@stop

@section('content')
    <p>{{ $page->body }}</p>
@stop
