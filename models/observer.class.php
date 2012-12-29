<?php

class Observer
{

    /**
     * Prevent access to some pages when the user is logged in and others when
     * not logged in
     */
    public static function appGuard ()
    {
        $restrictedFiles = User::isLoggedIn() ? array(
                'register',
                'activate'
        ) : array(
                'messages',
                'profile'
        );
        $view = Helper::getView();
        if (in_array($view, $restrictedFiles)) {
            User::isLoggedIn() ? Helper::go('/') : Helper::go('/404');
        }
    }

    public static function adminGuard ()
    {
        global $theUser;
        if (Helper::urlContains('_administrator')) {
            if (!User::isLoggedIn() || ! $theUser->isAdmin()) {
                Helper::go('/404');
            }
        }
    }
}