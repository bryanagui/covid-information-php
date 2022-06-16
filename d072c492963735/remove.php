<?php
session_start();
require_once "../db.php";
if (isset($_POST["id"])) {

    $userid = $_POST["id"];

    $query_isExist = "SELECT * FROM fcuser_info WHERE userid = ?;";
    $stmt_isExist = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt_isExist, $query_isExist)) {
        echo "failed to connect";
    } else {
        mysqli_stmt_bind_param($stmt_isExist, "s", $userid);
        mysqli_stmt_execute($stmt_isExist);

        $result_isExist = mysqli_stmt_get_result($stmt_isExist);
        if (!$row = mysqli_fetch_assoc($result_isExist)) {
            echo json_encode(['status' => 'fail']);
        } else {
            $query = "DELETE FROM fcuser_info WHERE userid = ?;";
            $query2 = "DELETE FROM fcusers_facilitator WHERE userid = ?;";
            $stmt = mysqli_stmt_init($conn);
            $stmt2 = mysqli_stmt_init($conn);
            if ($userid == "1000") {
                echo json_encode([
                    "status" => "forbidden"
                ]);
            } else {
                if (!mysqli_stmt_prepare($stmt, $query)) {
                    echo "failed to connect";
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $userid);
                    mysqli_stmt_execute($stmt);
                }

                if (!mysqli_stmt_prepare($stmt2, $query2)) {
                    echo "failed to connect";
                } else {
                    mysqli_stmt_bind_param($stmt2, "s", $userid);
                    mysqli_stmt_execute($stmt2);
                }
                mysqli_stmt_close($stmt);
                mysqli_stmt_close($stmt2);

                unset($_POST["id"]);

                echo json_encode([
                    'status' => 'success'
                ]);
            }
        }
    }
} else {
    header("Location: ../index.php");
}
