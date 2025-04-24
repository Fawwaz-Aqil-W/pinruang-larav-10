public function authenticate()
{
    if (!Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    // Check if user is admin when trying to access admin routes
    if (request()->is('admin*') && !Auth::user()->isAdmin()) {
        Auth::logout();
        throw ValidationException::withMessages([
            'email' => 'These credentials do not have admin access.',
        ]);
    }

    RateLimiter::clear($this->throttleKey());
}