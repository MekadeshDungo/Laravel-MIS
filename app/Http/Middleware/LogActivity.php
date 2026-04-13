<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SystemLog;

class LogActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            $user = $request->user();
            
            if ($user) {
                $action = $this->mapMethodToAction($request->method());
                $routeName = $request->route() ? $request->route()->getName() : null;
                $module = $this->extractModuleFromRoute($routeName);
                
                SystemLog::create([
                    'user_id' => $user->id,
                    'action' => $action,
                    'event' => $action,
                    'module' => $module,
                    'description' => "{$action} request to {$request->path()}",
                    'ip_address' => $request->ip(),
                    'status' => $response->getStatusCode() >= 400 ? 'failed' : 'success',
                ]);
            }
        }

        return $response;
    }

    private function mapMethodToAction(string $method): string
    {
        return match($method) {
            'POST' => 'create',
            'PUT', 'PATCH' => 'update',
            'DELETE' => 'delete',
            default => 'unknown',
        };
    }

    private function extractModuleFromRoute(?string $routeName): string
    {
        if (!$routeName) {
            return 'Unknown';
        }

        $parts = explode('.', $routeName);
        return $parts[0] ?? 'Unknown';
    }
}
