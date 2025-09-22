<?php
// Nhận filter từ filter.php
$religion = $filters['religion'] ?? '';
$month    = $filters['month'] ?? '';
$country  = $filters['country'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$limit = 6;
$offset = ($page - 1) * $limit;

// COUNT query
$countSql = "
    SELECT COUNT(DISTINCT f.festival_id) AS total
    FROM festival f
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
    SELECT f.festival_id, f.name, f.slug, f.description, f.thumbnail_url,
           f.start_date, f.end_date,
           r.name AS religion_name,
           GROUP_CONCAT(DISTINCT co.name SEPARATOR ', ') AS countries
    FROM festival f
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
    GROUP BY f.festival_id
    ORDER BY CASE 
              WHEN f.start_date >= CURDATE() THEN f.start_date
              ELSE DATE_ADD(f.start_date, INTERVAL 1 YEAR)
            END ASC
    LIMIT ? OFFSET ?
";

$params[] = $limit;
$params[] = $offset;
$types   .= "ii";

$stmt = $db->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="categories-grid">
  <?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="category-card">
        <img src="./<?= htmlspecialchars($row['thumbnail_url'] ?: 'assets/images/thumbnail/default.jpg') ?>"
             alt="<?= htmlspecialchars($row['name']) ?>">
        <div class="category-content">
          <h3><?= htmlspecialchars($row['name']) ?></h3>
          <p><?= htmlspecialchars(substr($row['description'], 0, 120)) ?>...</p>
          <a href="javascript:void(0)" class="btn" onclick="openFestivalModal('<?= $row['slug'] ?>')">
            Learn More
          </a>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p style="text-align:center;">No festivals found.</p>
  <?php endif; ?>
</div>

<?php if (!empty($filters['religion']) || !empty($filters['month']) || !empty($filters['country'])): ?>
  <div id="filterResultInfo" style="text-align:center; padding:1rem; color:#666;">
    Hiển thị <?= $total ?> festival<?= $total > 1 ? 's' : '' ?> phù hợp với bộ lọc.  
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
    <a href="?<?= http_build_query($query) ?>#festivals" class="prev">« Prev</a>
  <?php endif; ?>

  <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <?php $query['page'] = $i; ?>
    <a href="?<?= http_build_query($query) ?>#festivals" class="<?= $i == $page ? 'active' : '' ?>">
      <?= $i ?>
    </a>
  <?php endfor; ?>

  <?php if ($page < $totalPages): ?>
    <a href="?page=<?= $page + 1 ?>#festivals" class="next">Next »</a>
  <?php endif; ?>
</div>

