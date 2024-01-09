<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ValidateNotesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $validator = Validator::make(
            $request->all(),
            [
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:10|max:2000',
            ],
            [
            'required' => 'O campo :attribute é obrigatório.',
            'title.min' => 'O campo title precisa ter no mínimo 3 caracteres',
            'title.max' => 'O campo title ultrapassou o limite de caracteres',
            'description.min' => 'O campo description precisa ter no mínimo 10 caracteres',
            'description.max' => 'O campo description ultrapassou o limite de caracteres',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        return $next($request);
    }
}
