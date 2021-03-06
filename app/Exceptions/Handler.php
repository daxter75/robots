<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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
        $this->renderable(function (NotFoundHttpException $e, $request) {
//            if ($request->wantsJson()) {
                return response()->json([
                    'statusCode' => Response::HTTP_NOT_FOUND,
                    'error' => 'Not found',
                    'message' => 'No ' . $request->route()->parameterNames[0] . ' with ID: ' . $request->route()->parameters['robot'] . ' exists',
                    ], Response::HTTP_NOT_FOUND);
//            }
        });
    }
}
