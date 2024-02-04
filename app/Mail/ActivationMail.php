<?php

namespace app\Mail;
// app/Mail/ActivationMail.php

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class ActivationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('emails.activation')
            ->with([
                'activationLink' => route('activate', $this->user->activation_token),
            ]);
    }
}

