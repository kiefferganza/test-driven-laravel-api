<?php

use App\Http\Controllers\TodoListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('todo-list', [TodoListController::class, 'index'])
    ->name('todo-list.index');

Route::get('todo-list/{list}', [TodoListController::class, 'show'])
    ->name('todo-list.show');

Route::post('todo-list', [TodoListController::class, 'store'])
    ->name('todo-list.store');
