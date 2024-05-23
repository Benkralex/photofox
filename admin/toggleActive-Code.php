<?php
require('../database.php');

if (isset($_POST['code'])) {
    $code = $_POST['code'];

    // Überprüfen, ob bereits 10 Codes auf "active" gesetzt sind
    $sql_count_active = "SELECT COUNT(*) AS active_count FROM logincodes WHERE active = TRUE";
    $result = $conn->query($sql_count_active);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $active_count = $row['active_count'];

        if ($active_count < 10) {
            // SQL-Abfrage zum Umkehren des Wertes von active
            $sql_update_active = "UPDATE logincodes SET active = NOT active WHERE code = ?";
            $stmt = $conn->prepare($sql_update_active);
            $stmt->bind_param('s', $code);
            $stmt->execute();
            $stmt->close();
        } else {
            $sql = "SELECT active FROM logincodes WHERE code = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $code);
            $stmt->execute();
            $active = null;
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $active = $row['active'];
            }
            $stmt->close();
            echo $active;
            if ($active == "TRUE" || $active == 1) {
                $sql_update_active = "UPDATE logincodes SET active = NOT active WHERE code = ?";
                $stmt = $conn->prepare($sql_update_active);
                $stmt->bind_param('s', $code);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

} else {
    header("Location: ./");
    exit();
}
?>
