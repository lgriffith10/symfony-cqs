<?php

namespace App\Dtos;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Attribute\Ignore;

/**
 * @template T
 */
class ApiResponse
{
    /**
     * @param T|null $data
     * @param array<string, string> $error
     */
    public function __construct(
        public readonly mixed $data = null,
        public readonly array $error = [],
        public readonly bool  $success = true,
        public readonly int   $statusCode = 200
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
        return new self(data: $data, statusCode: Response::HTTP_CREATED);
    }

    /**
     * @return self<null>
     */
    public static function noContent(): self {
        return new self(data: null, statusCode: Response::HTTP_NO_CONTENT);
    }

    /**
     * @return self<null>
     */
    public static function notFound(string $message): self {
        return new self(
            error: ['message' => $message],
            success: false,
            statusCode: Response::HTTP_NOT_FOUND
        );
    }

    /**
     * @return self<null>
     */
    public static function forbidden(): self {
        return new self(error: ['message' => 'Forbidden'], success: false, statusCode: Response::HTTP_FORBIDDEN);
    }

    /**
     * @return self<null>
     */
    public static function error(string $message, int $code = Response::HTTP_BAD_REQUEST): self {
        return new self(
            error: ['message' => $message],
            success: false,
            statusCode: $code
        );
    }
}