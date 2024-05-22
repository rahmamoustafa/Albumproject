<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait HandlerApiResponse
{

    /**
     *
     */
    protected function handleApiException($request, Exception $exception)
    {
        $exception = $this->prepareException($exception);

        if ($exception instanceof \Illuminate\Http\Exceptions\HttpResponseException) {
            $exception = $exception->getResponse();
        }

        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            $exception = $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            $exception = $this->convertValidationExceptionToResponse($exception, $request);
        }

        return $this->customApiResponse($exception);
    }



    protected function customApiResponse($exception)
    {
        $errors = [];
        if (method_exists($exception, 'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = 500;
        }
        if (config('app.debug')) {
            $errors['trace'] = $exception->getTrace();
            $errors['code'] = $exception->getCode();
        }
        $errors['status'] = $statusCode;
        $errors['error'] = $exception;
        switch ($statusCode) {
            case 401:
                return sendError('Unauthorized', $errors, 401);
                break;
            case 403:
                return sendError('Forbidden', $errors, 403);
                break;
            case 404:
                return sendError('Not Found', $errors, 404);
                break;
            case 405:
                return sendError('Method Not Allowed', $errors, 405);
                break;
            case 422:
                return sendError($exception->original['message'], $exception->original['errors'], 422);
                break;
            default:
                return sendError('server error', $errors, 500);
                break;
        }
    }
}
