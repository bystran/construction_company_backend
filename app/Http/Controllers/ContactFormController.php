<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Validator;
use App\Mail\ContactCustomerEmail;
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
            'first_name'=>'required|alpha|max:50|min:2',
            'last_name'=>'required|alpha|max:50|min:2',
            'email'=>'required|email',
            'message'=>'required|min:10|max:500',
            'g-recaptcha-response' => 'required|captcha'
        ];

        $validator = Validator::make($data, $rules);
        if($validator->passes()){
            
            $contact_form = ContactForm::createFromValidator($validator);

            try {
                Mail::to($validator->getData()['email'])->queue(new ContactCustomerEmail($contact_form));
                Mail::to('info@srworld.sk')->queue(new ContactTeamEmail($contact_form));
            } catch (\Throwable $th) {
                parent::report($th);
                
                return response()->json([
                    "success"=>false,
                    "status"=>500,
                    "message"=>'Oops, vyskitla sa chyba!'
                ]);
            }
           

            return response()->json([
                "success"=>true,
                "status"=>200,
                "message"=>'Správa bola spracovaná. Ďakujeme.'
            ]);
            


        }else{
            return response()->json([
                "success"=>false,
                "status"=>422,
                "errors"=>$validator->errors()
            ]);
        }

          
    }

    //
}
