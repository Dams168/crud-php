<?php

require_once '../database.php';

class login
{
    public $db;
    public function __construct()
    {
        session_start();
        $this->db = new Database();
        $this->check_login();
    }
    public function check_login()
    {
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $pass = $_POST['password'];
            if (empty($email) || empty($pass)) {
                echo "<script>alert('email atau Password tidak boleh kosong');</script>";
            } else {
                $sql = "SELECT * FROM users where email = '$email'";
                $result = $this->db->mysqli->query($sql);
                $check_email = $result->num_rows;
                if ($check_email == 1) {
                    $row = $result->fetch_assoc();
                    if (password_verify($pass, $row['password'])) {
                        $_SESSION['email'] = $email;
                        echo "<script>window.location.href='../index.php';</script>";
                    } else {
                        echo "<script>alert('Email atau Password invalid');</script>";
                    }
                } else {
                    echo "<script>alert('Email tidak terdaftar');</script>";
                }
            }
        }
    }
}