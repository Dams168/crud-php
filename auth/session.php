<?php

// require_once '../database.php';
require_once __DIR__ . '/../database.php';
class Session
{
    public $db;
    public $login_user;
    public function __construct()
    {
        $this->db = new Database();
        session_start();
        $this->check_session();
        $this->logout();
    }
    public function check_session()
    {
        if (!isset($_SESSION['email'])) {
            if (basename($_SERVER['PHP_SELF']) !== 'index.php') {
                header("Location: index.php");
            }
            // echo "<script>window.location.href='auth/loginForm.php';</script>";
            return;
        }
        $ses_sql = "SELECT * FROM users where email='$_SESSION[email]'";
        $query = $this->db->mysqli->query($ses_sql);
        $row = $query->fetch_assoc();
        $this->login_user = $row['email'];

    }
    function logout()
    {
        if (isset($_POST['logout'])) {
            session_destroy();
            // header("location:loginForm.php");
            echo "<script>window.location.href='index.php';</script>";
        }
    }
}