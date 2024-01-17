<?php


if (! function_exists('adminIsLoggedIn')) {
    function adminIsLoggedIn(): bool
    {
        return auth()->guard('admin')->check();
    }
}

if (! function_exists('userIsLoggedIn')) {
    function userIsLoggedIn(): bool
    {
        return auth()->check();
    }
}

if (! function_exists('currentAdmin')) {
    function currentAdmin()
    {
        return adminIsLoggedIn()
            ? \App\Models\Admin::find(auth()->guard('admin')->id())
            : null;
    }
}

if (! function_exists('currentUser')) {
    function currentUser()
    {
        return userIsLoggedIn()
            ? \App\Models\User::find(auth()->id())
            : null;
    }
}

if (! function_exists('modelIsAdmin')) {
    function modelIsAdmin($user): bool
    {
        return $user->getTable() === 'admins';
    }
}


