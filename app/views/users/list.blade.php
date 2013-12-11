@extends('layouts.no-sidebars')

{{-- Web site Title --}}
@section('html_title')
Users ::
@parent
@stop

@section('title')
Users
@stop

@section('content')
    <h4>Some users</h4>

    @if($users)
        @foreach ($users as $user)
            <div>{{ $user->username }}</div>
        @endforeach
    @else
        <div>No users found</div>
    @endif
@stop
