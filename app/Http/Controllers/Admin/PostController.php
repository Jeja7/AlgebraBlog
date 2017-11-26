<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Sentinel;
use Cartalyst\Sentinel\Users\IlluminateUserRepository;


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
		
		if($user_id == $post->user_id) {
        return view('admin.posts.edit', ['post' => $post]);		
    } else {
		return redirect()->route('admin.posts.index');
	}
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\PostRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        // Validate post data		
		$result = $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ]);
		
        // Assemble the updated attributes
        $attributes = [
            'title' => $request->get('title', null),
            'content' => $request->get('content', null),
        ];		
        
         // Fetch the post object
        $post = Post::find($id);
        if (!$post) {
            if ($request->ajax()) {
                return response()->json("Invalid post.", 422);
            }
            session()->flash('error', 'Invalid post.');
            return redirect()->back()->withInput();
        }
		
        // Update the post
  		$post->updatePost($attributes);
		 // All done
        if ($request->ajax()) {
            return response()->json(['post' => $post], 200);
        }

        session()->flash('success', "Post '{$post->title}' has been updated.");
        return redirect()->route('admin.posts.index'); 

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
