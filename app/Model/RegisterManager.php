<?php

namespace App\Model;


use Nette\Security\Passwords;
use App\Model\Repository\UzivatelRepository;

class RegisterManager
{
    private $uzivatel;
    
    public function __construct(UzivatelRepository $uzivatel)
    {
        $this->uzivatel= $uzivatel;
    }

    public function register($credentials)
    {
        $username = $_POST['uzivatel_jmeno'];
        $password = $_POST['heslo'];
        $email = $_POST['email'];

        if (!isset($_POST['uzivatel_jmeno'], $_POST['heslo'], $_POST['email'])) {
            // Could not get the data that should have been sent.
            return 'Please complete the registration form!';
        }

        if (empty($_POST['uzivatel_jmeno']) || empty($_POST['heslo']) || empty($_POST['email'])) {
            // One or more values are empty.
            return 'Please complete the registration form!';
        }

        if ($this->uzivatel->get_user($username)) {
           return  "User is already exists";
        }

        if ($this->uzivatel->get_email($email)) {
            return "Email is already exists";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Email is not valid";
        }

        if (preg_match('/^[a-zA-Z0-9]{4,50}+$/', $username) == 0) {
            return "Username is not valid";
        }
        if (strlen($password) > 20 || strlen($password) < 8) {
            return 'Password must be between 8 and 20 characters long!';
        }

        $password = password_hash($password, PASSWORD_BCRYPT);
       // $uniqid = uniqid();
         $uniqid ="activated";
        $this->uzivatel->create_user($username, $password, $email, $uniqid);

        return "ok";


    }
}
