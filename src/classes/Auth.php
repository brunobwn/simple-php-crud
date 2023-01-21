<?php
session_start();

class Auth
{
    private $conn;
    private $userId;
    private $name;
    private $email;
    private $picture;


    public function __construct()
    {
        // Conecta ao banco de dados
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

        if (isset($_SESSION['userId']) && isset($_SESSION['name']) && isset($_SESSION['email']) && isset($_SESSION['picture'])) {
            $this->userId = $_SESSION['userId'];
            $this->email = $_SESSION['name'];
            $this->name = $_SESSION['email'];
            $this->picture = $_SESSION['picture'];
        }
    }

    public function login($email, $password)
    {
        $error['message'] = '';
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;

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
}