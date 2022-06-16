<?php
if (isset($_POST["id"])) {
    require_once "../db.php";

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
            $query_select = "SELECT
            facilitator.userid AS UserID,
            roles.name AS Role,
            roles.role AS RoleID,
            info.username AS Username,
            facilitator.firstname AS 'First Name',
            facilitator.lastname AS 'Last Name',
            facilitator.facilityid AS FacilityID,
            facilitator.email AS Email,
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
            info.role = roles.role WHERE facilitator.userid = ?;";
            $stmt_select = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt_select, $query_select)) {
                echo "failed to connect";
            } else {
                mysqli_stmt_bind_param($stmt_select, "s", $userid);
                mysqli_stmt_execute($stmt_select);

                $result = mysqli_stmt_get_result($stmt_select);
                if ($row = mysqli_fetch_assoc($result)) {
                    echo json_encode([
                        'firstname' => $row["First Name"],
                        'lastname' => $row["Last Name"],
                        'email' => $row["Email"],
                        'username' => $row["Username"],
                        'roleid' => $row["RoleID"],
                        'facilityid' => $row["FacilityID"]
                    ]);
                } else {
                    echo json_encode(['status' => 'no data']);
                }
            }
        }
    }
} else {
    header("Location: ../index.php");
}
