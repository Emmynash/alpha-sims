<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Spatie\Multitenancy\Exceptions\NoCurrentTenant;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {

        $this->reportable(function (NoCurrentTenant $e) {
            
        });

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {

        if ($exception instanceof NoCurrentTenant) {
            return response()->view('secondary.domain.domain', [], 500);
        }

        // if (config('database.default') === 'landlord') {
        //     return response()->view('secondary.domain.domain', [], 500);
        // }
        
        return parent::render($request, $exception);
    }

    

}
