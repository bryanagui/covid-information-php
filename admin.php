<?php
include_once "flash.php";
session_start();
if (!(isset($_SESSION['username'])) && !(isset($_SESSION['userid'])) && !(isset($_SESSION['roleid']))) {
    header("Location: login.php");
    exit;
} else {
    if ($_SESSION["roleid"] != "701") {
        header("Location: 404.php");
        exit;
    }
}

require_once "db.php";
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

$query_getAllUsers = "SELECT
facilitator.userid AS UserID,
roles.name AS Role,
info.username AS Username,
facilitator.firstname AS 'First Name',
facilitator.lastname AS 'Last Name',
facilitator.facilityid AS FacilityID,
facility.name AS 'Facility'
FROM
fcusers_facilitator AS facilitator
INNER JOIN fcuser_info AS info
ON
facilitator.userid = info.userid
INNER JOIN fcdb_facilities AS facility
ON
facilitator.facilityid = facility.facilityid
INNER JOIN fcuser_roles AS roles
ON
info.role = roles.role;";
$result_getAllUsers = mysqli_query($conn, $query_getAllUsers);

$query_getActiveUsers = "SELECT UserID, Username, clientip AS IP, lastactivity AS 'Last Activity' FROM fcuser_info WHERE UNIX_TIMESTAMP(lastactivity) > (UNIX_TIMESTAMP(now()) - 300);";
$result_getActiveUsers = mysqli_query($conn, $query_getActiveUsers);

