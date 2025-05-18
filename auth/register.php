<?php

require_once '../database.php';

class Register
{
    public $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function register()
    {
        $username = $_POST['username'];
        $pass = $_POST['password'];
        $email = $_POST['email'];
        if (empty($username) || empty($pass) || empty($email)) {
            echo "<script>alert('Username, Password, or email cannot be empty');</script>";
        } else {
            $get_user = "SELECT * FROM users where email = '$email'";
            $result = $this->db->mysqli->query($get_user);
            $check_email = $result->num_rows;
            if ($check_email == 1) {
                echo "<script>alert('Email sudah Terdaftar');</script>";
            } else {
                $pass = password_hash($pass, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (username, email, password) VALUES ('" . $username . "','" . $email . "','" . $pass . "')";

                $query = $this->db->mysqli->prepare($sql) or die($this->db->mysqli->error);
                $query->execute();
                if ($query) {
                    // header("location:loginForm.php");
                    echo "<script>window.location.href='loginForm.php';</script>";
                } else {
                    echo "<script>alert('Register gagal');</script>";
                }
            }
        }
    }
}