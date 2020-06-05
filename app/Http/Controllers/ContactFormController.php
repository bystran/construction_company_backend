<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Validator;

class ContactFormController extends Controller
{
    private $key;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->key = env('MAILER_KEY');
    }


    public function process(Request $request){

        $data = json_decode($request->getContent(), true);

        $rules = [
            'first_name'=>'required|alpha|max:50',
            'last_name'=>'required|alpha|max:50',
            'email'=>'required|email',
            'message'=>'required|min:10|max:500'
        ];

        $validator = Validator::make($data, $rules);
        if($validator->passes()){
            return response("Form has been processed successfully.", 200);
        }else{
            return response()->json($validator->errors()->all());
        }

          
    }

    //
}
