<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['user_id', 'post_id', 'content'];
	
	/**
	* The Eloquent users model name
	* 
	* @vat string
	*/
	
	protected static $usersModel = 'App\Models\Users';
	
	 /**
	* The Eloquent users model name
	* 
	* @vat string
	*/
	
	protected static $postsModel = 'App\Models\Post';
	
	/**
	* Returns the users relationship
	* 
	* @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	*/
	
	public function user()
	{
		return $this->belongsTo(static::$usersModel, 'user_id');
	}
	
	/**
	* Returns the posts relationship
	* 
	* @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	*/
	
	public function post()
	{
		return $this->hasMany(static::$postsModel, 'post_id');
	}
	
	/**
	* Save Comment
	* 
	* @param array $comment
	* @return void
	*/
	
	public function saveComment($comment = array())
	{
		$this->fill($comment)->save();
	}
	
	/**
	* Update Comment
	* 
	* @param array $comment
	* @return void
	*/
	
	public function updateComment($comment = array())
	{
		$this->update($comment);
	}
}
