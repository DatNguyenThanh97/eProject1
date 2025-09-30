<?php
require_once __DIR__ . '/../db_connect.php';
$db = get_db(); 

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
if (!$slug) {
    echo "<p>Festival not found.</p>";
    exit;
}
$stmt = $db->prepare("SELECT * FROM festival WHERE slug = ?");
$stmt->bind_param("s", $slug);
$stmt->execute();
$res = $stmt->get_result();
$festival = $res->fetch_assoc();
if (!$festival) {
    echo "<p>Festival not found.</p>";
    exit;
}
// Lấy gallery ảnh liên quan
$images = [];
$imgStmt = $db->prepare("SELECT image_url, caption FROM gallery WHERE festival_id = ?");
$imgStmt->bind_param("i", $festival['festival_id']);
$imgStmt->execute();
$imgRes = $imgStmt->get_result();
while ($row = $imgRes->fetch_assoc()) {
    $images[] = $row;
}
// Format ngày tháng
$start = $festival['start_date'] ? date("F j, Y", strtotime($festival['start_date'])) : 'N/A';
$end   = $festival['end_date'] ? date("F j, Y", strtotime($festival['end_date'])) : 'N/A';
?>
<h2><?= htmlspecialchars($festival['name']) ?></h2>

<?php if ($festival['thumbnail_url']): ?>
  <img src="<?= htmlspecialchars($festival['thumbnail_url']) ?>"
       alt="<?= htmlspecialchars($festival['name']) ?>"
       style="max-width:100%;border-radius:10px;margin:1rem 0;">
<?php endif; ?>

<h3>Description</h3>
<p><?= nl2br(htmlspecialchars($festival['description'] ?? 'No description available')) ?></p>

<h3>History</h3>
<p><?= nl2br(htmlspecialchars($festival['history'] ?? 'No history available')) ?></p>

<h3>Duration</h3>
<p><?= $start ?> → <?= $end ?></p>

<?php if ($images): ?>
  <h3>Gallery</h3>
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:1rem;">
    <?php foreach ($images as $img): ?>
      <div>
        <img src="<?= htmlspecialchars($img['image_url']) ?>"
             alt="<?= htmlspecialchars($img['caption'] ?: $festival['name']) ?>"
             style="width:100%;border-radius:8px;">
        <?php if ($img['caption']): ?>
          <p style="font-size:0.9rem;color:#666;"><?= htmlspecialchars($img['caption']) ?></p>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<div class="category-content"><a href="#detail" class="btn" onclick="closeFestivalModal()">More Details</a></div>