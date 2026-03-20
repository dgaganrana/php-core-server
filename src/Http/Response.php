<?php
namespace App\Http;

class Response
{
    private array $headers = [];
    private int $status = 200;
    private string $body = '';

    public function setHeader(string $name, string $value): void
    {
        $this->headers[$name] = $value;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function send(): void
    {
        http_response_code($this->status);
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }
        echo $this->body;
    }

    // Helpers
    public static function json(array $data, int $status = 200): self
    {
        $response = new self();
        $response->setHeader('Content-Type', 'application/json');
        $response->setStatus($status);
        $response->setBody(json_encode($data));
        return $response;
    }

    public static function html(string $html, int $status = 200): self
    {
        $response = new self();
        $response->setHeader('Content-Type', 'text/html; charset=UTF-8');
        $response->setStatus($status);
        $response->setBody($html);
        return $response;
    }
}
