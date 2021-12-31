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
    if (isset($_POST['btnDangKy'])) {//dang ky ************************************************
        $txtEmail = $_POST['txtEmail'];
        $txtPassword = $_POST['txtPassword'];
        $txtRePassword = $_POST['txtRePassword'];
        checkEmail($txtEmail);
        checkPassword($txtPassword);
        if ($txtPassword != $txtRePassword) {
            echo '<script>
            window.alert("Mật khẩu và nhập lại mật khẩu cần phải trùng khớp nhau!");
            window.history.back();
            </script>';
            die();
        }
        $NguoiDung = new NguoiDung();
        $queryTimEmailAdmin = $NguoiDung->queryTimEmailAdmin($txtEmail); //tìm thông tin tài khoản
        $nguoidung = $db->timMotDoiTuong($queryTimEmailAdmin);
        if ($nguoidung != null) {
            echo '<script>
            window.alert("Email đã tồn tại!");
            window.history.back();
            </script>';
            die();
        }
        $txtPassword = md5($txtPassword);
        $NguoiDung->NguoiDung(null, $txtEmail, $txtPassword,"","","",0); //mã sản phẩm tự tăng nên không điền
        $queryDangKy = $NguoiDung->queryDangKy();
        $flag = $db->themHoacXoa($queryDangKy); //them vao database thanh cong thi tra ve true
        if ($flag) {
            session_start();
            $_SESSION['Login'] = $txtEmail;
            echo '<script>
            window.alert("Đăng ký thành công!");
            window.location.href = "../view/tong-quan.php";
            </script>';
            die();
        }
        echo '<script>
          window.alert("Đăng ký thất bại!");
          window.history.back();
          </script>';
        die();
    }
}
