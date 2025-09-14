<?php
  require_once 'db_connect.php';
  function get_visitor_count(mysqli $db): int{
    $db = get_db();
    $db->query("UPDATE visitor_count SET total_visits = total_visits + 1 WHERE id = 1"); 
    $visitor_total = 0; 
    if ($res = @$db->query("SELECT total_visits FROM visitor_count WHERE id = 1")) { 
        if ($row = $res->fetch_assoc()) { 
            $visitor_total = (int)$row['total_visits']; 
        } 
        $res->free(); 
    }
    return $visitor_total;
  }
  function get_hero_data(mysqli $db): array {
    $month = date("n");

    $stmt = $db->prepare("SELECT slug, name, description, thumbnail_url FROM festival WHERE month = ?");
    $stmt->bind_param("i", $month);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $festivals = $res->fetch_all(MYSQLI_ASSOC);
        $hero_festival = $festivals[array_rand($festivals)];
        $hero = [
            "slug"  => $hero_festival["slug"], // dùng slug làm class CSS
            "title" => $hero_festival["name"],
            "desc"  => $hero_festival["description"],
            "bg"    => $hero_festival["thumbnail_url"]
        ];
    } else {
        $hero = [
            "slug"  => "default-hero",
            "title" => "Global Festivals Around the World",
            "desc"  => "MOONLIGHT EVENTS organizes festivals worldwide, promoting cultural understanding and tolerance among youth through the celebration of diverse traditions and artistic expressions.",
            "bg"    => "./assets/images/default-hero.jpg"
        ];
    }

    $stmt->close();
    return $hero;
}
?>