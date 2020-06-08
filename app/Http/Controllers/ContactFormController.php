<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Validator;
use App\Mail\ContactTeamEmail;
use App\ContactForm\ContactForm;

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
            
            //$contact_form = ContactForm::createFromValidator($validator);

            try {
                $contact_form = ContactForm::createFromValidator($validator);
                Mail::to($validator->getData()['email'])->send(new ContactTeamEmail($contact_form));
            } catch (\Throwable $th) {
                return response($th,200);
            }
           

            return response($validator->getData()['email'], 200);
            


        }else{
            return response()->json($validator->errors()->all());
        }

          
    }

    //
}
