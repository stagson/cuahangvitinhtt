<?php
if (count($_GET) > 0) {
    if ($_GET['action'] == "logout") {
        session_start();
        unset($_SESSION["Login"]);
        header("Location: ../view/");
        exit();
    }
}
if (count($_POST) > 0) {
    include '../model/database.php';
    include '../model/nguoidung.php';
    include 'hamtienich.php';
    $db = new Database();
    if (isset($_POST['btnLogin'])) {//dang nhap ************************************************
        $txtEmail = $_POST['txtEmail'];
        $txtPassword = $_POST['txtPassword'];
        checkEmail($txtEmail);
        checkPassword($txtPassword);
        $NguoiDung = new NguoiDung();
        $queryTimEmailAdmin = $NguoiDung->queryTimEmailAdmin($txtEmail); //tìm thông tin tài khoản
        $nguoidung = $db->timMotDoiTuong($queryTimEmailAdmin);
        if ($nguoidung == null) {
            echo '<script>
            window.alert("Email không tồn tại!");
            window.history.back();
            </script>';
            die();
        }
        $txtPassword = md5($txtPassword);
        if ($txtPassword != $nguoidung['matkhau']) {
            echo '<script>
            window.alert("Mật khẩu không đúng!");
            window.history.back();
            </script>';
            die();
        }
        session_start();
        $_SESSION['Login'] = $txtEmail;
        header("Location: ../view/tong-quan.php");
        exit();
    }
}
