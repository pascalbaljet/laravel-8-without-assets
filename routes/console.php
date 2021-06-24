<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

Artisan::command('check:db {connection}', function ($connection) {
    try {
        DB::connection($connection)->getDoctrineSchemaManager()->listTableNames();

        $this->info('OK');
        return 0;
    } catch (Throwable $e) {
        $this->error('NOT OK');

        return 1;
    }
});

Artisan::command('check:cache {store}', function ($store) {
    try {
        Cache::driver($store)->put('foo', 'bar');
    } catch (Throwable $e) {
        $this->error('NOT OK');

        return 1;
    }

    $result = Cache::driver($store)->get('foo');

    if ($result === 'bar') {
        $this->info('OK');
        return 0;
    }

    $this->error('NOT OK');

    return 1;
});
