<?php
include_once 'validation.php';
if (isset($_POST["submit"])) {
    require_once 'db.php';

    mysqli_query($conn, "DELETE FROM fcdb_patients_admitted");
    mysqli_query($conn, "DELETE FROM fcdb_patients_released");

    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT * FROM fcuser_info WHERE username = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        echo "failed to connect";
    } else {
        if (isLoginEmpty($username, $password)) {
            session_start();
            $_SESSION["flash_message"] = "emptyfields";
            header("Location: login.php");
        } else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            if (!$row) {
                session_start();
                $_SESSION["flash_message"] = "invalidpassword";
                header("Location: login.php");
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);

                if (isPasswordValid($password, $row['password']) === true) {
                    session_start();
                    $_SESSION["userid"] = $row['userid'];
                    $_SESSION["roleid"] = $row['role'];
                    $_SESSION["username"] = strtolower($username);
                    header("Location: index.php");
                    mysqli_stmt_close($stmt);
                    $query_update = "UPDATE fcuser_info SET lastlogin = ?, lastactivity = ?, clientip = ? WHERE userid = ?;";
                    $stmt_update = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt_update, $query_update)) {
                        echo "failed to connect";
                    }
                    date_default_timezone_set("Asia/Singapore");
                    mysqli_stmt_bind_param($stmt_update, "ssss", date("Y-m-d H:i:s"), date("Y-m-d H:i:s"), $_SERVER["REMOTE_ADDR"], $_SESSION["userid"]);
                    mysqli_stmt_execute($stmt_update);
                    mysqli_stmt_close($stmt_update);
                } else {
                    session_start();
                    $_SESSION["flash_message"] = "invalidpassword";
                    header("Location: login.php");
                }
            }
        }
    }
} else {
    header("Location: login.php");
}
