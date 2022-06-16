<?php
if (isset($_POST['number_of_patients'])) {
    require_once "../db.php";
    require_once '../vendor/autoload.php';
    $faker = Faker\Factory::create();

    $num_patients = $_POST["number_of_patients"];
    $bulacan_places = array("Angat", "Balagtas", "Baliuag", "Bocaue", "Bulakan", "Bustos", "Calumpit", "Doña Remedios Trinidad", "Guiguinto", "Hagonoy", "Malolos", "Marilao", "Meycauayan", "Norzagaray", "Obando", "Pandi", "Paombong", "Plaridel", "Pulilan", "San Ildefonso", "San Jose del Monte", "San Miguel", "San Rafael", "Santa Maria");


    $query_exist = "SELECT * FROM fcdb_patients_admitted";
    $result_exist = mysqli_query($conn, $query_exist);
    $row_exist = mysqli_num_rows($result_exist);
    if ($row_exist == 0) {
        $query = "INSERT INTO fcdb_patients_admitted(`fullname`, `age`, `address`, `admission_date`) VALUES (?,?,?,?);";
        $query2 = "INSERT INTO fcdb_patients_released(`fullname`, `age`, `address`, `date_released`) VALUES (?,?,?,?);";
        $stmt = mysqli_stmt_init($conn);
        $stmt2 = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $query)) {
            echo "failed to connect 1";
        } else {
            for ($i = 0; $i < $num_patients; $i++) {

                $patient_age = rand(15, 85);

                $patient_names = $faker->firstName($gender = null | 'male' | 'female') . " " . $faker->lastname();
                $patient_addresses = $bulacan_places[array_rand($bulacan_places)] . ", Bulacan";
                $admission_dates = $faker->dateTimeBetween('-14 days', 'now')->format("Y-m-d");

                mysqli_stmt_bind_param($stmt, "ssss", $patient_names, $patient_age, $patient_addresses, $admission_dates);
                mysqli_stmt_execute($stmt);
            }
        }
        if (!mysqli_stmt_prepare($stmt2, $query2)) {
            echo "failed to connect 2";
        } else {
            for ($i = 0; $i < 50; $i++) {

                $patient_age = rand(15, 85);

                $patient_names = $faker->firstName($gender = null | 'male' | 'female') . " " . $faker->lastname();
                $patient_addresses = $bulacan_places[array_rand($bulacan_places)] . ", Bulacan";
                $admission_dates = $faker->dateTimeBetween('-30 days', 'now')->format("Y-m-d");

                mysqli_stmt_bind_param($stmt2, "ssss", $patient_names, $patient_age, $patient_addresses, $admission_dates);
                mysqli_stmt_execute($stmt2);
            }
        }
    }
} else {
    header("Location: ../index.php");
}
