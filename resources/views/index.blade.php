@extends('layouts.index')

@section('title', 'AlgebraBlog')

@section('content')
<div class="row">
	@foreach($posts as $post)
	<div class="col-sm-6 col-md-4 col-lg-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					<a href="{{ route('post.show', $post->slug) }}">
					{{ $post->title }}
					</a>
				</h3>
			</div>
			<div class="panel-body">
			{!! str_limit($post->content, 100) !!}
			</div>
		</div>
	</div>
	@endforeach
</div>
@stop
