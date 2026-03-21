<?php
declare(strict_types=1);

namespace App\Http;

class Response
{
    private array $headers;
    private int $status;
    private string $body;

    public function __construct(
        int $status = 200,
        array $headers = ['Content-Type' => 'text/html; charset=UTF-8'],
        string $body = ''
    ) {
        $this->setStatus($status);
        $this->headers = $this->normalizeHeaders($headers);
        $this->body    = $body;
    }

    // --- Mutators ---
    public function setHeader(string $name, string $value): void
    {
        $this->headers[$this->normalizeHeaderName($name)] = $value;
    }

    public function setStatus(int $status): void
    {
        if ($status < 100 || $status > 599) {
            throw new \InvalidArgumentException("Invalid HTTP status code: $status");
        }
        $this->status = $status;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    // --- Accessors ---
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    // --- Send to client ---
    public function send(): void
    {
        http_response_code($this->status);
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }
        echo $this->body;
    }

    // --- Helpers ---
    public static function json(array $data, int $status = 200): self
    {
        return new self(
            $status,
            ['Content-Type' => 'application/json'],
            json_encode($data)
        );
    }

    public static function html(string $html, int $status = 200): self
    {
        return new self(
            $status,
            ['Content-Type' => 'text/html; charset=UTF-8'],
            $html
        );
    }

    // --- Internal normalization ---
    private function normalizeHeaders(array $headers): array
    {
        $normalized = [];
        foreach ($headers as $name => $value) {
            $normalized[$this->normalizeHeaderName($name)] = $value;
        }
        return $normalized;
    }

    private function normalizeHeaderName(string $name): string
    {
        return ucwords(strtolower($name), '-');
    }
}
