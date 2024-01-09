<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Laravel API REST
Criação de uma simples API REST usando Laravel e MySQL.
Usei Laravel Sanctum para autenticação.

### Endpoints
Criar conta ``` POST /api/auth/register ```

Fazer login ``` POST /api/auth/login ```

Fazer logout ``` POST /api/auth/logout ```

Recuperar todas Notas ``` GET /api/notes ```

Recuperar Nota única ``` GET /api/notes/{id} ```

Criar nova Nota ``` POST /api/notes ```

Atualizar uma Nota ``` PUT /api/notes/{id} ```

Deletar uma Nota ``` DELETE /api/notes/{id} ```

## Routes
```
Route::prefix('auth')->group(function () {
    Route::middleware('validate.login')->post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
    Route::middleware('validate.registration')->post('register', [RegisterController::class, 'register']);
});

Route::middleware('auth:sanctum')->apiResource('notes', NotesController::class);

```
