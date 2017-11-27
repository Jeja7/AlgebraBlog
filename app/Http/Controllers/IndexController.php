<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class IndexController extends Controller
{
  /**
   * Set middleware to quard controller.
   *
   * @return void
   */
    public function __construct()
    {
        //$this->middleware('sentinel.guest');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'DESC')->paginate(12);
		
		return view('index')->with('posts',$posts);
		/* umjesto: return View::view('index'); */
    }
	
	public function show($slug)
	{
		$post = Post::where('slug', $slug)->first();
		
		return view('post.show')->with('post',$post);
	}
}
