<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    $request->validate([
        'card'  => ['required', 'string'],
        'range' => 'required|string|in:daily,weekly,monthly,all',
    ]);

    return app($request->query('card'))->calculate(
        $request->query('range')
    );
})->middleware('auth');
