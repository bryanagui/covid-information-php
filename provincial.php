<?php
session_start();
if (!(isset($_SESSION['username'])) && !(isset($_SESSION['userid'])) && !(isset($_SESSION['roleid']))) {
    header("Location: login.php");
    exit;
}
require_once 'db.php';

$query = "SELECT * FROM fcusers_facilitator WHERE userid = ?;";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $query)) {
    echo "failed to connect";
} else {
    mysqli_stmt_bind_param($stmt, "s", $_SESSION["userid"]);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    $fullname = $row["firstname"] . " " . $row["lastname"];
    mysqli_stmt_close($stmt);
}

$query_getHospitalName = "SELECT * FROM fcdb_facilities";
$stmt_getHospitalName = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt_getHospitalName, $query_getHospitalName)) {
    echo "failed to connect";
}
mysqli_stmt_execute($stmt_getHospitalName);

$result_getHospitalName = mysqli_stmt_get_result($stmt_getHospitalName);

mysqli_stmt_close($stmt_getHospitalName);

$query_update = "UPDATE fcuser_info SET lastactivity = ? WHERE userid = ?;";
$stmt_update = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt_update, $query_update)) {
    echo "failed to connect";
}
date_default_timezone_set("Asia/Singapore");
mysqli_stmt_bind_param($stmt_update, "ss", date("Y-m-d H:i:s"), $_SESSION["userid"]);
mysqli_stmt_execute($stmt_update);
mysqli_stmt_close($stmt_update);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-L anguage" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Home - Heal as One (Bulacan) Facilitator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link href="./main.d810cf0ae7f39f28f336.css" rel="stylesheet">
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <div class="logo-src"></div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>
            <div class="app-header__content">
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                            <img width="42" class="rounded-circle" src="assets/images/avatars/1.jpg" alt="">
                                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                            <div class="dropdown-menu-header">
                                                <div class="dropdown-menu-header-inner bg-info">
                                                    <div class="menu-header-image opacity-1" style="background-image: url('assets/images/dropdown-header/abstract10.jpg');"></div>
                                                    <div class="menu-header-content text-left">
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">
                                                                <div class="widget-content-left mr-3">
                                                                    <img width="42" class="rounded-circle" src="assets/images/avatars/1.jpg" alt="">
                                                                </div>
                                                                <div class="widget-content-left">
                                                                    <div class="widget-heading opacity-10"><?php echo $fullname ?></div>
                                                                    <div class="widget-subheading opacity-8"><?php
                                                                                                                if ($_SESSION["roleid"] == "701") {
                                                                                                                    echo "Administrator";
                                                                                                                } else if ($_SESSION["roleid"] == "702") {
                                                                                                                    echo "Moderator";
                                                                                                                } else if ($_SESSION["roleid"] == "703") {
                                                                                                                    echo "Manager";
                                                                                                                } else {
                                                                                                                    echo "Health Facilitator";
                                                                                                                }
                                                                                                                ?></span>
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-right mr-2">
                                                                    <form id="logout" method="post" action="logout.php">
                                                                        <button class="btn-pill btn-shadow btn-shine btn btn-focus" name="logout">Logout</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-heading"> <?php echo $fullname; ?> </div>
                                    <div class="widget-subheading"><?php
                                                                    if ($_SESSION["roleid"] == "701") {
                                                                        echo "Administrator";
                                                                    } else if ($_SESSION["roleid"] == "702") {
                                                                        echo "Moderator";
                                                                    } else if ($_SESSION["roleid"] == "703") {
                                                                        echo "Manager";
                                                                    } else {
                                                                        echo "Health Facilitator";
                                                                    }
                                                                    ?></div>
                                </div>
                                <div class="widget-content-right header-user-info ml-4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-main">
            <div class="app-sidebar sidebar-shadow">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>
                <div class="scrollbar-sidebar">
                    <div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu">
                            <li class="app-sidebar__heading">FACILITATOR MENU</li>
                            <li>
                                <a href="index.php">
                                    <i class="metismenu-icon pe-7s-home"></i>Home
                                </a>
                            </li>
                            <li>
                                <a href="patients.php">
                                    <i class="metismenu-icon pe-7s-note2"></i>Patients
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="mm-active">
                                    <i class="metismenu-icon pe-7s-info"></i>Bulacan Facility Data
                                </a>
                            </li>
                            </li>
                            <li class="app-sidebar__heading">GENERAL MENU</li>
                            <li>
                                <a href="disclaimer.php">
                                    <i class="metismenu-icon pe-7s-close-circle"></i>Disclaimer
                                </a>
                            </li>
                            <?php
                            if ($_SESSION["roleid"] == 702 || $_SESSION["roleid"] == 701) {
                                echo '
                                <li class="app-sidebar__heading">MODERATOR MENU</li>
                                <li>
                                    <a href="facilities.php">
                                        <i class="metismenu-icon pe-7s-users"></i>List of Facilities
                                    </a>
                                </li>
                                ';
                            }
                            if ($_SESSION["roleid"] == 701) {
                                echo '
                                <li class="app-sidebar__heading">ADMINISTRATOR MENU</li>
                                <li>
                                    <a href="admin.php">
                                        <i class="metismenu-icon pe-7s-tools"></i>Admin Tools
                                    </a>
                                </li>
                                ';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="tabs-animation">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <span class="mr-auto"><b>Provincial Data</b></span>
                                <li class="breadcrumb-item active">Facilitator</li>
                                <li class="breadcrumb-item active" aria-current="page">Data</li>
                            </ol>
                        </nav>
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <div class="main-card mb-3 card">
                                    <div class="card-header">Patient Conditions (Suspected)
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Asymptomatic</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers" id="sus_asym">0</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Mild</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers" id="sus_mild">0</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Severe</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers" id="sus_severe">0</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Death</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers" id="sus_death">0</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="main-card mb-3 card">
                                    <div class="card-header">Patient Conditions (Probable)
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Asymptomatic</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers" id="prob_asym">0</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Mild</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers" id="prob_mild">0</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Severe</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers" id="prob_severe">0</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Death</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers" id="prob_death">0</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="main-card mb-3 card">
                                    <div class="card-header">Patient Conditions (Confined)
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Asymptomatic</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers" id="conf_asym">0%</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Mild</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers" id="conf_mild">0</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Severe</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers" id="conf_severe">0</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Death</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers" id="conf_death">0</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-header">Facility Occupancies (Provincial)
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Occupied ICU Beds</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers" id="icu_o">0</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Occupied Isolation Beds</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers" id="isolbed_o">0</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Occupied Ward Beds</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers" id="beds_ward_o">0</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Vacant ICU Beds</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers" id="icu_v">0</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Vacant Isolation Beds</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers" id="isolbed_v">0</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Vacant Ward Beds</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers" id="beds_ward_v">0</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="app-wrapper-footer">
        <div class="app-footer">
            <div class="app-footer__inner">
                <div class="app-footer-left">
                    <span><b>Disclaimer: </b>In compliance with the Data Privacy Act of 2012, any information in relation to COVID patients in this website is purely fictional meaning none of the patients listed in this website is true or real.</span>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    <div class="app-drawer-overlay d-none animated fadeIn"></div>
    <script type="text/javascript" src="./assets/scripts/main.d810cf0ae7f39f28f336.js"></script>
    <script type="text/javascript" src="./assets/scripts/data.province.d810cf0ae7f39f28f336.js"></script>
</body>

</html>