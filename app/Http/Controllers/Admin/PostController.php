<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Sentinel;


class PostController extends Controller
{
	/**
   * Set middleware to quard controller.
   *
   * @return void
   */
    public function __construct()
    {
        $this->middleware('sentinel.auth');
    }	
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */	 
	
	public function index()
    {
        if(Sentinel::inRole('administrator')) {
				$posts = Post::orderBy('created_at', 'DESC')->paginate(10);
		} else {
			$user_id = Sentinel::getUser()->id;
			$posts = Post::where('user_id',$user_id)->orderBy('created_at', 'DESC')->paginate(10);
		}
		
		return view('admin.posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		return view('admin.posts.create');		
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
		$user_id = Sentinel::getUser()->id;
        $input = $request->except(['_token']);
		
		$data = array(
			'user_id'	=> $user_id,
			'title'		=>	trim($input['title']),
			'content'	=>	$input['content']
		);
		
		$post = new Post();
		$post->savePost($data);	

		$message = session()->flash('success', 'You have successfully add a new post.');
		
		/* return redirect()->back()->withFlashMessage($message); */
		return redirect()->route('admin.posts.index')->withFlashMessage($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
		
		return view('admin.posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
		$user_id = Sentinel::getUser()->id;
		
		/* if($user_id == $post->user_id) { */
        return view('admin.posts.edit', ['post' => $post]);		
		/*} else {
		return redirect()->route('admin.posts.index');
		}*/
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\PostRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, $id)
    {
        $post = Post::find($id);
		
		$input = $request->except(['_token']);
		
		$data = array(
			'title'		=>	trim($input['title']),
			'content'	=>	$input['content']
		);
		
		$post->updatePost($data);
		
		$message = session()->flash('success', 'You have successfully updated a post with ID '.$id.'.');
		
		return redirect()->route('admin.posts.index')->withFlashMessage($message);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
		$post->delete();
		
		$message = session()->flash('success', 'You have successfully deleted a post.');
		
		/* return redirect()->back()->withFlashMessage($message); */
		return redirect()->route('admin.posts.index')->withFlashMessage($message);
    }
}
