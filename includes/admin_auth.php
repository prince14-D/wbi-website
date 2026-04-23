<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

const WBI_ADMIN_USERNAME = 'admin';
const WBI_ADMIN_PASSWORD = 'WBI@2026';

function wbi_admin_is_logged_in()
{
    return !empty($_SESSION['wbi_admin_logged_in']);
}

function wbi_admin_login_attempt($username, $password)
{
    $validUser = hash_equals(WBI_ADMIN_USERNAME, trim((string) $username));
    $validPass = hash_equals(WBI_ADMIN_PASSWORD, (string) $password);

    if ($validUser && $validPass) {
        $_SESSION['wbi_admin_logged_in'] = true;
        $_SESSION['wbi_admin_username'] = WBI_ADMIN_USERNAME;
        return true;
    }

    return false;
}

function wbi_admin_require_auth()
{
    if (!wbi_admin_is_logged_in()) {
        header('Location: admin-login.php');
        exit;
    }
}

function wbi_admin_logout()
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}
