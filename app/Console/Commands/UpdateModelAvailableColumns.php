<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\StringType;

class UpdateModelAvailableColumns extends Command
{
    protected $signature = 'model:update-available-columns {model}';
    protected $description = 'Update model dengan semua kolom yang tersedia dari database';

    public function handle()
    {
        $modelName = $this->argument('model');
        $modelClass = "App\\Models\\$modelName";

        if (!class_exists($modelClass)) {
            $this->error("Model $modelClass tidak ditemukan.");
            return;
        }

        $model = new $modelClass();
        $table = $model->getTable();
        $columns = Schema::getColumnListing($table);

        if (empty($columns)) {
            $this->error("Tabel '$table' tidak memiliki kolom atau tidak ditemukan.");
            return;
        }

        // ✅ FIX: Map enum dan vector ke string agar Doctrine tidak error
        $connection = Schema::getConnection();
        $platform = $connection->getDoctrineConnection()->getDatabasePlatform();

        if (!Type::hasType('enum')) {
            Type::addType('enum', StringType::class);
        }
        if (!Type::hasType('vector')) {
            Type::addType('vector', StringType::class);
        }

        $platform->registerDoctrineTypeMapping('enum', 'string');
        $platform->registerDoctrineTypeMapping('vector', 'string');

        $doctrineSchema = $connection->getDoctrineSchemaManager();
        $doctrineColumns = $doctrineSchema->listTableColumns($table);

        $formattedColumns = array_map(function ($col) use ($doctrineColumns) {
            $type = $doctrineColumns[$col]->getType()->getName();
            $nullable = $doctrineColumns[$col]->getNotnull() ? 'NOT NULL' : 'NULLABLE';
            return sprintf("'%s', // %s, %s", $col, strtoupper($type), $nullable);
        }, $columns);

        $columnsString = "[\n        " . implode(",\n        ", $formattedColumns) . "\n    ];";

        $modelPath = app_path("Models/$modelName.php");

        if (!file_exists($modelPath)) {
            $this->error("File model $modelPath tidak ditemukan.");
            return;
        }

        $content = file_get_contents($modelPath);

        if (!preg_match('/public static array \$availableColumns\s*=\s*\[.*?\];/s', $content)) {
            $this->warn("❌ Properti '\$availableColumns' belum ditemukan di model.");
            $this->warn("Silakan tambahkan properti berikut secara manual terlebih dahulu ke model '$modelName':");
            $this->line("\n    public static array \$availableColumns = [];\n");
            return;
        }

        $newContent = preg_replace(
            '/public static array \$availableColumns\s*=\s*\[.*?\];/s',
            "public static array \$availableColumns = $columnsString",
            $content
        );

        file_put_contents($modelPath, $newContent);

        $this->info("✅ Model $modelName berhasil diperbarui dengan daftar kolom yang terformat rapi.");
    }
}
