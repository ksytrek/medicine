<?php include("./navbar.php") ?>


<section class="signin-page account">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="block">
                    <h2 class="text-center">ล็อกอินเขาสู่ระบบ</h2>

                    <form class="text-left clearfix mt-50" action="index.html">
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Password">
                        </div>
                        <button type="submit" class="btn btn-main">Sign In</button>

                    </form>
                    <!-- <p class="mt-20">New in this site ?<a href="signin.html"> Create New Account</a></p>
                    <p><a href="forget-password.html"> Forgot your password?</a></p> -->
                </div>
            </div>
        </div>
    </div>
</section>



<?php
include("./footer.php")
?>