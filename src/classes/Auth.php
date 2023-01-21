<?php
session_start();

// define secret to remember-me option
define('TOKEN_SECRET', '8Tt389v9DwnUGhc6QVo');
class Auth extends Base
{
    private $userId;
    private $name;
    private $email;
    private $picture;


    public function __construct()
    {
        parent::__construct();

        if (isset($_SESSION['userId']) && isset($_SESSION['name']) && isset($_SESSION['email']) && isset($_SESSION['picture'])) {
            $this->userId = $_SESSION['userId'];
            $this->email = $_SESSION['name'];
            $this->name = $_SESSION['email'];
            $this->picture = $_SESSION['picture'];
        }
    }

    public function login($email, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email= ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            return false;
        }

        $user = $result->fetch_object();
        if (!password_verify($password, $user->password)) {
            return false;
        }

        foreach ($user as $key => $value) {
            $_SESSION[$key] = $value;
        }

        $this->userId = $user->userId;
        $this->email = $user->email;
        $this->name = $user->name;
        $this->picture = $user->picture;

        return true;
    }

    public function logout()
    {
        // invalida cookie de lembrar
        setcookie('login_data', null, -1, '/', null, null, true);
        session_destroy();
    }

    public function isAuthenticated()
    {
        return isset($_SESSION['userId']);
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPicture()
    {
        return ($this->picture) ? $this->picture : 'https://raw.githubusercontent.com/twbs/icons/main/icons/person-fill.svg';
    }

    public function getEmail()
    {
        return $this->email;
    }
}