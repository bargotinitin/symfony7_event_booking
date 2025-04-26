<?php

namespace App\Dto;

class ErrorDto implements \JsonSerializable
{
    private int $status;
    private string $error;
    private string $message;
    private string $timestamp;

    public function __construct(string $error, int $status = 400, string $message = 'Validation failed')
    {
        $this->status = $status;
        $this->error = $error; // Single error string
        $this->message = $message;
        $this->timestamp = (new \DateTime())->format('c');
    }

    public function jsonSerialize(): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'error' => $this->error,
            'timestamp' => $this->timestamp,
        ];
    }
}
