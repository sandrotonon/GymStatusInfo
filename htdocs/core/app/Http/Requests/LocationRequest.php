<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LocationRequest extends Request
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
        if ($this->method() == 'PATCH')
        {
            return [
                'name' => 'required|unique:locations,name,' . $this->name . ',name'
            ];
        }
        else
        {
            return [
                'name' => 'required|unique:locations,name'
            ];
        }
    }

    /**
     * Add custom values to the request
     * @return array
     */
    public function all()
    {
        $request = parent::all();
        $request['slug'] = str_slug($request['name']);

        return $request;
    }
}
