<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Widget;
$sliders = Widget::where('type', 'slider')->get();
foreach($sliders as $s) {
    echo "ID: " . $s->id . "\n";
    echo "Title: " . $s->title . "\n";
    echo "Button: " . $s->button . "\n";
    echo "--------------------------\n";
}
