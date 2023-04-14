<?php

namespace App\Http\Livewire;

use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class ContactForm extends Component
{
    // public $name, $email, $content="";
    public $model = [];

    public function submitForm () {
        // La validation suivant les règles
        $data =  Validator::make(
            $this->model, 
            [
                'name' => 'required',
                'email' => 'required|email',
                'content' => 'required',
            ],
            [
                'name' => 'Le nom est obligatoire',
                'email' => 'L\'adresse mail est obligatoire',
                'content' => 'Le message de votre mail est obligatoire',
            ]
        )->validate();

        // Envoie du mail
        Mail::to("ssodoloufo@gmail.com")
            ->send(new ContactMail(
                $data['name'],
                $data['email'],
                $data['content']
            )
        );

        // On réinitialise les champs
        $this->reset([ 'model' ]);

        // On flash un message d'alert
        session()->flash("alert", [
            'type' => "success",
            'message' => "Message envoyé ! Merci."
        ]);
    }


    public function render()
    {
        return view('livewire.contact-form');
    }
}
