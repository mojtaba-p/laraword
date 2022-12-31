<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Stevebauman\Purify\Facades\Purify;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'title' => 'required',
            'status' => ['required', Rule::in(0,1)],
            'content' => 'nullable',
            'thumbnail' => 'image|max:1024',
            'meta_title' => 'max:255',
            'meta_description' => 'max:255',
        ];

        if($this->category_id != null)
            $rules['category_id'] = Rule::exists('categories', 'id');

        return $rules;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->status == 'draft'
            ? $this->merge(['status' => 0])
            : $this->merge(['status' => 1]);

        if( ! is_file($this->file('thumbnail'))){
            $this->request->remove('thumbnail');
        }
    }
}
