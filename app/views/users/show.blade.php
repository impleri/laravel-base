@extends('layouts.no-sidebars')

{{-- Web site Title --}}
@section('html_title')
{{ $user->username }} ::
@parent
@stop

@section('title')
{{ $user->username }}
@stop

@section('content')
    <p>Email: {{ $user->email }}</p>
@stop
