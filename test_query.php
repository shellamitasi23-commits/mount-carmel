<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

try {
    $tables = DB::select('SHOW TABLES');
    echo "Tables in DB:\n";
    foreach ($tables as $table) {
        $tableArray = (array)$table;
        echo "- " . reset($tableArray) . "\n";
    }
    
    if (Schema::hasTable('users')) {
        $count = DB::table('users')->count();
        echo "Users count in table 'users': " . $count . "\n";
        
        $allUsers = DB::table('users')->select('id', 'name', 'email')->get();
        foreach ($allUsers as $u) {
            echo "  - ID: {$u->id}, Name: {$u->name}, Email: '{$u->email}'\n";
        }
    } else {
        echo "Table 'users' DOES NOT EXIST.\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
