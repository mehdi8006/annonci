<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('form')->with('error', 'Vous devez vous connecter pour accéder à cette page.');
        }

        $user = Auth::user();

        // Check if user exists and has the required attributes
        if (!$user || !isset($user->type_utilisateur) || !isset($user->statut)) {
            Auth::logout();
            return redirect()->route('form')->with('error', 'Session invalide. Veuillez vous reconnecter.');
        }

        // Check if user is an admin
        if ($user->type_utilisateur !== 'admin') {
            return redirect()->route('homeshow')->with('error', 'Accès refusé. Vous n\'avez pas les permissions d\'administrateur.');
        }

        // Check if user account is active
        if ($user->statut !== 'valide') {
            $message = '';
            switch ($user->statut) {
                case 'en_attente':
                    $message = 'Votre compte administrateur est en attente d\'activation.';
                    break;
                case 'supprime':
                    $message = 'Votre compte administrateur a été désactivé.';
                    break;
                default:
                    $message = 'Votre compte administrateur n\'est pas actif.';
            }
            
            Auth::logout();
            return redirect()->route('form')->with('error', $message);
        }

        return $next($request);
    }
}