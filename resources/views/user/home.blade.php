@extends('layouts.index')

@section('title', 'AlgebraBox | The greatest cloud storage')

@section('content')
<div class="row">
  <ol class="breadcrumb">
    <li class="active">Home</li>
  </ol>
</div>
<div class="row">
@foreach($posts as $post)
	<p>
		<h2>{{ $post->title }}</h2>
		<div>{{ $post->user->email }}</div>
		<div>{{ $post->comments[0]->content }}</div>
	</p>
@endforeach
</div>
@stop
