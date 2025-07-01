<?php

require_once './conexion/db.php'; // Assuming this is your database connection file

require 'controlador/firebase.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

class AuthSession {

    public function __construct() {
        session_start();
    }

    public function existeUsuario($email, $password) {
        $firebaseService = new FirebaseService();
        $auth = $firebaseService->getAuth();

        try {
            $signInResult = $auth->signInWithEmailAndPassword($email, $password);

            $_SESSION['user'] = $signInResult->data();
//            echo "<pre>";
//            print_r($_SESSION);
//            echo "</pre>";
            return "Success";
        } catch (\Kreait\Firebase\Exception\Auth\InvalidPassword $e) {
            return "Contraseña incorrecta";
        } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
            return "Usuario no encontrado";
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function usuarioLogeado() {
        if (isset($_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
    }
}
