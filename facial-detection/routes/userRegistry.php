<?php
use App\Http\Controllers\UserRegistryController;

// Grupo de rotas com prefixo 'dashboard' e middleware 'auth'
Route::prefix('user-registry')->middleware('auth')->group(function () {

    // Rota para a página inicial do dashboard
    Route::get('/', [UserRegistryController::class, 'index'])->name('user-registry.index'); // Página inicial listagem

    // Rotas de cadastro e update
    Route::get('create', [UserRegistryController::class, 'create'])->name('user-registry.create'); // View de cadastro
    Route::post('store', [UserRegistryController::class, 'store'])->name('user-registry.store'); // Cadastrar

    Route::get('{id}/edit', [UserRegistryController::class, 'edit'])->name('user-registry.edit'); // View de edição
    Route::put('update', [UserRegistryController::class, 'update'])->name('user-registry.update'); // View de edição

    // Rotas de exclusão
    Route::get('{id}/delete', [UserRegistryController::class, 'delete'])->name('user-registry.delete'); // View de exclusão
    Route::delete('destroy', [UserRegistryController::class, 'destroy'])->name('user-registry.destroy'); // Deletar
    
    // Adicione mais rotas conforme necessário
});