<?php

namespace App\Dtos;

/**
 * @template T
 */
class ApiResponse
{
    /**
     * @param T|null $data
     * @param array<string, string> $errors
     */
    public function __construct(
        public readonly mixed $data = null,
        public readonly array $errors = [],
        public readonly bool $success = true,
        public readonly int $statusCode = 200
    )
    {
    }

    /**
     * @template TSuccess
     * @param TSuccess $data
     * @return self<TSuccess>
     */
    public static function success(mixed $data = null): self {
        return new self(data: $data);
    }

    /**
     * @template TSuccess
     * @param TSuccess $data
     */
    public static function created(mixed $data): self {
        return new self(data: $data, statusCode: 201);
    }

    public static function noContent(): self {
        return new self(data: null, statusCode: 204);
    }

    /**
     * @return self<null>
     */
    public static function unauthorized(string $message, int $code = 400): self {
        return new self(errors: ['message' => 'Unauthorized'], success: false, statusCode: 403);
    }

    /**
     * @return self<null>
     */
    public static function error(string $message, int $code = 400): self {
        return new self(errors: ['message' => $message], success: false, statusCode: $code);
    }
}