<?php

namespace App\Services;

use Illuminate\View\Factory;
use Sentinel;
use App\Models\Post;
use App\Models\Comment;

class CommentsService
{
	protected $view;
	
	public function __construct(Factory $view)
	{
		$this->view = $view;
	}
	
	public function pendingComments()
	{
		/* $user_id = Sentinel::getUser()->id;
		
		$posts = Post::where('user_id', $user_id)->count();
		
		return $posts; */
		
		$user_id = Sentinel::getUser()->id;
		
		$comments = Comment::where('user_id', $user_id)->where('status', 0)->count();
		
		return $comments;
		
	}	
}