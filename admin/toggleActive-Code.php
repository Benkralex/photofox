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

        $sql = "SELECT code FROM logincodes WHERE active = TRUE";
        $result = $conn->query($sql);
        $notChanged = true;
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['code'] == $code && $notChanged) {
                    $sql_update_active = "UPDATE logincodes SET active = NOT active WHERE code = ?";
                    $stmt = $conn->prepare($sql_update_active);
                    $stmt->bind_param('s', $code);
                    $stmt->execute();
                    $stmt->close();
                    $notChanged = false;
                }
            }
        }
        if ($active_count < 10 && $notChanged) {
            $sql_update_active = "UPDATE logincodes SET active = NOT active WHERE code = ?";
            $stmt = $conn->prepare($sql_update_active);
            $stmt->bind_param('s', $code);
            $stmt->execute();
            $stmt->close();
        }
    }
} else {
    header("Location: ./");
    exit();
}
