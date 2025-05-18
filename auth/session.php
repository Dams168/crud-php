<?php

// require_once '../database.php';
require_once __DIR__ . '/../database.php';
class Session
{
    public $db;
    public $login_user;
    public function __construct()
    {
        session_start();
        $this->db = new Database();
        $this->check_session();
        $this->logout();
    }
    public function check_session()
    {

        if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
            echo "<script>window.location.href='index.php';</script>";
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