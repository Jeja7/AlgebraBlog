<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Post;
use Sentinel;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
		$post = Post::find($this->route('post'));
		
		if (Sentinel::getUser()->id != $post->user_id) {
			return false;
		}
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'		=> 'required',
			'content' 	=> 'required'
        ];
    }
	
	/**
 * Get the error messages for the defined validation rules.
 *
 * @return array
 */
public function messages()
{
    return [
        'title.required' 	=> 'A post title is required',
        'content.required'  => 'A post content is required',
    ];
}
}















