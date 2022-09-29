<?php

declare(strict_types=1);

use Ardenthq\NovaTableMetrics\Period;
use Ardenthq\NovaTableMetrics\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Enum;

Route::get('/', function (Request $request) {
    $request->validate([
        'table'  => 'required|string',
        'period' => ['required', 'string', new Enum(Period::class)],
    ]);

    $table = app($request->query('table'));

    abort_unless($table instanceof Table, 403);

    return $table->items(
        $request->enum('period', Period::class)
    );
})->middleware('auth');
