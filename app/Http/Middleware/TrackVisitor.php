<?php

namespace App\Http\Middleware;

use App\Models\VisitorLog;
use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($this->shouldSkip($request)) {
            return $response;
        }

        try {
            $this->logVisit($request);
        } catch (QueryException) {
            // Ignore when table not migrated yet.
        }

        return $response;
    }

    private function shouldSkip(Request $request): bool
    {
        if (! $request->isMethod('GET') && ! $request->isMethod('HEAD')) {
            return true;
        }

        if (app()->runningInConsole() || app()->environment('testing')) {
            return true;
        }

        if (! $request->hasSession()) {
            return true;
        }

        if ($request->is('admin') || $request->is('admin/*')) {
            return true;
        }

        if ($request->is('api') || $request->is('api/*')) {
            return true;
        }

        if ($request->is('up')) {
            return true;
        }

        if ($request->is('storage/*')) {
            return true;
        }

        if ($request->is('css/*') || $request->is('js/*') || $request->is('images/*') || $request->is('favicon.ico')) {
            return true;
        }

        return false;
    }

    private function logVisit(Request $request): void
    {
        $today = now()->toDateString();
        $sessionKey = 'visitor_last_logged_on';

        if ($request->session()->get($sessionKey) === $today) {
            return;
        }

        $request->session()->put($sessionKey, $today);

        $path = '/'.$request->path();
        $userAgent = $request->userAgent();
        $referer = $request->headers->get('referer');

        VisitorLog::create([
            'visited_on' => $today,
            'session_id' => $request->session()->getId(),
            'user_id' => $request->user()?->id,
            'path' => mb_substr($path, 0, 2048),
            'ip' => $request->ip(),
            'user_agent' => $userAgent !== null ? mb_substr($userAgent, 0, 512) : null,
            'referer' => $referer !== null ? mb_substr($referer, 0, 2048) : null,
        ]);
    }
}
