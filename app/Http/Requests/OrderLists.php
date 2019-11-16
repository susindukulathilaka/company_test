<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderLists extends FormRequest
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
        return ['data' => [
            'itemName' => 'mail|string|numeric',
            'itemPrice' => 'required',
            'itemQuant' => 'required|numeric',
            'totalPrice' => 'required'
        ]];
    }

    public function messages() {

        $arr = array('msg' => 'Something went wrong. Please try again!', 'status' => false);
        return Response()->json($arr);
    }
}
