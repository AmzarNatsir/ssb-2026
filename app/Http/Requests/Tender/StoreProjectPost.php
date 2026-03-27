<?php

namespace App\Http\Requests\Tender;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectPost extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [            
            // 'name' => ['required', 'min:4', 'max:255', 'string'],
            'name' => 'required',
            'number' => 'unique:projects',
            'source' => 'required',
            'status_id' => 'required',
            'category_id' => 'required',
            'target_tender_id' => 'required',
            'jenis_project_id' => 'required',
            'tipe_id' => 'required',
            'customer_id' => 'required',
            'created_by' => 'required'
        ];

        
    }
}
