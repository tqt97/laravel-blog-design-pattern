<?php

use App\Http\Controllers\Admin\CategoryController;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function (): void {
    Route::delete('categories/bulk-delete', [CategoryController::class, 'destroyMultiple'])
        ->name('categories.bulk-delete');
    Route::resource('categories', CategoryController::class);
});
