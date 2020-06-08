<?php

namespace App\ContactForm;
use Illuminate\Validation\Validator;

class ContactForm
{
    private $name;
    private $email;
    private $message;

    public function __construct(string $name, string $email, string $message){
        $this->name = $name;
        $this->email = $email;
        $this->message = $message;
    }

    public static function createFromValidator(Validator $validator): ContactForm{
        $data = $validator->getData();
        $instance = new self($data['first_name'].$data['last_name'], $data['email'], $data['message']);
        return $instance;
    }

    public function setEmail(string $email){
        $this->email = $email;
    }
    public function getEmail(): string{
        return $this->email;
    }
    public function setName(string $name){
        $this->name = $name;
    }
    public function getName(): string{
        return $this->name;
    }
    public function setMessage(string $message){
        $this->message = $message;
    }
    public function getMessage(): string{
        return $this->message;
    }
    
}