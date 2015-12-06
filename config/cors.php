<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Laravel CORS
     |--------------------------------------------------------------------------
     |

     | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*') 
     | to accept any value, the allowed methods however have to be explicitly listed.
     |
     */
    'supportsCredentials' => true,
    'allowedOrigins' => ['*'],
    'allowedHeaders' => ['Content-Type', 'Origin', 'Accept', 'Authorization', 'X-Requested-With', 'DNT', 'Keep-Alive', 'User-Agent-X', 'If-Modified-Since', 'Cache-Control'],
    'allowedMethods' => ['GET', 'POST', 'PUT', 'DELETE'],
    'exposedHeaders' => ['Authorization'],
    'maxAge' => 0,
    'hosts' => [env('API_URL')],
];