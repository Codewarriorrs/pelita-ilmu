<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    DB::statement('DROP TABLE IF EXISTS users CASCADE;');
    DB::statement('CREATE TABLE users (
        id bigserial primary key,
        name varchar(255) not null,
        email varchar(255) not null unique,
        email_verified_at timestamp(0) without time zone null,
        password varchar(255) not null,
        role varchar(20) not null default \'TENTOR\',
        tanggal_daftar timestamp(0) without time zone not null default CURRENT_TIMESTAMP,
        remember_token varchar(100) null,
        created_at timestamp(0) without time zone null,
        updated_at timestamp(0) without time zone null,
        deleted_at timestamp(0) without time zone null
    );');
    echo "SUCCESS CREATING USERS TABLE MANUALLY!\n";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
