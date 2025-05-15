<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Validator;
use App\Helpers\PasswordResetHelper;
use App\Helpers\EmailHelper;

class AuthController extends Controller
{
    /**
     * Show the authentication form.
     *
     * @return \Illuminate\View\View
     */
    public function showAuthForm()
    {
        $page='log';
        return view('auth',compact('page'));
    }

    /**
     * Show the forgot password form.
     *
     * @return \Illuminate\View\View
     */
    public function showForgotPasswordForm()
    {
        $page='forgot';
        return view('auth',compact('page'));
    }

    /**
     * Handle user login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request) {
    // Validate the login form data
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
    ]);
    
    if ($validator->fails()) {
        return redirect()->route('form')
            ->withErrors($validator)
            ->withInput($request->except('password'));
    }
    
    // Attempt to log the user in
    $credentials = $request->only('email', 'password');
    $remember = $request->has('remember');
    
    // Find the user by email in the utilisateurs table
    $user = Utilisateur::where('email', $credentials['email'])->first();
    
    // Check if user exists and password is correct
    if ($user && Hash::check($credentials['password'], $user->password)) {
        // Check user status
        if ($user->statut == 'suprime') {
            return redirect()->route('form')
                ->withErrors(['email' => 'Votre compte a été suspendu.'])
                ->withInput($request->except('password'));
        }
        
        if ($user->statut == 'en_attente') {
            return redirect()->route('form')
                ->withErrors(['email' => 'Votre compte n\'est pas encore activé.'])
                ->withInput($request->except('password'));
        }
        
        // Store user information in the session
        $request->session()->put('user_id', $user->id);
        $request->session()->put('user_name', $user->nom);
        $request->session()->put('user_email', $user->email);
        $request->session()->put('user_type', $user->type_utilisateur);
        
        // Also store the complete user object in the session for admin access
        $request->session()->put('utilisateur', $user);
        
        // Regenerate the session for security
        $request->session()->regenerate();
        
        // If remember me is checked, set a cookie
        if ($remember) {
            // Create a remember token and store it in the cookie
            $rememberToken = Hash::make(time() . $user->email);
            // Update the remember token in the database
            $user->remember_token = $rememberToken;
            $user->save();
            
            // Set the cookie for 30 days
            cookie('remember_token', $rememberToken, 43200); // 30 days in minutes
        }
        
        // Redirect based on user type
        if ($user->type_utilisateur === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Connexion réussie!');
        } else {
            return redirect('/home')->with('success', 'Connexion réussie!');
        }
    }
    
    // Authentication failed
    return redirect()->route('form')
        ->withErrors(['email' => 'Ces identifiants ne correspondent pas à nos enregistrements.'])
        ->withInput($request->except('password'));
}

    /**
     * Handle user registration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validate the registration form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:utilisateurs',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'phone.required' => 'Le numéro de téléphone est obligatoire.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('form')
                ->with('register', true) // To display register form instead of login
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        // Create the new user
        $user = new Utilisateur();
        $user->nom = $request->name;
        $user->email = $request->email;
        $user->telephon = $request->phone;
        $user->password = Hash::make($request->password);
        $user->ville = 'Non spécifiée'; // Default value, can be updated later
        $user->statut = 'en_attente'; // Setting default status to awaiting validation
        $user->save();

        // Redirect to login page with success message
        return redirect()->route('form')
            ->with('success', 'Inscription réussie! Votre compte est en attente de validation.');
    }

    /**
     * Handle the forgot password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forgotPassword(Request $request)
    {
        // Validate the email
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:utilisateurs,email',
        ], [
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.exists' => 'Nous ne trouvons pas d\'utilisateur avec cette adresse email.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('password.request')
                ->withErrors($validator)
                ->withInput();
        }

        // Get the user
        $user = Utilisateur::where('email', $request->email)->first();
        
        // Generate reset token
        $token = PasswordResetHelper::createToken($user->email);
        
        // Send password reset email
        $emailSent = EmailHelper::sendPasswordResetEmail($user->email, $user->nom, $token);
        
        if (!$emailSent) {
            return redirect()->route('password.request')
                ->with('error', 'Une erreur est survenue lors de l\'envoi de l\'email. Veuillez réessayer plus tard.')
                ->withInput();
        }
        
        // Redirect with success message
        return redirect()->route('form')
            ->with('success', 'Un lien de réinitialisation a été envoyé à votre adresse email.');
    }
    
    /**
     * Show the reset password form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function showResetForm(Request $request)
    {
        $token = $request->token;
        $email = $request->email;
        
        // Validate token
        if (!PasswordResetHelper::validateToken($email, $token)) {
            return redirect()->route('form')
                ->with('error', 'Ce lien de réinitialisation est invalide ou a expiré.');
        }
        
        return view('components.auth.reset-password', compact('token', 'email'));
    }
    
    /**
     * Reset the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request)
    {
        // Validate the reset form data
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email|exists:utilisateurs,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.exists' => 'Nous ne trouvons pas d\'utilisateur avec cette adresse email.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        // Validate token
        if (!PasswordResetHelper::validateToken($request->email, $request->token)) {
            return redirect()->route('form')
                ->with('error', 'Ce lien de réinitialisation est invalide ou a expiré.');
        }
        
        // Update user's password
        $user = Utilisateur::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        
        // Delete the token
        PasswordResetHelper::deleteToken($request->email);
        
        // Redirect to login with success message
        return redirect()->route('form')
            ->with('success', 'Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter avec votre nouveau mot de passe.');
    }

    /**
     * Log the user out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Clear the user session data
        $request->session()->forget([
            'user_id', 
            'user_name', 
            'user_email', 
            'user_type'
        ]);
        
        // Invalidate the session
        $request->session()->invalidate();
        
        // Regenerate the CSRF token
        $request->session()->regenerateToken();
        
        // Redirect to home page with success message
        return redirect('/home')->with('success', 'Vous avez été déconnecté avec succès.');
    }
}