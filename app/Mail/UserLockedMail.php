<?php

namespace app\Mail;
// app/Mail/UserLockedMail.php

use App\Models\User;

class UserLockedMail extends Mailable
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('emails.user_locked');
    }
}
