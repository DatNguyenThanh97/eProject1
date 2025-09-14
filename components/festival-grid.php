<?php
require_once './db_connect.php';

$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 6;
$offset = ($page - 1) * $limit;

$totalRes = $db->query("SELECT COUNT(*) AS total FROM festival");
$totalRow = $totalRes->fetch_assoc();
$total = $totalRow['total'];
$totalPages = ceil($total / $limit);

$sql = "
    SELECT festival_id, slug, name, description, thumbnail_url
    FROM festival
    ORDER BY start_date DESC
    LIMIT $limit OFFSET $offset
";
$result = $db->query($sql);
?>

<div class="categories-grid">
  <?php while ($row = $result->fetch_assoc()): ?>
    <div class="category-card">
      <img src="<?= htmlspecialchars($row['thumbnail_url'] ?: 'assets/images/default.jpg') ?>"
           alt="<?= htmlspecialchars($row['name']) ?>">
      <div class="category-content">
        <h3><?= htmlspecialchars($row['name']) ?></h3>
        <p><?= htmlspecialchars(substr($row['description'], 0, 120)) ?>...</p>
        <a href="javascript:void(0)" class="btn" onclick="openFestivalModal(<?= $row['slug'] ?>)">
          Learn More
        </a>

      </div>
    </div>
  <?php endwhile; ?>
</div>

<!-- Pagination -->
<div class="pagination">
  <?php for ($i=1; $i <= $totalPages; $i++): ?>
    <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>">
      <?= $i ?>
    </a>
  <?php endfor; ?>
</div>
