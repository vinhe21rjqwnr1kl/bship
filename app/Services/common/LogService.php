<?php

namespace App\Services\common;

use Illuminate\Support\Facades\Log;

class LogService
{
    public function logAction(string $action, array $data = []): void
    {
        Log::info($action, [
            'user' => auth()->id(),
            'data' => $data,
            'timestamp' => now()]);
    }

    public function logError(string $action, \Exception $exception): void
    {
        Log::error($action, [
            'user' => auth()->id(),
            'error_message' => $exception->getMessage(),
            'stack_trace' => $exception->getTraceAsString(),
            'timestamp' => now()

        ]);
    }
}