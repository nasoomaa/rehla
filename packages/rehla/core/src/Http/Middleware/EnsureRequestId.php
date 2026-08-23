<?php

namespace Rehla\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Rehla\Core\Support\RequestId;

class EnsureRequestId
{
    public function handle(Request $request, Closure $next)
    {
        $id = $request->header('X-Request-ID', (string) Str::uuid());
        
        $request->headers->set('X-Request-ID', $id);
        
        RequestId::set($id);

        $response = $next($request);

        $response->headers->set('X-Request-ID', $id);

        return $response;
    }
}
