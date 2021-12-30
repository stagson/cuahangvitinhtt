<?php
class NguoiDung
{
    private $mand; //int 10 ky tu
    private $email; //string 50 ky tu
    private $matkhau; //string 32 ky tu
    private $hoten; //string 50 ky tu
    private $sodienthoai; //string 10 ky tu
    private $diachi; //string 150 ky tu
    private $loai; //int 1 ky tu (admin=0, user=1)
    public function __construct()
    {
        $this->mand = null;
        $this->email = null;
        $this->matkhau = null;
        $this->hoten = null;
        $this->sodienthoai = null;
        $this->diachi = null;
        $this->loai = null;
    }
    public function NguoiDung($mand, $email, $matkhau, $hoten, $sodienthoai, $diachi, $loai)
    {
        $this->mand = $mand;
        $this->email = $email;
        $this->matkhau = $matkhau;
        $this->hoten = $hoten;
        $this->sodienthoai = $sodienthoai;
        $this->diachi = $diachi;
        $this->loai = $loai;
    }
    public function queryDangKy()
    {
        $email = $this->email;
        $matkhau =  $this->matkhau;
        $hoten =  $this->hoten;
        $sodienthoai =  $this->sodienthoai;
        $diachi =  $this->diachi;
        $loai = $this->loai;
        $query = "INSERT INTO `nguoidung` ( `email`, `matkhau`,`hoten`,`sodienthoai`,`diachi`, `loai`)
                                VALUES ('$email', '$matkhau','$hoten','$sodienthoai','$diachi', '$loai')";
        return $query;
    }
    public function queryDoiMatKhauAdmin()
    {
        $mand = $this->mand;
        $matkhau =  $this->matkhau;
        $query = "UPDATE `nguoidung`
        SET `matkhau` = '$matkhau'
        WHERE `mand` = '$mand' AND loai=0";
        return $query;
    }
    public function queryTimEmailAdmin($email)
    {
        $query = "SELECT * FROM `nguoidung` WHERE email='$email' AND loai=0";
        return $query;
    }
    //set
    public function set_mand($mand)
    {
        $this->mand = (int)$mand;
    }
    public function set_email($email)
    {
        $this->email = $email;
    }
    public function set_matkhau($matkhau)
    {
        $this->matkhau = $matkhau;
    }
    public function set_hoten($hoten)
    {
        $this->hoten = $hoten;
    }
    public function set_sodienthoai($sodienthoai)
    {
        $this->sodienthoai = $sodienthoai;
    }
    public function set_diachi($diachi)
    {
        $this->diachi = $diachi;
    }
    public function set_loai($loai)
    {
        $this->loai = (int)$loai;
    }
    //get
    public function get_mand()
    {
        return (int)$this->mand;
    }
    public function get_email()
    {
        return $this->email;
    }
    public function get_matkhau()
    {
        return $this->matkhau;
    }
    public function get_hoten()
    {
        return $this->hoten;
    }
    public function get_sodienthoai()
    {
        return $this->sodienthoai;
    }
    public function get_diachi()
    {
        return $this->diachi;
    }
    public function get_loai()
    {
        return (int)$this->loai;
    }
}
