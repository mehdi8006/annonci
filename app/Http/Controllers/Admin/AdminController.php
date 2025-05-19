<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    /**
     * Check if user is authenticated as admin
     *
     * @return bool
     */
    protected function isAdmin()
    {
        return Session::has('user_id') && Session::get('user_type') === 'admin';
    }

    /**
     * Redirect if not authenticated as admin
     *
     * @return \Illuminate\Http\RedirectResponse|null
     */
    protected function checkAdmin()
    {
        if (!$this->isAdmin()) {
            return redirect()->route('form')
                ->with('error', 'Vous devez être connecté en tant qu\'administrateur pour accéder à cette page.');
        }
        
        return null;
    }
}