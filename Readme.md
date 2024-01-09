# Aplicação FullStack com Laravel e VueJs
Aplicação simples usando Laravel no backend (API) e VueJs no frontend, também usei Docker para rodar o projeto.


## Backend Laravel (API REST)
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

## Frontend VueJs

## Project Setup

```sh
npm install
```

### Compile and Hot-Reload for Development

```sh
npm run dev
```

### Compile and Minify for Production

```sh
npm run build
```
