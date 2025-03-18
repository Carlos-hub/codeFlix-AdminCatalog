<?php

namespace App\Exceptions;

use Core\Domain\Exception\EntityValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpFoundation\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return $this->showErrors($exception->getMessage(), Response::HTTP_NOT_FOUND);
        }
        if( $exception instanceof EntityValidationException) {
            return $this->showErrors('Route not found', Response::HTTP_BAD_GATEWAY);
        }
        return parent::render($request, $exception);
    }

    public function showErrors(string $errorMessage, int $errorCode)
    {
        return response()->json([
            'message' => $errorMessage,
        ], $errorCode);
    }
}
