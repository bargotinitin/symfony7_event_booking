<?php

// src/Message/SendWelcomeEmail.php

namespace App\Message;

class SendWelcomeEmail
{
  public function __construct(public readonly string $email) {}
}
