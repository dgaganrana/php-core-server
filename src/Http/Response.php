<?php
declare(strict_types=1);

namespace App\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use GuzzleHttp\Psr7\Utils;

class Response implements ResponseInterface
{
    private int $statusCode;
    private string $reasonPhrase;
    private array $headers = [];
    private StreamInterface $body;
    private string $protocolVersion = '1.1';

    public function __construct(
        int $statusCode = 200,
        array $headers = ['Content-Type' => 'text/html; charset=UTF-8'],
        string $body = ''
    ) {
        $this->statusCode   = $statusCode;
        $this->reasonPhrase = '';
        $this->headers      = $headers;
        $this->body         = Utils::streamFor($body);
    }

    // --- Protocol version ---
    public function getProtocolVersion(): string { return $this->protocolVersion; }
    public function withProtocolVersion($version): self {
        $clone = clone $this;
        $clone->protocolVersion = $version;
        return $clone;
    }

    // --- Headers ---
    public function getHeaders(): array { return $this->headers; }
    public function hasHeader($name): bool { return isset($this->headers[$name]); }
    public function getHeader($name): array { return (array)($this->headers[$name] ?? []); }
    public function getHeaderLine($name): string { return implode(',', $this->getHeader($name)); }
    public function withHeader($name, $value): self {
        $clone = clone $this;
        $clone->headers[$name] = (array)$value;
        return $clone;
    }
    public function withAddedHeader($name, $value): self {
        $clone = clone $this;
        $clone->headers[$name][] = $value;
        return $clone;
    }
    public function withoutHeader($name): self {
        $clone = clone $this;
        unset($clone->headers[$name]);
        return $clone;
    }

    // --- Body ---
    public function getBody(): StreamInterface { return $this->body; }
    public function withBody(StreamInterface $body): self {
        $clone = clone $this;
        $clone->body = $body;
        return $clone;
    }

    // --- Status ---
    public function getStatusCode(): int { return $this->statusCode; }
    public function withStatus($code, $reasonPhrase = ''): self {
        if ($code < 100 || $code > 599) {
            throw new \InvalidArgumentException("Invalid HTTP status code: $code");
        }
        $clone = clone $this;
        $clone->statusCode = $code;
        $clone->reasonPhrase = $reasonPhrase;
        return $clone;
    }
    public function getReasonPhrase(): string { return $this->reasonPhrase; }

    // --- Convenience factories ---
    public static function json(array $data, int $status = 200): self {
        return new self(
            $status,
            ['Content-Type' => 'application/json'],
            json_encode($data, JSON_THROW_ON_ERROR)
        );
    }

    public static function html(string $html, int $status = 200): self {
        return new self(
            $status,
            ['Content-Type' => 'text/html; charset=UTF-8'],
            $html
        );
    }
}
