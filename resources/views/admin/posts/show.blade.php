@extends('layouts.admin')

@section('title', 'Posts')

@section('content')
    <div class="page-header">
        <div class='btn-toolbar'>
            <a class="btn btn-primary btn-lg" href="{{ url()->previous() }}">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                Go Back
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10">
			<div class="panel-heading">
				<h1>{{ $post->title }}</h1>
				<small> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> {{ $post->user->email }} | <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
				</small> {{ \Carbon\Carbon::createFromTimeStamp(strtotime($post->created_at))->diffForHumans() }}
			</div>
			<div class="panel-body">
				{!! $post->content !!}
			</div>			
        </div>
    </div>
@stop
