<?php
include_once "flash.php";
session_start();
$_SESSION['username'];
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Login - Heal as One (Bulacan) Facilitator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="ArchitectUI HTML Bootstrap 4 Dashboard Template">

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">

    <link href="./main.d810cf0ae7f39f28f336.css" rel="stylesheet">
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow">
        <div class="app-container">
            <div class="h-100">
                <div class="h-100 no-gutters row">
                    <div class="d-none d-lg-block col-lg-5">
                        <div class="slider-light">
                            <div class="slick-slider">
                                <div>
                                    <div class="position-relative h-100 d-flex justify-content-center align-items-center bg-royal" tabindex="-1">
                                        <div class="slide-img-bg" style="background-image: url('assets/images/originals/citydark.jpg');"></div>
                                        <div class="slider-content">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="h-100 d-flex bg-white shadow-lg justify-content-center align-items-center col-md-12 col-lg-7">
                        <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
                            <div class="app-logo-inverse"></div>
                            <br>
                            <h4 class="mb-0">
                                <span class="d-block">
                                    <b class="font-weight-bold h4">Welcome back!</b>
                                </span>
                                <span>
                                    Please sign in to your account.
                                </span>
                            </h4>
                            <h6 class="mt-3">New facility or need another account? <a href="javascript:void(0);" class="text-primary">Email Us!</a></h6>
                            <div class="divider row"></div>
                            <div>
                                <form id="loginForm" class="mx-auto" method="post" action="signin.php">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="username" class=""><b>Username:</b></label>
                                                <input name="username" id="username" placeholder="Username" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="password" class=""><b>Password:</b></label>
                                                <input name="password" id="password" placeholder="Password" type="password" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    if (isset($_SESSION["flash_message"])) {
                                        flash_message("Incorrect username or password.", "invalidpassword");
                                        flash_message("Username or password cannot be empty.", "emptyfields");
                                    }
                                    unset($_SESSION["flash_message"]);
                                    ?>
                                    <div class="divider row"></div>
                                    <div class="d-flex align-items-center">
                                        <div class="ml-auto">
                                            <button class="mb-2 mr-2 btn btn-dark btn-lg btn-block" name="submit">Login</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="./assets/scripts/main.d810cf0ae7f39f28f336.js"></script>
</body>

</html>