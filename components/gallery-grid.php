<?php
// Nhận filter từ filter.php
$religion = $filters['religion'] ?? '';
$month    = $filters['month'] ?? '';
$country  = $filters['country'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$limit = 12;
$offset = ($page - 1) * $limit;

// COUNT query
$countSql = "
    SELECT COUNT(DISTINCT g.gallery_id) AS total
    FROM gallery g
    JOIN festival f ON g.festival_id = f.festival_id
    LEFT JOIN religion r ON f.religion_id = r.religion_id
    LEFT JOIN festival_country fc ON f.festival_id = fc.festival_id
    LEFT JOIN country co ON fc.country_id = co.country_id
    WHERE 1=1
";

$params = [];
$types = "";

if ($religion) {
    $countSql .= " AND r.name = ?";
    $params[] = $religion;
    $types   .= "s";
}
if ($month) {
    $countSql .= " AND f.month = ?";
    $params[] = (int)$month;
    $types   .= "i";
}
if ($country) {
    $countSql .= " AND co.name = ?";
    $params[] = $country;
    $types   .= "s";
}

$stmt = $db->prepare($countSql);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$total = ($stmt->get_result()->fetch_assoc())['total'] ?? 0;
$totalPages = ceil($total / $limit);

// Query chính
$sql = "
    SELECT g.gallery_id, g.image_url, g.caption,
           f.name AS festival_name, f.slug,
           GROUP_CONCAT(DISTINCT co.name SEPARATOR ', ') AS countries
    FROM gallery g
    JOIN festival f ON g.festival_id = f.festival_id
    LEFT JOIN religion r ON f.religion_id = r.religion_id
    LEFT JOIN festival_country fc ON f.festival_id = fc.festival_id
    LEFT JOIN country co ON fc.country_id = co.country_id
    WHERE 1=1
";

$params = [];
$types = "";

if ($religion) {
    $sql .= " AND r.name = ?";
    $params[] = $religion;
    $types   .= "s";
}
if ($month) {
    $sql .= " AND f.month = ?";
    $params[] = (int)$month;
    $types   .= "i";
}
if ($country) {
    $sql .= " AND co.name = ?";
    $params[] = $country;
    $types   .= "s";
}

$sql .= "
    GROUP BY g.gallery_id
    ORDER BY g.gallery_id DESC
    LIMIT ? OFFSET ?
";

$params[] = (int)$limit;
$params[] = (int)$offset;
$types   .= "ii";

$stmt = $db->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="gallery-grid">
  <?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="gallery-item" onclick="openGalleryModal('<?= htmlspecialchars($row['image_url']) ?>', '<?= htmlspecialchars($row['caption'] ?: $row['festival_name']) ?>')">
        <img src="<?= htmlspecialchars($row['image_url']) ?>"
             alt="<?= htmlspecialchars($row['caption'] ?: $row['festival_name']) ?>">
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p style="text-align:center;">No images found.</p>
  <?php endif; ?>
</div>

<?php if (!empty($filters['religion']) || !empty($filters['month']) || !empty($filters['country'])): ?>
  <div id="filterResultInfoGallery" style="text-align:center; padding:1rem; color:#666;">
    Hiển thị <?= $total ?> ảnh lễ hội phù hợp với bộ lọc.  
    <a href="javascript:void(0)" onclick="clearFilters()" style="color:#007bff; text-decoration:underline;">
      Xem tất cả
    </a>
  </div>
<?php endif; ?>

<!-- Pagination -->
<div class="pagination">
  <?php $query = array_filter([
    'religion' => $religion,
    'month' => $month,
    'country' => $country
  ]); ?>
  <?php if ($page > 1): ?>
    <?php $query['page'] = $page - 1; ?>
    <a href="?<?= http_build_query($query) ?>#gallery" class="prev">« Prev</a>
  <?php endif; ?>

  <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <?php $query['page'] = $i; ?>
    <a href="?<?= http_build_query($query) ?>#gallery" class="<?= $i == $page ? 'active' : '' ?>">
      <?= $i ?>
    </a>
  <?php endfor; ?>

  <?php if ($page < $totalPages): ?>
    <?php $query['page'] = $page + 1; ?>
    <a href="?<?= http_build_query($query) ?>#gallery" class="next">Next »</a>
  <?php endif; ?>
</div>
