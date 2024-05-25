<?php

namespace App\Packages\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

/**
 * Class: Response
 *
 * Description: Response class handles API responses
 *
 * Author: Amirhossein Pooladvand
 * Email: a.h.pooladvand@gmail.com
 *
 * Date: 2023-09-08 1:11 AM
 *
 */
class Response extends BaseResponse
{
    protected mixed $data;
    protected string|array $message = 'OK';

    public function ok(mixed $data): JsonResponse
    {
        $this->data = $data;

        return $this->response(self::HTTP_OK);
    }

    public function created(mixed $data): JsonResponse
    {
        $this->data = $data;

        return $this->response(self::HTTP_CREATED);
    }

    public function withMessage(string|array $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function withHeaders(array $headers): static
    {
        foreach ($headers as $key => $value) {
            $this->headers->set($key, $value);
        }

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    private function response(int $status = self::HTTP_OK): JsonResponse
    {
        return new JsonResponse(
            $this->getOutput(),
            $status,
            $this->headers->all(),
            0, // Not using any options for now, if needed, introduce a new method like withOptions
            false, // Since we convert any type of data to an array in getOutput this option is always false
        );
    }

    public function unprocessableEntity(string|array $message): JsonResponse
    {
        $this->data = [];

        $this->withMessage($message);

        return $this->response(static::HTTP_UNPROCESSABLE_ENTITY);
    }

    private function getOutput(): array
    {
        $result = [
            'message' => $this->getMessage()
        ];

        if ($this->data instanceof Collection) {
            $this->data = $this->data->toArray();
        }

        if (array_key_exists('data', $this->data)) {
            $result = [...$result, ...$this->data];
        } elseif (filled($this->data)) {
            $result['data'] = $this->data;
        }

        if (blank($this->data)) {
            unset($result['data']);
        }

        return $result;
    }

    public function paginate(LengthAwarePaginator $paginator): JsonResponse
    {
        $this->data = [
            'data' => $paginator->items(),
            'meta' => [
                'current_page'   => $paginator->currentPage(),
                'first_page_url' => $paginator->url(1),
                'from'           => $paginator->firstItem(),
                'last_page'      => $paginator->lastPage(),
                'last_page_url'  => $paginator->url($paginator->lastPage()),
                'next_page_url'  => $paginator->nextPageUrl(),
                'path'           => $paginator->path(),
                'per_page'       => $paginator->perPage(),
                'prev_page_url'  => $paginator->previousPageUrl(),
                'to'             => $paginator->lastItem(),
                'total'          => $paginator->total(),
            ],
        ];

        return $this->response();
    }

    public function noContent(): JsonResponse
    {
        $this->data = [];
        return $this->response(self::HTTP_NO_CONTENT);
    }
}
