<?php namespace App\Libraries;

class Auth
{
    public function isLoggedIn()
    {
        return session()->get('logged_in') === true;
    }

    public function hasRole($roles)
    {
        if (is_string($roles)) {
            $roles = [$roles];
        }

        $userRole = session()->get('role');
        return in_array($userRole, $roles);
    }
}