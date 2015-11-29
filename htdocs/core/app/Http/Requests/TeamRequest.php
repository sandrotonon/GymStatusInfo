<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TeamRequest extends Request
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
                'name' => 'required',
                'team' => 'required|unique:users,team,' . $this->team . ',team',
                'email' => 'required|unique:users,email,' . $this->email . ',email',
                'role' => 'required'
            ];
        }
        else
        {
            return [
                'name' => 'required',
                'team' => 'required|unique:users,team',
                'email' => 'required|unique:users,email',
                'role' => 'required'
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
        $request['slug'] = str_slug($request['team']);
        $request['password'] = bcrypt($request['password']);

        return $request;
    }
}
