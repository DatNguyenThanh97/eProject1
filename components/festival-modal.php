<?php
require_once './db_connect.php';

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$stmt = $db->prepare("SELECT * FROM festival WHERE slug = ?");
$stmt->bind_param("s", $slug);
$stmt->execute();
$res = $stmt->get_result();
$festival = $res->fetch_assoc();

if (!$festival) {
    echo "<p>Festival not found.</p>";
    exit;
}
?>
<h2><?= htmlspecialchars($festival['name']) ?></h2>
<div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-top:1rem;">
  <div>
    <img src="<?= htmlspecialchars($festival['thumbnail_url'] ?: 'assets/images/default-hero.jpg') ?>"
         alt="<?= htmlspecialchars($festival['name']) ?>"
         style="width:100%;border-radius:10px;">
  </div>
  <div>
    <h3>Description</h3>
    <p><?= nl2br(htmlspecialchars($festival['description'])) ?></p>

    <h3>History</h3>
    <p><?= nl2br(htmlspecialchars($festival['history'] ?? 'No history available')) ?></p>

    <h3>Duration</h3>
    <p><?= $festival['start_date'] ?> → <?= $festival['end_date'] ?></p>
  </div>
</div>
