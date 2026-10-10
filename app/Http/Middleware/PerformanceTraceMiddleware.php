<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PerformanceTraceMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! config('app.perf_log', false)) {
            return $next($request);
        }

        $queryCount = 0;
        $totalDbTime = 0.0;
        $startTime = microtime(true);

        DB::listen(function ($query) use (&$queryCount, &$totalDbTime) {
            $queryCount++;
            $totalDbTime += $query->time;
        });

        $response = $next($request);

        $totalDurationMs = (microtime(true) - $startTime) * 1000;
        $peakMemoryMb = memory_get_peak_usage(true) / 1024 / 1024;

        // Deteksi komponen Livewire jika ada
        $livewireComponent = null;
        if ($request->hasHeader('X-Livewire')) {
            $components = $request->input('components', []);
            if (!empty($components) && isset($components[0]['snapshot'])) {
                $snapshot = json_decode($components[0]['snapshot'], true);
                $livewireComponent = $snapshot['memo']['name'] ?? 'livewire-component';
            } else {
                $livewireComponent = 'livewire-request';
            }
        }

        $logData = [
            'method' => $request->method(),
            'url' => $request->path(),
            'livewire_component' => $livewireComponent,
            'queries_count' => $queryCount,
            'db_time_ms' => round($totalDbTime, 2),
            'total_time_ms' => round($totalDurationMs, 2),
            'memory_peak_mb' => round($peakMemoryMb, 2),
        ];

        // Format single line log for stderr
        $logLine = sprintf(
            "[PERF_LOG] %s /%s%s | Queries: %d | DB: %.2f ms | Total: %.2f ms | Mem: %.2f MB",
            $logData['method'],
            $logData['url'],
            $livewireComponent ? " (Livewire: {$livewireComponent})" : "",
            $logData['queries_count'],
            $logData['db_time_ms'],
            $logData['total_time_ms'],
            $logData['memory_peak_mb']
        );

        file_put_contents('php://stderr', $logLine . PHP_EOL);

        return $response;
    }
}
