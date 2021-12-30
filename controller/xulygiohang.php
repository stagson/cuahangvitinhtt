<?php
include "ham.php";
if(count($_GET)>0){
    session_start();

    if(isset($_GET['masanpham'])){
        $maSanPhamChonMua=$_GET['masanpham']."";
        $soLuongMua=1;
        themSanPhamVaoGio($maSanPhamChonMua,$soLuongMua,$_SESSION);        
    echo'
    <script>
        window.alert("Đã thêm vào giỏ hàng!");
        window.history.back();
    </script>
        ';
        exit();
    } 
}

if(count($_POST)>0){
    session_start();    
    
    if(isset($_POST['xoaSanPham'])){
        $maSanPham=$_POST['xoaSanPham'];
        $viTriSP=timViTriSPtrongGioHang($maSanPham,$_SESSION["maSanPham"]);
        if($viTriSP>-1){
            $_SESSION["tongSoLuongMua"]-=$_SESSION["soLuongMua"][$viTriSP];
            $_SESSION["soLuongMua"][$viTriSP]=0;
        }
        header("Location: ../view/gio-hang.php");
        exit();
    } 
    if(isset($_POST['capNhatGioHang'])){
        capNhatSoLuongCuaTungSanPhamTrongGioHang($_POST,$_SESSION);
        header("Location: ../view/gio-hang.php");
        exit();
    }
    if(isset($_POST['thanhToanGioHang'])){
        capNhatSoLuongCuaTungSanPhamTrongGioHang($_POST,$_SESSION);
        header("Location: ../view/thanh-toan.php");
        exit();
    }

    if(isset($_POST['maSanPham']) && isset($_POST['soLuongMua'])){
        $maSanPhamChonMua=$_POST['maSanPham'];
        $soLuongMua=$_POST['soLuongMua'];
        themSanPhamVaoGio($maSanPhamChonMua,$soLuongMua,$_SESSION);        
    echo'
    <script>
        window.alert("Đã thêm vào giỏ hàng!");
        window.history.back();
    </script>
        ';
        exit();
    }
}
?>