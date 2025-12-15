<?php

use Illuminate\Support\Facades\Route;
use Getecz\Installer\Http\Controllers\InstallController;
use Getecz\Installer\Http\Middleware\EnsureNotInstalled;

Route::middleware(['web', EnsureNotInstalled::class])->group(function () {
    Route::get('/install', [InstallController::class, 'welcome'])->name('installer.welcome');
    Route::get('/install/requirements', [InstallController::class, 'requirements'])->name('installer.requirements');

    Route::get('/install/database', [InstallController::class, 'databaseForm'])->name('installer.database');
    Route::post('/install/database', [InstallController::class, 'saveDatabase'])->name('installer.database.save');

    Route::get('/install/run', [InstallController::class, 'run'])->name('installer.run');

    Route::get('/install/admin', [InstallController::class, 'adminForm'])->name('installer.admin');
    Route::post('/install/admin', [InstallController::class, 'createAdmin'])->name('installer.admin.create');

    Route::get('/install/finish', [InstallController::class, 'finish'])->name('installer.finish');
});
