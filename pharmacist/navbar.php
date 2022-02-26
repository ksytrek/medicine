<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="zxx">
<!--<![endif]-->

<?php
include_once "../config/config.inc.php";
include_once "../config/connectdb.php";
session_start();


$key = null;
if (isset($_SESSION['key']) && ($_SESSION['key'] == 'admin' || $_SESSION['key'] == 'pharmacist')) {
    $key = $_SESSION['key'];
} else {
    echo "<script> 
    alert('กรุณาล็อกอิน') ;
    location.assign('../index');
</script>";
}


?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="description" content="Bingo One page parallax responsive HTML Template ">

    <meta name="author" content="Themefisher.com">

    <title>Pharmacy</title>

    <!-- Mobile Specific Meta
  ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png" />

    <!-- CSS
  ================================================== -->
    <!-- Themefisher Icon font -->
    <link rel="stylesheet" href="../plugins/themefisher-font.v-2/style.css">
    <!-- bootstrap.min css -->
    <link rel="stylesheet" href="../plugins/bootstrap/dist/css/bootstrap.min.css">
    <!-- Slick Carousel -->
    <link rel="stylesheet" href="../plugins/slick-carousel/slick/slick.css">
    <link rel="stylesheet" href="../plugins/slick-carousel/slick/slick-theme.css">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="../css/style.css">




    <!-- Main jQuery -->
    <script src="../plugins/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../plugins/bootstrap/dist/js/popper.min.js"></script>
    <script src="../plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Owl Carousel -->
    <script src="../plugins/slick-carousel/slick/slick.min.js"></script>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <!-- Smooth Scroll js -->
    <script src="../plugins/smooth-scroll/dist/js/smooth-scroll.min.js"></script>

    <!-- Custom js -->
    <script src="../js/script.js"></script>

</head>

<body id="body">

    <!--
  Start Preloader
  ==================================== -->
    <div id="preloader">
        <div class="preloader">
            <div class="sk-circle1 sk-child"></div>
            <div class="sk-circle2 sk-child"></div>
            <div class="sk-circle3 sk-child"></div>
            <div class="sk-circle4 sk-child"></div>
            <div class="sk-circle5 sk-child"></div>
            <div class="sk-circle6 sk-child"></div>
            <div class="sk-circle7 sk-child"></div>
            <div class="sk-circle8 sk-child"></div>
            <div class="sk-circle9 sk-child"></div>
            <div class="sk-circle10 sk-child"></div>
            <div class="sk-circle11 sk-child"></div>
            <div class="sk-circle12 sk-child"></div>
        </div>
    </div>
    <section class="header  navigation">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg">
                        <a class="navbar-brand" href="index">
                            <!-- <img src="../images/logo.png" alt="logo"> -->
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="tf-ion-android-menu"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item active">
                                    <a class="nav-link" href="./index">Home <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./drug_information">ข้อมูลยา</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./information_mem">ข้อมูลสมาชิก</a>
                                </li>
                                <?php if($key == 'admin'): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="./pharmacist_inform">ข้อมูลเภสัช</a>
                                    </li>
                                <?php endif; ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="./order_history">ประวัติการขาย</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="../controllers/logout.php">ออกจากระบบ</a>
                                </li>
                            </ul>
                        </div>
                    </nav>

                </div>
            </div>
        </div>
    </section>


    <script>
        $(document).ready(function() {
            var product = [];
            if (readCookie('product') == null) {

                createCookie("product", JSON.stringify(product));

            }
        });
        //  COOKie function
        function createCookie(name, value, days = 1) { // date /1 วัน
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));

                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + value + expires + "; path=/";
        }

        function readCookie(name) {
            var name1 = name + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1, c.length);
                }
                if (c.indexOf(name1) == 0) {
                    return c.substring(name1.length, c.length);
                }
            }
            return null;
        }

        function removeCookie(name) {
            createCookie(name, "", -1);
        }

        function add_product(id_drug, name_drug, price_unit, num_item) {
            var product = [];
            var int_i = 0;

            product_new = {
                id_drug: id_drug,
                name_drug: name_drug,
                price_unit: price_unit,
                price_unit: price_unit,
                num_item: num_item
            };

            if (readCookie('product') == null) {
                createCookie("product", JSON.stringify(product));

                product.push(product_new);
                createCookie("product", JSON.stringify(product));
                update_product();

            } else {
                product = JSON.parse(readCookie('product')); // array type
                product.forEach(function(value, i) {
                    if (value.id_drug == id_drug) {
                        int_i += 1;
                        product[i].num_item += num_item;
                    }
                });

                if (int_i == 0) {

                    product.push(product_new);
                    createCookie("product", JSON.stringify(product));

                    update_product();
                } else {
                    createCookie("product", JSON.stringify(product));
                    update_product();
                }

            }
            $("#" + num_item).val(1);
        }

        function update_product() {
            // var product = json.parse(readCookie('product'));
            var str_items = "";

            const json = readCookie('product');
            const product = JSON.parse(json);

            var sum_total = 0;

            $('#tb_shell').empty();
            // tb_mg_room.clear();
            product.forEach(function(value, index) {
                // alert(index);

                str_items += '<tr>' +
                    '<td>' + value.name_drug + '</td>' +
                    '<td>' + value.price_unit + '</td>' +
                    '<td>' + value.num_item + '</td>' +
                    '<td>' + value.num_item * value.price_unit + '</td>' +
                    '</tr>';
                sum_total += value.num_item * value.price_unit;

            });
            // alert(product.length)
            if (product.length == 0 || product == null) {

                str_items += "<tr><td>ไม่พบรายการ</td><td></td><td></td><td></td></tr>";
            }
            $("#sum_total").html(sum_total)
            $('#tb_shell').html(str_items);
        }

        // add_product('1', 'ยา', '150', 6);
    </script>