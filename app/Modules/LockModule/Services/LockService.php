<?php

namespace App\Modules\LockModule\Services;

use App\Modules\LockModule\Interfaces\LockInterface;
use Illuminate\Support\Facades\Cache;

class LockService implements LockInterface
{
    public function lock(string $key, int $ttl = self::TTL): bool
    {
        $lock = Cache::lock($key, $ttl);

        return $lock->acquire();
    }

    public function unlock(string $key): bool
    {
        Cache::lock($key)->forceRelease();

        return true;
    }
}
