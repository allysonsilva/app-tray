<?php

declare(strict_types=1);

namespace App\Applications\Seller\Http\Controllers\Auth;

use Account\Models\Seller;
use App\Applications\Seller\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

final class Login
{
    private const DECAY_SECONDS = 2 * 60; // 2 minutos

    /**
     * Handle an incoming authentication request.
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        // O RateLimiter nesse contexto serve para prevenir ataques de força bruta no login.
        // Quando falha o login -> RateLimiter::hit(...) incrementa o contador.
        // Se atingir o limite (5 tentativas) -> RateLimiter::tooManyAttempts(...) retorna true e o login fica bloqueado temporariamente.
        // Quando o usuário acerta a senha -> RateLimiter::clear(...) limpa o contador, permitindo novas tentativas no futuro.
        $request->ensureIsNotRateLimited();

        /** @var Seller|null $seller */
        $seller = Seller::where('email', $request->input('email'))->first();

        if (! Hash::check($request->input('password'), $seller?->password)) {
            // Incrementa o contador de falhas quando a autenticação não foi possível.
            RateLimiter::hit($request->throttleKey(), self::DECAY_SECONDS);

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // Se a autenticação foi bem-sucedida, limpa o contador de falhas.
        RateLimiter::clear($request->throttleKey());

        return response()->json([
            'token' => $seller->createToken("Token for {$seller->name}", ['seller'])->plainTextToken,
        ]);
    }
}
