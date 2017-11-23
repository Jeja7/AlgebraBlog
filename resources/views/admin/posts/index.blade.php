@extends('layouts.admin')

@section('title', 'Posts')

@section('content')
    <div class="page-header">
        <div class='btn-toolbar pull-right'>
            <a class="btn btn-primary btn-lg" href="{{ route('admin.posts.create') }}">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                Create Post
            </a>
        </div>
        <h1>Posts</h1>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="table-responsive">
			@if(count($posts) > 0)
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>User</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td>
									<a href="{{ route('admin.posts.show', $post->id) }}">
										{{ $post->title }}
									</a>
								</td>
                                <td>{{ $post->user->email }}</td>
                                <td>
                                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-default">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                        Edit
                                    </a>
                                    <a href="{{ route('admin.posts.destroy', $post->id) }}" class="btn btn-danger action_confirm" data-method="delete" data-token="{{ csrf_token() }}">
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
				@else
				{{ 'No posts!' }}
			@endif
            </div>
			{!! $posts->render() !!}
        </div>
    </div>
@stop
