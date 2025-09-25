<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Switch the application language
     */
    public function switch(Request $request)
    {
        $locale = $request->input('locale');
        
        // Validate that the locale is available
        if (!array_key_exists($locale, config('app.available_locales'))) {
            return redirect()->back()->with('error', __('messages.invalid_language_selection'));
        }
        
        // Store the selected locale in session
        Session::put('locale', $locale);
        
        return redirect()->back()->with('success', __('messages.language_changed'));
    }
}