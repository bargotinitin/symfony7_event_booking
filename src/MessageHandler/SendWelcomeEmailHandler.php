<?php

// src/MessageHandler/SendWelcomeEmailHandler.php

namespace App\MessageHandler;

use App\Message\SendWelcomeEmail;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SendWelcomeEmailHandler
{
  public function __invoke(SendWelcomeEmail $message)
  {
    // Send email to $message->email
    // This is the code that runs when the message is handled
    error_log("I am called");
  }
}
