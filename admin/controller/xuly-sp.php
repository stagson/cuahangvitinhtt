<?php
//*************************************
if (count($_POST) > 0 || count($_GET) > 0) {
  include '../model/database.php';
  include '../model/sanpham.php';
  include '../model/danhmucsp.php';
  include 'hamtienich.php';
  $db = new Database();  
  if (isset($_POST['btnThem'])) { //xu ly them ************************************************
    $txtTenSanPham = strip_tags($_POST['txtTenSanPham']);
    $cbxDanhMuc = (int)strip_tags($_POST['cbxDanhMuc']);
    $cbxBaoHanh = (int)strip_tags($_POST['cbxBaoHanh']);
    $numSoLuong = (int)strip_tags($_POST['numSoLuong']);
    $numGia = (double)strip_tags($_POST['numGia']);
    $txtMoTa = strip_tags($_POST['txtMoTa']); //co the bo trong
    $fileHinh = $_FILES['fileHinh'];

    if (!checkInputTenSanPham($txtTenSanPham)) {
      echo '<script>
        window.alert("Chưa nhập tên sản phẩm!");
        window.history.back();
        </script>';
      die();
    }
    $SanPham = new SanPham();
    
    $DanhMucSP = new DanhMucSP();
    $queryTimDanhMucSPTheoMa = $DanhMucSP->queryTimDanhMucSPTheoMa($cbxDanhMuc);
    $dmsp = $db->timMotDoiTuong($queryTimDanhMucSPTheoMa);
    if($dmsp==null){
      echo '<script>
        window.alert("Nhập sai danh mục!");
        window.history.back();
        </script>';
      die();
    }
    if (!checkInputBaoHanh($cbxBaoHanh)) { //kiểm tra nhập bậy thời gian bảo hành
      echo '<script>
        window.alert("Nhập sai thời gian bảo hành!");
        window.history.back();
        </script>';
      die();
    }
    //1.000.000.000
    if (!checkInputSoLuong($numSoLuong)) {
      echo '<script>
        window.alert("Nhập sai số lượng!");
        window.history.back();
        </script>';
      die();
    }
    if (!checkInputGiaSanPham($numGia)) {
      echo '<script>
        window.alert("Nhập sai giá bán!");
        window.history.back();
        </script>';
      die();
    }
    $ketQuaUpload = checkFile($fileHinh);
    if ($ketQuaUpload != "Đã upload thành công") { //upload file thất bại va thong bao loi
      echo '<script>
        window.alert("' . $ketQuaUpload . '");
        window.history.back();
        </script>';
      die();
    }
    $SanPham->SanPham(null, $txtTenSanPham, $cbxDanhMuc, $cbxBaoHanh, $numSoLuong, $numGia, $txtMoTa, $fileHinh['name']); //mã sản phẩm tự tăng nên không điền
    $query = $SanPham->queryThem();
    $flag = $db->themHoacXoa($query); //them vao database thanh cong thi tra ve true
    if ($flag) {
      echo '<script>
          window.alert("Thêm sản phẩm thành công!");
          window.history.back();
          </script>';
      die();
    }
    echo '<script>
          window.alert("Thêm sản phẩm thất bại!");
          window.history.back();
          </script>';
    die();
  }
  
  if (isset($_POST['btnSua'])) { //xu ly sua ************************************************
    $txtTenSanPham = strip_tags($_POST['txtTenSanPham']);
    $cbxDanhMuc = (int)strip_tags($_POST['cbxDanhMuc']);
    $cbxBaoHanh = (int)strip_tags($_POST['cbxBaoHanh']);
    $numSoLuong = (int)strip_tags($_POST['numSoLuong']);
    $numGia = (double)strip_tags($_POST['numGia']);
    $txtMoTa = strip_tags($_POST['txtMoTa']); //co the bo trong
    $fileHinh = $_FILES['fileHinh'];

    if (!checkInputTenSanPham($txtTenSanPham)) {
      echo '<script>
        window.alert("Chưa nhập tên sản phẩm!");
        window.history.back();
        </script>';
      die();
    }
    $DanhMucSP = new DanhMucSP();
    $queryTimDanhMucSPTheoMa = $DanhMucSP->queryTimDanhMucSPTheoMa($cbxDanhMuc);
    $dmsp = $db->timMotDoiTuong($queryTimDanhMucSPTheoMa);
    if($dmsp==null){
      echo '<script>
        window.alert("Nhập sai danh mục!");
        window.history.back();
        </script>';
      die();
    }
    if (!checkInputBaoHanh($cbxBaoHanh)) { //kiểm tra nhập bậy thời gian bảo hành
      echo '<script>
        window.alert("Nhập sai thời gian bảo hành!");
        window.history.back();
        </script>';
      die();
    }
    //1.000.000.000
    if (!checkInputSoLuong($numSoLuong)) {
      echo '<script>
        window.alert("Nhập sai số lượng!");
        window.history.back();
        </script>';
      die();
    }
    if (!checkInputGiaSanPham($numGia)) {
      echo '<script>
        window.alert("Nhập sai giá bán!");
        window.history.back();
        </script>';
      die();
    }
    if ($fileHinh['size'] > 0) { //có sửa hình thì kiểm tra hình upload
      $ketQuaUpload = checkFile($fileHinh);
      if ($ketQuaUpload != "Đã upload thành công") { //upload file thất bại va thong bao loi
        echo '<script>
          window.alert("' . $ketQuaUpload . '");
          window.history.back();
          </script>';
        die();
      }
    }
    $SanPham = new SanPham();
    $maSanPhamCanSua = $_GET['masp'];
    $queryTimSanPhamTheoMa = $SanPham->queryTimSanPhamTheoMa($maSanPhamCanSua);
    $sp = $db->timMotDoiTuong($queryTimSanPhamTheoMa);
    if ($sp == null) {
      echo '<script>
        window.alert("Không tìm thấy sản phẩm cần sửa!");
        window.history.back();
        </script>';
      die();
    }
    if (isset($ketQuaUpload)) { //kiem tra xem co sua lai hinh san pham khong neu co xoa anh cu
      xoaFile($sp['hinh']); //xoa hinh cu
      $sp['hinh'] = $fileHinh['name'];
    }
    $SanPham->SanPham($maSanPhamCanSua, $txtTenSanPham, $cbxDanhMuc, $cbxBaoHanh, $numSoLuong, $numGia, $txtMoTa, $sp['hinh']);
    $query = $SanPham->querySua();
    $flag = $db->sua($query); //sua vao database thanh cong thi tra ve true
    if ($flag) {
      echo '<script>
          window.alert("Sửa sản phẩm thành công!");
          window.history.back();
          </script>';
      die();
    }
    echo '<script>
          window.alert("Sửa sản phẩm thất bại!");
          window.history.back();
          </script>';
    die();
  }
}
