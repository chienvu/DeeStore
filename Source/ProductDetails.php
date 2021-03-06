<!doctype html>
<html lang="en" data-ng-app="App">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php
        include './Share/MasterInclude.php';
        ?>
        <?php
        // get product id
        $pId = str_replace("'", "", $_GET['_id']);
        $producthead = new Product();
        $resultDetailsProducthead = $producthead->FetchProductByProductId($pId);
        while ($row1 = mysqli_fetch_array($resultDetailsProducthead)) {
            echo '<title>' . $row1["ProductName"] . ' - Deestore Shop</title>';
            break;
        }
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        echo ' <link rel="canonical" href="' . $actual_link . '">';
        ?>
        <?php
        include './Share/MetaSEO_Lib.php';
        ?>
    </head>
    <style> body{background-color: #FFF} </style>
    <body data-status="{{ status }}">
        <div id="page">
            <?php
            include './Share/Header.php';
            ?>
            <div class="bodyContent">
                <div class='Inside'>
                    <div class="left">
                        <div class="titleCate">
                            <h2 style="color: #dc2606">DEESTORE SHOP</h2>
                            <?php
                            include './Share/LeftMenu.php';
                            ?>
                        </div>
                        <div class="titleCate" title="giới thiệu" style="margin-top: 20px">
                            <?php
                            include './About.php';
                            ?>
                        </div>
                    </div>
                    <div class="right">
                        <div class="boundDetails">
                            <?php
                            $product = new Product();
                            $resultDetailsProduct = $product->FetchProductByProductId($pId);
                            while ($rowDetails = mysqli_fetch_array($resultDetailsProduct)) {
                                echo '<div class="post warpperDetails postcontent">
                                <div class="leftDetails">
                                    <h2 class="title" title="' . $rowDetails["ProductName"] . '">' . $rowDetails["ProductName"] . '</h2>
                                    <div class="description" title="' . $rowDetails["ProductDescription"] . '"><h3 title="' . $rowDetails["ProductDescription"] . '">
                                    ' . $rowDetails["ProductDescription"] . '
                                    </h3></div>
                                    <div class="inforProduct">
                                        <div class="size">
                                            <label>SIZE:</label> ';
                                $joinProduct = new JoinProductSize();
                                $resultJoinProduct = $joinProduct->FetchJoinProductSizeByProductID($pId);
                                while ($row = mysqli_fetch_array($resultJoinProduct)) {
                                    $productSize = new ProductSize();
                                    $resultSize = $productSize->FetchProductSizeByProductSizeId($row["ProductSizeID"]);
                                    while ($rowSize = mysqli_fetch_array($resultSize)) {
                                        echo '<a href="">' . $rowSize["ProductSizeNumber"] . '</a>';
                                        break;
                                    }
                                }
                                echo'  </div>
                                <div class="price">';
                                if (isset($rowDetails['ProductPriceOld']) && !empty($rowDetails['ProductPriceOld'])) {
                                    echo '<label class="oldPrice">' . number_format($rowDetails['ProductPriceOld'], 0, '.', '.') . ' VNĐ</label>';
                                }
                                if (isset($rowDetails['ProductPriceCurrent']) && !empty($rowDetails['ProductPriceCurrent'])) {
                                    echo '<label class="currentPrice">Giá: ' . number_format($rowDetails['ProductPriceCurrent'], 0, '.', '.') . ' VNĐ</label>';
                                }
                                echo '<div class=\'detailsproduct\'>' . $rowDetails['ProductDetails'] . '</div>';
                                echo '</div></div>';
                                echo '</div>
                                <div class="rightDetails">
                                    <div class="contentImageSLide images">
                                        <div class="mainImgSlide">
                                            <img src="/Dashboard/Media/Images/Products/' . $rowDetails['ProductPathImage'] . '" width="172px"/>
                                        </div>
                                        <div class="slideSmalIcon">
                                            <div class="smallImg">';
                                $ProductGallery = new ProductGallery();
                                $resultGallery = $ProductGallery->FetchProductGalleryByProductId($pId);
                                while ($row2 = mysqli_fetch_array($resultGallery)) {
                                    echo "<img src=/Dashboard/Media/Images/Products/" . $row2['ProductGalleryPath'] . ">" . "</img>";
                                }
                                echo '</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-ship"> 
                                    <h2 class="titleShip">SẢN PHẨM CÙNG LOẠI</h2>
                                    <div class="contentProductShow" style="border: none">
                                        <div class="productContent"> ';

                                $product = new Product();
                                $resultpShip = $product->FetchProductByCategoriesId($_GET["cateId"]);
                                while ($row3 = mysqli_fetch_array($resultpShip)) {
                                    echo '<div class="items">
                                                <div class="sizeH">
                                                    <label style="color:#000">
                                                        SIZE: ';
                                    $joinProduct = new JoinProductSize();
                                    $resultJoinProduct = $joinProduct->FetchJoinProductSizeByProductID($pId);
                                    while ($row = mysqli_fetch_array($resultJoinProduct)) {
                                        $productSize = new ProductSize();
                                        $resultSize = $productSize->FetchProductSizeByProductSizeId($row["ProductSizeID"]);
                                        while ($rowSize = mysqli_fetch_array($resultSize)) {
                                            echo '<a style="color:#fff" href="">' . $rowSize["ProductSizeNumber"] . '</a> &nbsp;<span style="color:#fff">|</span>&nbsp;';
                                            break;
                                        }
                                    }

                                    echo '</label>
                                                </div>
                                                <div class="opImage">';
                                    
                                    if (isset($row3['ProductPriceOld']) && !empty($row3['ProductPriceOld']) && isset($row3['ProductPriceCurrent']) && !empty($row3['ProductPriceCurrent'])) {
                                        $percent = ((intval($row3['ProductPriceCurrent']) - intval($row3['ProductPriceOld'])) / intval($row3['ProductPriceOld'])) * 100;
                                        echo '<div class="salepercent"><span>' . round($percent) . '</span></div>';
                                    }
                                    echo '<img src="/Dashboard/Media/Images/Products/' . $row3["ProductPathImage"] . '">
                                                </div> 
                                                <div>
                                                    <label class="opnameProduct">
                                                        ' . $row3["ProductName"] . '
                                                    </label>
                                                    <label class="opDescription">
                                                      ' . $row3["ProductDescription"] . '
                                                    </label>';
                                    // PRICE OLD
                                    if (isset($row3['ProductPriceOld']) && !empty($row3['ProductPriceOld'])) {
                                        echo '<label class="opOldPrice">' . number_format($row3['ProductPriceOld'], 0, '.', '.') . ' VNĐ</label>';
                                    }
                                    // PRICE CURRENT
                                    if (isset($row3['ProductPriceCurrent']) && !empty($row3['ProductPriceCurrent'])) {
                                        echo '<label class="opCurrentPrice">' . number_format($row3['ProductPriceCurrent'], 0, '.', '.') . ' VNĐ</label>';
                                    }
                                    echo ' <label class="deestoreKy">
                                                        DEESTORE
                                                    </label>
                                                </div>
                                            </div>';
                                }
                                echo' </div>
                                    </div>
                                </div>
                            </div>';
                                break;
                            }
                            ?>
                            <div style="display: block;float: left; margin-top: 10px;width: 100%;">
                                <div id="disqus_thread" style="margin-top: 10px"></div>
                                <script type="text/javascript">
                                    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
                                    var disqus_shortname = 'deestore'; // required: replace example with your forum shortname

                                    /* * * DON'T EDIT BELOW THIS LINE * * */
                                    (function() {
                                        var dsq = document.createElement('script');
                                        dsq.type = 'text/javascript';
                                        dsq.async = true;
                                        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                                        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                                    })();
                                </script>
                                <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                                <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
                            </div>
                        </div>                       
                        <div ng-view> 
                        </div>
                    </div>
                </div>
            </div>
            <?php
            include './Share/Footer.php';
            ?>
        </div>
    </body>
</html>