$query_getLastLogins = "SELECT UserID, Username, clientip AS IP, lastlogin, lastactivity AS 'Last Activity' FROM fcuser_info WHERE lastlogin IS NOT NULL ORDER BY lastlogin DESC";
$result_getLastLogins = mysqli_query($conn, $query_getLastLogins);

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
    <script type="text/javascript" src="./d072c492963735/e64e4e6696b69.js"></script>

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">

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
                                <a href="provincial.php">
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
                            if ($_SESSION["roleid"] == "701") {
                                echo '
                                <li class="app-sidebar__heading">ADMINISTRATOR MENU</li>
                                <li>
                                    <a href="javascript:void(0)" class="mm-active">
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
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-xl-12">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <b class="mr-auto">Admin Tools</b>
                                        <li class="breadcrumb-item active">Administrator</li>
                                        <li class="breadcrumb-item active" aria-current="page">Tools</li>
                                    </ol>
                                </nav>
                                <?php
                                if (isset($_SESSION["flash_message"])) {
                                    flash_message("<b>Error!</b> Username already exists. Please try another one.", "exist");
                                }
                                unset($_SESSION["flash_message"]);
                                ?>
                                <div class="main-card mb-3 card">
                                    <div class="card-header">
                                        <span class="mr-auto">User Accounts</span>
                                        <span class="ml-auto"><button class="mr-2 btn-icon btn btn-primary" data-toggle="modal" data-target=".bd-add-user-modal-lg"><i class="fa fa-user-plus"></i> Add Account</button></span>
                                    </div>
                                    <div class="card-body">
                                        <table style="width: 100%;" class="table table-hover table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>UserID</th>
                                                    <th>Role</th>
                                                    <th>Username</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>FacilityID</th>
                                                    <th>Facility</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-body">
                                                <?php
                                                while ($row_getAllUsers = mysqli_fetch_assoc($result_getAllUsers)) {
                                                    echo '
                                                        <tr>
                                                            <td>' . htmlspecialchars($row_getAllUsers["UserID"], ENT_QUOTES, 'UTF-8') . '</td>
                                                            <td>' . htmlspecialchars($row_getAllUsers["Role"], ENT_QUOTES, 'UTF-8') . '</td>
                                                            <td>' . htmlspecialchars($row_getAllUsers["Username"], ENT_QUOTES, 'UTF-8') . '</td>
                                                            <td>' . htmlspecialchars($row_getAllUsers["First Name"], ENT_QUOTES, 'UTF-8') . '</td>
                                                            <td>' . htmlspecialchars($row_getAllUsers["Last Name"], ENT_QUOTES, 'UTF-8') . '</td>
                                                            <td>' . htmlspecialchars($row_getAllUsers["FacilityID"], ENT_QUOTES, 'UTF-8') . '</td>
                                                            <td>' . ucwords($row_getAllUsers["Facility"]) . '</td>
                                                            <td class="fit"> 
                                                            <button class="btn btn-info" id="edit" data-id= "' . $row_getAllUsers["UserID"] . '"data-toggle="modal" data-target=".bd-edit-user-modal-lg"><i class="fa fa-edit"></i> Edit</button>
                                                            <button class="btn btn-danger" id="delete" data-id="' . $row_getAllUsers["UserID"] . '"><i class="fa fa-times"></i> Remove</button>
                                                            </td>
                                                        </tr>
                                                        ';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="main-card mb-3 card">
                                    <div class="card-header">
                                        <span class="mr-auto">Active Users</span>
                                    </div>
                                    <div class="card-body">
                                        <table style="width: 100%;" class="table table-hover table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>UserID</th>
                                                    <th>Username</th>
                                                    <!-- <th>First Name</th>
                                                    <th>Last Name</th> -->
                                                    <th>Client IP</th>
                                                    <th>Last Activity</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-body">
                                                <?php
                                                while ($row_getActiveUsers = mysqli_fetch_assoc($result_getActiveUsers)) {
                                                    echo '
                                                        <tr>
                                                            <td>' . htmlspecialchars($row_getActiveUsers["UserID"], ENT_QUOTES, 'UTF-8') . '</td>
                                                            <td>' . htmlspecialchars($row_getActiveUsers["Username"], ENT_QUOTES, 'UTF-8') . '</td>
                                                            <td>' . htmlspecialchars($row_getActiveUsers["IP"], ENT_QUOTES, 'UTF-8') . '</td>
                                                            <td>' . htmlspecialchars($row_getActiveUsers["Last Activity"], ENT_QUOTES, 'UTF-8') . '</td>
                                                        </tr>
                                                        ';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="main-card mb-3 card">
                                    <div class="card-header">
                                        <span class="mr-auto">Last Logins</span>
                                    </div>
                                    <div class="card-body">
                                        <table style="width: 100%;" class="table table-hover table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>UserID</th>
                                                    <th>Username</th>
                                                    <th>Client IP</th>
                                                    <th>Last Login</th>
                                                    <th>Last Activity</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-body">
                                                <?php
                                                while ($row_getLastLogins = mysqli_fetch_assoc($result_getLastLogins)) {
                                                    echo '
                                                        <tr>
                                                            <td>' . htmlspecialchars($row_getLastLogins["UserID"], ENT_QUOTES, 'UTF-8') . '</td>
                                                            <td>' . htmlspecialchars($row_getLastLogins["Username"], ENT_QUOTES, 'UTF-8') . '</td>
                                                            <td>' . htmlspecialchars($row_getLastLogins["IP"], ENT_QUOTES, 'UTF-8') . '</td>
                                                            <td>' . date("F d, Y H:i:s", strtotime($row_getLastLogins["lastlogin"])) . '</td>
                                                            <td>' . htmlspecialchars($row_getLastLogins["Last Activity"], ENT_QUOTES, 'UTF-8') . '</td>
                                                        </tr>
                                                        ';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
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

    <!-- modal -->

    <div class="modal fade bd-add-user-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Add Account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <h5 class="card-title">Add new facilitator</h5>
                        <form id="signupForm" class="col-md-10 mx-auto" method="post" action="auth-signup.php">
                            <div class="form-group">
                                <label for="firstname">First name</label>
                                <div>
                                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First name" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last name</label>
                                <div>
                                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last name" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <div>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <div>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm password</label>
                                <div>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="firstname">Facility ID</label>
                                <div>
                                    <input type="text" class="form-control" id="facility_id" name="facility_id" placeholder="Facility ID" />
                                </div>
                                <a href="facilities.php" target="_blank" rel="noopener noreferrer">Need reference?</a>
                            </div>
                            <div class="form-group">
                                <button type="submit" data-type="success" class="btn btn-primary" id="createaccount" name="signup" value="signup">Create Account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal -->

    <div class="modal fade bd-edit-user-modal-lg" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Edit Account</h5>
                        <button type="button" class="close" id="edit-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="card-body" id="edit-body">
                        <h5 class="card-title">Edit facilitator information</h5>
                        <form id="editForm" class="col-md-10 mx-auto" method="POST">
                            <div class="form-group">
                                <label for="firstname">First name</label>
                                <div>
                                    <input type="text" class="form-control" id="edit_firstname" name="edit_firstname" placeholder="First name" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last name</label>
                                <div>
                                    <input type="text" class="form-control" id="edit_lastname" name="edit_lastname" placeholder="Last name" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <div>
                                    <input type="text" class="form-control" id="edit_email" name="edit_email" placeholder="Email" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <div>
                                    <input type="text" class="form-control" id="edit_username" name="edit_username" placeholder="Username" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username">Role</label>
                                <div>
                                    <input type="text" class="form-control" id="edit_roleid" name="edit_roleid" placeholder="Role ID" />
                                    <span class="text-muted">701 - Administrator | 702 - Moderator | 703 - Manager | 704 - Health Facilitator</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <input type="hidden" class="form-control" id="c0a84" name="c0a84" disabled />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="firstname">Facility ID</label>
                                <div>
                                    <input type="text" class="form-control" id="edit_facility_id" name="edit_facility_id" placeholder="Facility ID" />
                                </div>
                                <a href="facilities.php" target="_blank" rel="noopener noreferrer">Need reference?</a>
                            </div>
                            <div class="form-group">
                                <button type="submit" data-type="success" class="btn btn-primary" id="submit-edit" name="submit-edit" value="submit-edit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="./assets/scripts/main.d810cf0ae7f39f28f336.js"></script>

    <script>

    </script>
</body>

</html>