<!DOCTYPE html>
<!--
	ustora by freshdesignweb.com
	Twitter: https://twitter.com/freshdesignweb
	URL: https://www.freshdesignweb.com/ustora/
-->
<html lang="en">

<head>
    <?php include 'layout/head.php'; ?>
</head>

<body>
    <?php
    include 'layout/header-menu.php';
    include_once '../admin/model/database.php';
    include_once '../admin/model/sanpham.php';
    include_once '../admin/model/danhmucsp.php';
    $db = new Database();
    $SanPham = new SanPham();
    $DanhMucSP = new DanhMucSP();
    if (isset($_GET['masp'])) {
        $masp = $_GET['masp'];
        $queryTimSanPhamTheoMa = $SanPham->queryTimSanPhamTheoMa($masp);
        $sp = $db->timMotDoiTuong($queryTimSanPhamTheoMa);
        if ($sp != null) {
            $SanPham->set_dongia($sp['dongia']);
            $queryTimDanhMucSPTheoMa = $DanhMucSP->queryTimDanhMucSPTheoMa($sp['madmsp']);
            $dmsp = $db->timMotDoiTuong($queryTimDanhMucSPTheoMa);
            $tenLoai = "";
            if ($dmsp != null) {
                if ($dmsp['madmspcha'] == "1") { //
                    $tenLoai = "PC";
                } else if ($dmsp['madmspcha'] == "3") { //
                    $tenLoai = "Laptop";
                }
                echo '    <div class="product-big-title-area">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="product-bit-title text-center">
                                            <h2>' . $tenLoai . '</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="single-product-area">
                            <div class="zigzag-bottom"></div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4">';
                include 'layout/sidebar.php';
                echo '
                            </div>
                            <div class="col-md-8">
                            <div class="product-content-right">
                                <div class="product-breadcroumb">
                                    <a href="index.php">Trang Chủ</a>
                                    <a href="may-bo.php">' . $tenLoai . '</a>
                                    <a href="chi-tiet-san-pham.php?masp=' . $sp['masp'] . '">' . $sp['tensp'] . '</a>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="product-images">
                                            <div class="product-main-img">
                                                <img src="../view/img/uploads/' . $sp['hinh'] . '" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <div class="product-inner">
                                            <form action="../controller/xulygiohang.php" method="post" class="cart">
                            
                                                <h2 class="product-name ten-sp">' . $sp['tensp'] . '</h2>
                                                <div class="product-inner-category">
                                                    <p>Mã: SP' . $sp['masp'] . '</p>
                                                </div>
                                                <div class="product-inner-category">
                                                    <p>Loại: <a href="may-bo.php">' . $tenLoai . '</a></p>
                                                    <p>Hãng: ' . $dmsp['ten'] . '</p>
                                                    <p>Bảo hành: ' . $sp['baohanh'] . ' tháng</p>';
                if ((int)$sp['soluong'] > 0) {
                    echo '<p>Tình trạng: <span style="color:#219653;">Còn hàng</span></p>';
                } else {
                    echo '<p>Tình trạng: <span style="color:#c9302c;">Hết hàng</span></p>';
                }
                echo '</div> 
                                                <div class="product-inner-price gia">
                                                    <ins>' . number_format($sp['dongia'], 0, ",", ".") . 'đ</ins> <del>' . number_format($SanPham->giaChuaGiam(), 0, ",", ".") . 'đ</del>
                                                </div>    
                                            
                                                <div class="quantity">
                                                    <input style="display: none;" type="text" name="maSanPham" value="' . $sp['masp'] . '">
                                                    <input type="number" size="4" class="input-text qty text" title="Qty" value="1" name="soLuongMua" min="1" step="1">
                                                </div>
                                                <button class="add_to_cart_button" type="submit">Thêm Giỏ Hàng</button>
                                            </form>   
                            
                                            
                                            <div role="tabpanel">
                                                <ul class="product-tab" role="tablist">
                                                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Thông Tin</a></li>
                                                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Bình Luận</a></li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div role="tabpanel" class="tab-pane fade in active" id="home">
                                                        <div class="reset">' . $sp['mota'] . '</div>
                                                    </div>
                                                    <div role="tabpanel" class="tab-pane fade" id="profile">
                                                        <div class="reset">
                                                        </div>';
                include 'layout/cmt-sp.php';
                echo '
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="related-products-wrapper">
                                    <h2 class="related-products-title">SẢN PHẨM TƯƠNG TỰ</h2>
                                    <div class="related-products-carousel">';
                $queryLayDanhSachSanPham = $SanPham->queryLayDanhSachSanPham();
                $arrSanPham = $db->timDanhSach($queryLayDanhSachSanPham);
                if (count($arrSanPham) > 0) {
                    foreach ($arrSanPham as $sp) {
                        $SanPham->set_dongia($sp['dongia']);
                        $queryTimDanhMucSPTheoMa = $DanhMucSP->queryTimDanhMucSPTheoMa($sp['madmsp']);
                        $dmsp1 = $db->timMotDoiTuong($queryTimDanhMucSPTheoMa);
                        if ($dmsp1 != null) {
                            if ($dmsp1['madmspcha'] == $dmsp['madmspcha']) { //
                                echo '<div class="single-product">
                                            <div class="product-f-image">
                                                <img src="../view/img/uploads/' . $sp['hinh'] . '" alt="">
                                                <div class="product-hover">
                                                    <a href="../controller/xulygiohang.php?masanpham=SP01" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i> THÊM GIỎ HÀNG</a>
                                                    <a href="chi-tiet-san-pham.php?masp=' . $sp['masp'] . '" class="view-details-link"><i class="fa fa-link"></i> XEM CHI TIẾT</a>
                                                </div>
                                            </div>
                            
                                            <h2><a href="chi-tiet-san-pham.php?masp=' . $sp['masp'] . '">' . $sp['tensp'] . '</a></h2>
                            
                                            <div class="product-carousel-price">
                                            <ins>' . number_format($sp['dongia'], 0, ",", ".") . 'đ</ins> <del>' . number_format($SanPham->giaChuaGiam(), 0, ",", ".") . 'đ</del>
                                            </div> 
                                        </div>';
                            }
                        }
                    }
                }

                echo '                                     
                                    </div>
                                </div>
                            </div>                    
                            </div>
                            
                            ';
            }
        }
    } else {
        echo 'Không tìm thấy sản phẩm!';
    }
    ?>

    </div>
    </div>
    </div>


    <?php include 'layout/footer.php'; ?>
</body>

</html>