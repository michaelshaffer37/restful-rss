<?php

if (!function_exists('http_status_code_reason')) {
    function http_status_code_reason(int $code = 0): string
    {
        // @codingStandardsIgnoreStart
        switch ($code) {
            case 100: $text = 'Continue'; break;
            case 101: $text  = 'Switching Protocols'; break;
            case 102: $text  = 'Processing'; break;
            case 200: $text  = 'OK'; break;
            case 201: $text  = 'Created'; break;
            case 202: $text  = 'Accepted'; break;
            case 203: $text  = 'Non-Authoritative Information'; break;
            case 204: $text  = 'No Content'; break;
            case 205: $text  = 'Reset Content'; break;
            case 206: $text  = 'Partial Content'; break;
            case 207: $text  = 'Multi-status'; break;
            case 208: $text  = 'Already Reported'; break;
            case 300: $text  = 'Multiple Choices'; break;
            case 301: $text  = 'Moved Permanently'; break;
            case 302: $text  = 'Found'; break;
            case 303: $text  = 'See Other'; break;
            case 304: $text  = 'Not Modified'; break;
            case 305: $text  = 'Use Proxy'; break;
            case 306: $text  = 'Switch Proxy'; break;
            case 307: $text  = 'Temporary Redirect'; break;
            case 400: $text  = 'Bad Request'; break;
            case 401: $text  = 'Unauthorized'; break;
            case 402: $text  = 'Payment Required'; break;
            case 403: $text  = 'Forbidden'; break;
            case 404: $text  = 'Not Found'; break;
            case 405: $text  = 'Method Not Allowed'; break;
            case 406: $text  = 'Not Acceptable'; break;
            case 407: $text  = 'Proxy Authentication Required'; break;
            case 408: $text  = 'Request Time-out'; break;
            case 409: $text  = 'Conflict'; break;
            case 410: $text  = 'Gone'; break;
            case 411: $text  = 'Length Required'; break;
            case 412: $text  = 'Precondition Failed'; break;
            case 413: $text  = 'Request Entity Too Large'; break;
            case 414: $text  = 'Request-URI Too Large'; break;
            case 415: $text  = 'Unsupported Media Type'; break;
            case 416: $text  = 'Requested range not satisfiable'; break;
            case 417: $text  = 'Expectation Failed'; break;
            case 418: $text  = 'I\'m a teapot'; break;
            case 422: $text  = 'Unprocessable Entity'; break;
            case 423: $text  = 'Locked'; break;
            case 424: $text  = 'Failed Dependency'; break;
            case 425: $text  = 'Unordered Collection'; break;
            case 426: $text  = 'Upgrade Required'; break;
            case 428: $text  = 'Precondition Required'; break;
            case 429: $text  = 'Too Many Requests'; break;
            case 431: $text  = 'Request Header Fields Too Large'; break;
            case 451: $text  = 'Unavailable For Legal Reasons'; break;
            case 500: $text  = 'Internal Server Error'; break;
            case 501: $text  = 'Not Implemented'; break;
            case 502: $text  = 'Bad Gateway'; break;
            case 503: $text  = 'Service Unavailable'; break;
            case 504: $text  = 'Gateway Time-out'; break;
            case 505: $text  = 'HTTP Version not supported'; break;
            case 506: $text  = 'Variant Also Negotiates'; break;
            case 507: $text  = 'Insufficient Storage'; break;
            case 508: $text  = 'Loop Detected'; break;
            case 511: $text  = 'Network Authentication Required'; break;
            default: $text = "Unknown http status code $code"; break;
        }
        // @codingStandardsIgnoreEnd
        return $text;
    }
}

if (!function_exists('app_namespace')) {
    function app_namespace(): \Ramsey\Uuid\Uuid
    {
        return \Ramsey\Uuid\Uuid::uuid5(
            \Ramsey\Uuid\Uuid::NAMESPACE_DNS,
            config('app.hostname')
        );
    }
}

if (!function_exists('app_uuid')) {
    function app_uuid(string $name): string
    {
        return (string)\Ramsey\Uuid\Uuid::uuid5(app_namespace(), $name);
    }
}
