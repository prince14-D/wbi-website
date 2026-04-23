<?php
require __DIR__ . '/includes/admin_auth.php';
wbi_admin_logout();
header('Location: admin-login.php');
exit;
