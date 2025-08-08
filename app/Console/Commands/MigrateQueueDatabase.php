<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateQueueDatabase extends Command
{
    protected $signature = 'queue:migrate-db';
    protected $description = 'Run migrations for the dedicated queue database connection';

    public function handle(): int
    {
        $path = base_path('database/migrations_queue');
        $this->call('migrate', [
            '--path' => str_replace(base_path().'/', '', $path),
            '--database' => config('queue.connections.database.connection') ?: 'queue',
            '--force' => true,
        ]);

        $this->info('Queue database migrations completed.');
        return self::SUCCESS;
    }
}
