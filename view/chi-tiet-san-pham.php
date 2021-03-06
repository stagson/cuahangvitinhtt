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
                                    <a href="index.php">Trang Ch???</a>
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
                                                    <p>M??: SP' . $sp['masp'] . '</p>
                                                </div>
                                                <div class="product-inner-category">
                                                    <p>Lo???i: <a href="may-bo.php">' . $tenLoai . '</a></p>
                                                    <p>H??ng: ' . $dmsp['ten'] . '</p>
                                                    <p>B???o h??nh: ' . $sp['baohanh'] . ' th??ng</p>';
                if ((int)$sp['soluong'] > 0) {
                    echo '<p>T??nh tr???ng: <span style="color:#219653;">C??n h??ng</span></p>';
                } else {
                    echo '<p>T??nh tr???ng: <span style="color:#c9302c;">H???t h??ng</span></p>';
                }
                echo '</div> 
                                                <div class="product-inner-price gia">
                                                    <ins>' . number_format($sp['dongia'], 0, ",", ".") . '??</ins> <del>' . number_format($SanPham->giaChuaGiam(), 0, ",", ".") . '??</del>
                                                </div>    
                                            
                                                <div class="quantity">
                                                    <input style="display: none;" type="text" name="maSanPham" value="' . $sp['masp'] . '">
                                                    <input type="number" size="4" class="input-text qty text" title="Qty" value="1" name="soLuongMua" min="1" step="1">
                                                </div>
                                                <button class="add_to_cart_button" type="submit">Th??m Gi??? H??ng</button>
                                            </form>   
                            
                                            
                                            <div role="tabpanel">
                                                <ul class="product-tab" role="tablist">
                                                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Th??ng Tin</a></li>
                                                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">B??nh Lu???n</a></li>
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
                                    <h2 class="related-products-title">S???N PH???M T????NG T???</h2>
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
                                                    <a href="../controller/xulygiohang.php?masanpham=SP01" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i> TH??M GI??? H??NG</a>
                                                    <a href="chi-tiet-san-pham.php?masp=' . $sp['masp'] . '" class="view-details-link"><i class="fa fa-link"></i> XEM CHI TI???T</a>
                                                </div>
                                            </div>
                            
                                            <h2><a href="chi-tiet-san-pham.php?masp=' . $sp['masp'] . '">' . $sp['tensp'] . '</a></h2>
                            
                                            <div class="product-carousel-price">
                                            <ins>' . number_format($sp['dongia'], 0, ",", ".") . '??</ins> <del>' . number_format($SanPham->giaChuaGiam(), 0, ",", ".") . '??</del>
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
        echo 'Kh??ng t??m th???y s???n ph???m!';
    }
    ?>

    </div>
    </div>
    </div>


    <?php include 'layout/footer.php'; ?>
</body>

</html>