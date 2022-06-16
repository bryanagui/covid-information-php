<?php
include_once "validation.php";
if (isset($_POST["signup"])) {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $facility_id = $_POST["facility_id"];

    require_once "db.php";

    $query = "INSERT INTO fcuser_info (`role`, `username`, `password`) VALUES (704, ?, ?);";
    $query2 = "INSERT INTO fcusers_facilitator (`username`, `firstname`, `lastname`, `facilityid`, `email`) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    $stmt2 = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        echo "failed to connect";
    } else {
        $query_usernameExist = "SELECT * FROM fcuser_info WHERE username = ?";
        $stmt_usernameExist = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt_usernameExist, $query_usernameExist)) {
            echo "failed to connect 2";
        } else {
            mysqli_stmt_bind_param($stmt_usernameExist, "s", $username);
            mysqli_stmt_execute($stmt_usernameExist);

            $result = mysqli_stmt_get_result($stmt_usernameExist);
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                session_start();
                $_SESSION["flash_message"] = "exist";
                header("Location: admin.php");
            } else {
                if (!mysqli_stmt_prepare($stmt2, $query2)) {
                    echo "failed to connect 2";
                } else {
                    $hash = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($stmt, "ss", $username, $hash);
                    mysqli_stmt_execute($stmt);

                    mysqli_stmt_bind_param($stmt2, "sssss", $username, $firstname, $lastname, $facility_id, strtolower($email));
                    mysqli_stmt_execute($stmt2);
                    header("Location: admin.php");
                }
            }
        }
    }
} else {
    header("Location: index.php");
}
