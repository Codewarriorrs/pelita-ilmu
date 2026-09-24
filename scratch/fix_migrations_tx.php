<?php

$dir = __DIR__ . '/../database/migrations';
foreach (glob($dir . '/*.php') as $file) {
    $content = file_get_contents($file);
    if (!str_contains($content, '$withinTransaction') && str_contains($content, 'return new class extends Migration')) {
        $content = str_replace(
            "return new class extends Migration\n{",
            "return new class extends Migration\n{\n    public \$withinTransaction = false;",
            $content
        );
        file_put_contents($file, $content);
        echo "Updated: " . basename($file) . "\n";
    }
}
