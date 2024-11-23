<?php
require_once __DIR__ . '/../models/userModel.php';

function login() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header('Location: /home');
            exit;
        } else {
            echo "Credenciales incorrectas.";
        }
    }
    require_once __DIR__ . '/../views/login.php';
}

function register() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        createUser($username, $email, $password);
        header('Location: /login');
        exit;
    }
    require_once __DIR__ . '/../views/register.php';
}

function logout() {
    session_start();
    session_unset();
    session_destroy();
    header('Location: /login');
    exit;
}

?>
