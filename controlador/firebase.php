<?php
require 'controlador/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

class FirebaseService {
    private $auth;
   
    public function __construct() {
       
        $factory = (new Factory)->withServiceAccount(__DIR__ . '/serviceAccountKey.json');
        $this->auth = $factory->createAuth();
    }

    public function getAuth() {
        return $this->auth;
    }
}
?>
