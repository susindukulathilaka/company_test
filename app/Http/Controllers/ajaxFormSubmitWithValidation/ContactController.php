<?php

namespace App\Http\Controllers\ajaxFormSubmitWithValidation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contact;
use Validator,Redirect,Response;

class ContactController extends Controller
{
    public function index()
    {
        return view('order.contact_form');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric'
        ]);

        $arr = array('msg' => 'Something went wrong. Please try again!', 'status' => false);
        if($validator->passes()){
            $arr = array('msg' => 'Contact Added Successfully!', 'status' => true);
        }
        return Response()->json($arr);
    }
}
