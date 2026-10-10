<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MeasureNeonLatency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:measure-latency 
                            {--count=20 : Jumlah iterasi query SELECT 1}
                            {--connection= : Nama koneksi database spesifik}
                            {--neon : Ukur langsung ke Neon PostgreSQL menggunakan kredensial PROD di .env}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ukur latensi round-trip ke database Neon Postgres (20x SELECT 1)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $iterations = (int) $this->option('count');

        if ($this->option('neon')) {
            config([
                'database.connections.neon_measure' => [
                    'driver' => 'pgsql',
                    'host' => 'ep-spring-term-azlgehdt-pooler.c-3.ap-southeast-1.aws.neon.tech',
                    'port' => '5432',
                    'database' => 'neondb',
                    'username' => 'neondb_owner',
                    'password' => 'npg_gp2VHnhdv9XP',
                    'sslmode' => "require;options='endpoint=ep-spring-term-azlgehdt-pooler'",
                ],
            ]);
            $connectionName = 'neon_measure';
        } else {
            $connectionName = $this->option('connection') ?: config('database.default');
        }
        $host = config("database.connections.{$connectionName}.host");
        $database = config("database.connections.{$connectionName}.database");

        $this->info("Menghubungkan ke koneksi '{$connectionName}' ({$host}/{$database})...");

        // Warm up connection (initial SSL handshake / pooler checkout)
        $warmupStart = microtime(true);
        try {
            DB::connection($connectionName)->select('SELECT 1');
            $warmupMs = (microtime(true) - $warmupStart) * 1000;
            $this->line("Handshake / warmup connection: " . number_format($warmupMs, 2) . " ms");
        } catch (\Throwable $e) {
            $this->error("Koneksi gagal: " . $e->getMessage());
            return Command::FAILURE;
        }

        $times = [];
        $this->line("Menjalankan {$iterations}x SELECT 1 secara sekuensial...");

        for ($i = 1; $i <= $iterations; $i++) {
            $start = microtime(true);
            DB::connection($connectionName)->select('SELECT 1');
            $durationMs = (microtime(true) - $start) * 1000;
            $times[] = $durationMs;
        }

        $min = min($times);
        $max = max($times);
        $avg = array_sum($times) / count($times);

        $this->newLine();
        $this->table(
            ['Metrik', 'Nilai (ms)'],
            [
                ['Koneksi Default', $connectionName],
                ['Database Host', $host],
                ['Total Iterasi', $iterations],
                ['Latensi Min', number_format($min, 2) . ' ms'],
                ['Latensi Max', number_format($max, 2) . ' ms'],
                ['Latensi Rata-rata', number_format($avg, 2) . ' ms'],
            ]
        );

        return Command::SUCCESS;
    }
}
