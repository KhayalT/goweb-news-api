<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ResponseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     *
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        $trace         = null;
        $error_message = null;
        $errors        = null;
        $message       = null;
        $body          = null;

        /** @var $response Response */
        $response = $next($request);

        $originalContent = json_decode($response->getContent(), true);
        if (isset($originalContent)){
            $originalContent = array_key_exists('data', $originalContent) ? $originalContent['data'] : $originalContent;
        }

        if (!empty($originalContent['error_message'])) {
            $error_message = $originalContent['error_message'];
        }

        if (!empty($originalContent['errors'])) {
            $errors = $originalContent['errors'];
        }

        if (!empty($originalContent['message'])) {
            $message = $originalContent['message'];
        }

        unset($originalContent['trace']);
        unset($originalContent['error_message']);
        unset($originalContent['errors']);
        unset($originalContent['message']);

        if (empty($trace)) {
            $body = $originalContent;
        }

        if (!empty($errors)) {
            $body = $errors;
        }

        $responseBody = [
            'body'    => $body,
            'code'    => $response->status(),
            'message' => $message ?? $error_message ?? $this->getMessage($response->status()),
            'status'  => in_array($response->status(), [200, 201]) ? 'success' : 'danger',
            'ref'     => $uuid = Str::uuid(),
            'trace'   => $trace,
        ];

        $response->setContent(json_encode($responseBody, JSON_OBJECT_AS_ARRAY));

        $response->withHeaders([
            'Content-Type' => 'application/json'
        ]);

        $response->setStatusCode($response->status());
        http_response_code($response->status());

        return $response;
    }

    private function getMessage(int $code) : ?string
    {
        switch ($code) {
            case 100:
                return 'Continue.';
            case 101:
                return 'Switching Protocols.';
            case 200:
                return "Successful";
            case 201:
                return 'Created.';
            case 202:
                return 'Accepted.';
            case 203:
                return 'Non-Authoritative Information.';
            case 204:
                return 'No Content.';
            case 205:
                return 'Reset Content.';
            case 206:
                return 'Partial Content.';
            case 300:
                return 'Multiple Choices.';
            case 301:
                return 'Moved Permanently.';
            case 302:
                return 'Moved Temporarily.';
            case 303:
                return 'See Other.';
            case 304:
                return 'Not Modified.';
            case 305:
                return 'Use Proxy.';
            case 400:
                return 'Something went wrong. Please try again.';
            case 401:
                return 'Unauthorized.';
            case 402:
                return 'Payment Required.';
            case 403:
                return 'Forbidden.';
            case 404:
                return 'Not Found.';
            case 405:
                return 'Method Not Allowed.';
            case 406:
                return 'Not Acceptable.';
            case 407:
                return 'Proxy Authentication Required.';
            case 408:
                return 'Request Time-out.';
            case 409:
                return 'Conflict.';
            case 410:
                return 'Gone.';
            case 411:
                return 'Length Required.';
            case 412:
                return 'Precondition Failed.';
            case 413:
                return 'Request Entity Too Large.';
            case 414:
                return 'Request-URI Too Large.';
            case 415:
                return 'Unsupported Media Type.';
            case 422:
                return 'Unprocessable Entity.';
            case 500:
                return 'Internal Server Error.';
            case 501:
                return 'Not Implemented.';
            case 502:
                return 'Bad Gateway.';
            case 503:
                return 'Service Unavailable.';
            case 504:
                return 'Gateway Time-out.';
            case 505:
                return 'HTTP Version not supported.';
            default:
                return null;
        }
    }

}
