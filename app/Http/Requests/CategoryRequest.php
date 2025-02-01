<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        if ($this->route('category')) {
            return Gate::allows('categories.update');
        }
        return Gate::allows('categories.create');
        ; //if true user can use this request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id=$this->route('category');
        return
         Category::rules($id); // we create rules function in Category model
    }
    public function messages() : array
    {
        return [
            'required'=> 'the :attribute field is required',
            'unique'=> 'this :attribute field is Exist',
        ];
    }
}
