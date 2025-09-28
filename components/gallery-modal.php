<?php
require_once __DIR__ . '/../db_connect.php';
$db = get_db(); 

$image_url = isset($_GET['image_url']) ? $_GET['image_url'] : '';
$caption = isset($_GET['caption']) ? $_GET['caption'] : '';

if (!$image_url) {
    echo "<p>Image not found.</p>";
    exit;
}
?>

<div class="gallery-modal-wrapper">
  <img src="<?= htmlspecialchars($image_url) ?>" 
       alt="<?= htmlspecialchars($caption) ?>"
       class="gallery-modal-image">
  
  <div class="gallery-modal-caption">
    <h3><?= htmlspecialchars($caption) ?></h3>
  </div>
</div>