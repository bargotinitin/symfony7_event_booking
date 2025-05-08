<?php

// src/Service/NotificationSender.php
namespace App\Service;

use Psr\Log\LoggerInterface;

class MessageGenerator
{
  private LoggerInterface $logger;
  private string $senderAddress;

  public function __construct(LoggerInterface $logger, string $senderAddress)
  {
    $this->logger = $logger;
    $this->senderAddress = $senderAddress;
  }

  public function send(string $recipient, string $message): void
  {
    // Imagine sending an email here...
    $this->logger->info(sprintf(
      'Sent notification from %s to %s: %s',
      $this->senderAddress,
      $recipient,
      $message
    ));
  }
}
