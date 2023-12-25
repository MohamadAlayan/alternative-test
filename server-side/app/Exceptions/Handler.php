<?php

namespace App\Exceptions;

use App\Enums\HttpCode;
use App\Http\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->renderable(function (Throwable $e) {
        });
    }

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        NotFoundHttpException::class
    ];

    /**
     * @param Throwable $e
     * @return void
     * @throws Throwable
     */
    public function report(Throwable $e)
    {
        // report or log exception

        parent::report($e);
    }


    /**
     * @param $request
     * @param Throwable $e
     * @return JsonResponse
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {
            return Response::error($e->getMessage(), $e->errors(), 422);
        } elseif ($e instanceof NotFoundHttpException) {
            return Response::error(__('messages.request_route_not_found'), $e->getMessage(), HttpCode::NOT_FOUND->value);
        }

        // check if environment is development or production
        $reason = config('app.debug') ? $e->getMessage() : __('messages.server_error_message');
        return Response::error(__('messages.server_error'), $reason, HttpCode::INTERNAL_SERVER_ERROR->value);
    }
}
