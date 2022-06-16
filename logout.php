<?php
session_start();
if (isset($_POST["logout"])) {
    require_once "db.php";
    mysqli_query($conn, "DELETE FROM fcdb_patients_admitted");
    mysqli_query($conn, "DELETE FROM fcdb_patients_released");

    unset($_SESSION["username"]);
    unset($_SESSION["roleid"]);
    unset($_SESSION["userid"]);

    header("Location: login.php");
}
