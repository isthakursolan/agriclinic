<?php

use Illuminate\Support\Facades\Route;
use PhpParser\Node\Scalar\MagicConst\Dir;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('admin', function () {
//     return view('layouts.index');
// });

require __DIR__ .'/auth.php';
require __DIR__ .'/frontOffice.php';
require __DIR__ .'/farmer.php';
