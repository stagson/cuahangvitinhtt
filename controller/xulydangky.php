<?php
include "ham.php";
if(count($_POST)>0){
    session_start();
    $kiemTra=kiemTraDangKy($_POST,$_SESSION["dangKy"]);// da kiem tra cu phap email trong ham
    if($kiemTra==0){//email dang ky chua ton tai trong ds kh thi cho phep tiep tuc dang ky
        $email = $_POST['email'];
        $password = $_POST['password'];
        $repassword = $_POST['repassword'];        
        $viTriKhachHangTrongDS=0;        
        if($password==$repassword && kiemTraPassword($password)){//da kiem tra password va repassword co trung nhau hay khong            
            if (sizeof($_SESSION["dangKy"])>0){
                $viTriKhachHangTrongDS=sizeof($_SESSION["dangKy"]);
            }
            $_SESSION["email"]=$email;
            $_SESSION["dangKy"][$viTriKhachHangTrongDS]["email"]=$email;//them kh vao ds kh
            $_SESSION["dangKy"][$viTriKhachHangTrongDS]["password"]=$password;
            echo'
            <script>
                window.alert("Đăng ký thành công!");
                window.history.back();
            </script>
            ';
            exit();
        }
        echo'
            <script>
                window.alert("Nhập lại mật khẩu!");
                window.history.back();
            </script>
                ';
            exit();
    }else if($kiemTra==1){
        echo'
        <script>
            window.alert("Email đã tồn tại!");
            window.history.back();
        </script>
        ';
        exit();
    }
    echo'
    <script>
        window.history.back();
    </script>
    ';
    exit();
}
?>