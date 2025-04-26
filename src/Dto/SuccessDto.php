<?php

namespace App\Dto;

class SuccessDto implements \JsonSerializable
{
    private int $status;
    private string $message;
    private array $data;
    private string $timestamp;

    public function __construct(array $data, string $message = 'Success', int $status = 200)
    {
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
        $this->timestamp = (new \DateTime())->format('c');
    }

    public function jsonSerialize(): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data,
            'timestamp' => $this->timestamp,
        ];
    }
}
