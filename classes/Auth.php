<?php

class Auth
{
    public static function isLoggedIn()
    {
        return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'];
    }


    public static function isAdmin()
    {
        return isset($_SESSION['is_Admin']) && $_SESSION['is_Admin'];
    }

    public static function isSecretary()
    {
        return isset($_SESSION['is_Secretary']) && $_SESSION['is_Secretary'];
    }


    public static function isTeacher()
    {
        return isset($_SESSION['is_Teacher']) && $_SESSION['is_Teacher'];
    }

    public static function isStudent()
    {
        return isset($_SESSION['is_Student']) && $_SESSION['is_Student'];
    }

    public static function requireLogin()
    {
        if (! static::isLoggedIn()) {
            // die("unauthorised");
            Url::redirect("/main/login.php");
        }
    }

    public static function requireAdmin()
    {
        if (! static::isAdmin()) {
            // die("unauthorised");
            Url::redirect("/main/index.php");
        }
    }
    public static function requireSecretary()
    {
        if (! static::isSecretary()) {
            // die("unauthorised");
            Url::redirect("/main/index.php");
        }
    }
    public static function requireTeacher()
    {
        if (! static::isTeacher()) {
            // die("unauthorised");
            Url::redirect("/main/index.php");
        }
    }


    public static function login()
    {
        session_regenerate_id(true);
        $_SESSION['is_logged_in'] = true;
    }
    public static function setAdmin()
    {
        $_SESSION['is_Admin'] = true;
    }
    public static function setSecretary()
    {
        $_SESSION['is_Secretary'] = true;
    }
    public static function setTeacher()
    {
        $_SESSION['is_Teacher'] = true;
    }
    public static function setStudent()
    {
        $_SESSION['is_Student'] = true;
        // $_SESSION['student_id'] =
    }


    public static function logout()
    {
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
    }
}
