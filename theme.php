<?php
require_once 'db_connect.php';

function getFestivalClassFromDB(): string {
    $db = get_db();
    $month = date('n'); // Tháng hiện tại 1–12
    $class = 'default-theme';

    // Lấy 1 lễ hội trong tháng hiện tại
    $sql = "SELECT slug 
            FROM festival 
            WHERE month = ? 
            ORDER BY start_date ASC 
            LIMIT 1";

    if ($stmt = $db->prepare($sql)) {
        $stmt->bind_param("i", $month);
        $stmt->execute();
        $stmt->bind_result($slug);
        if ($stmt->fetch()) {
            $class = $slug; // VD: "christmas", "halloween", "mid-autumn"
        }
        $stmt->close();
    }

    $db->close();
    return $class;
}
