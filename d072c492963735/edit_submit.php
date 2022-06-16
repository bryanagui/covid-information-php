<?php
session_start();
require_once "../db.php";
if (isset($_POST["uid"])) {

    $userid = $_POST["uid"];
    $firstname = $_POST["edit_firstname"];
    $lastname = $_POST["edit_lastname"];
    $email = $_POST["edit_email"];
    $username = $_POST["edit_username"];
    $roleid = $_POST["edit_roleid"];
    $facilityid = $_POST["edit_facilityid"];

    $query_isExist = "SELECT * FROM fcuser_info WHERE userid = ?;";
    $stmt_isExist = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt_isExist, $query_isExist)) {
        echo "failed to connect 1";
    } else {
        mysqli_stmt_bind_param($stmt_isExist, "s", $userid);
        mysqli_stmt_execute($stmt_isExist);

        $result_isExist = mysqli_stmt_get_result($stmt_isExist);
        if (!$row = mysqli_fetch_assoc($result_isExist)) {
            echo json_encode(['status' => 'fail']);
        } else {
            if ($userid == "1000") {
                echo json_encode([
                    "status" => "forbidden"
                ]);
            } else {
                $query_update = "UPDATE fcuser_info SET role = ?, username = ? WHERE userid = ?";
                $query_update2 = "UPDATE fcusers_facilitator SET username = ?, firstname = ?, lastname = ?, facilityid = ?, email = ? WHERE userid = ?";
                $stmt_update = mysqli_stmt_init($conn);
                $stmt_update2 = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmt_update, $query_update)) {
                    echo "failed to connect 2";
                } else {
                    mysqli_stmt_bind_param($stmt_update, "sss", $roleid, $username, $userid);
                    mysqli_stmt_execute($stmt_update);
                }
                if (!mysqli_stmt_prepare($stmt_update2, $query_update2)) {
                    echo "failed to connect 3";
                } else {
                    mysqli_stmt_bind_param($stmt_update2, "ssssss", $username, $firstname, $lastname, $facilityid, $email, $userid);
                    mysqli_stmt_execute($stmt_update2);
                }

                unset($_POST["uid"]);
                unset($_POST["edit_firstname"]);
                unset($_POST["edit_lastname"]);
                unset($_POST["edit_email"]);
                unset($_POST["edit_username"]);
                unset($_POST["edit_facilityid"]);
                unset($_POST["edit_roleid"]);


                echo json_encode([
                    'status' => 'success'
                ]);
            }
        }
    }
} else {
    header("Location: ../index.php");
}
