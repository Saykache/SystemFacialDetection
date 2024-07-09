<?php
use App\Http\Controllers\UserRegistryController;

// Grupo de rotas com prefixo 'dashboard' e middleware 'auth'
Route::prefix('user-registry')->middleware('auth')->group(function () {

    // Rota para a página inicial do dashboard
    Route::get('/', [UserRegistryController::class, 'index'])->name('user-registry.index');

    // // Rotas de cadastro e update
    Route::get('/create', [UserRegistryController::class, 'create'])->name('user-registry.create');
    // Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // // Rotas de configurações
    // Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    // Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    
    // Adicione mais rotas conforme necessário
});