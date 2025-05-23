<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated via session
        if (!session()->has('user_id')) {
            return redirect()->route('form')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        // Get user data from session
        $userId = session('user_id');
        $userType = session('user_type', 'normal');
        $userStatus = session('user_status');

        // Additional validation - check if user still exists and is active
        $user = \App\Models\Utilisateur::find($userId);
        
        if (!$user) {
            // User no longer exists, clear session
            session()->flush();
            return redirect()->route('form')->with('error', 'Session invalide. Veuillez vous reconnecter.');
        }

        // Check if user account is still active
        if ($user->statut !== 'valide') {
            $message = '';
            switch ($user->statut) {
                case 'en_attente':
                    $message = 'Votre compte est en attente d\'activation.';
                    break;
                case 'supprime':
                    $message = 'Votre compte a été désactivé.';
                    break;
                default:
                    $message = 'Votre compte n\'est pas actif.';
            }
            
            session()->flush();
            return redirect()->route('form')->with('error', $message);
        }

        // Update session with current user data if needed
        if (session('user_type') !== $user->type_utilisateur || 
            session('user_status') !== $user->statut) {
            session([
                'user_type' => $user->type_utilisateur,
                'user_status' => $user->statut,
                'user_name' => $user->nom,
                'user_email' => $user->email,
                'utilisateur' => $user
            ]);
        }

        return $next($request);
    }
}