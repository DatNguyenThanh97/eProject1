<?php
require_once __DIR__ . '/../db_connect.php';
$db = get_db(); 

$religionFilter = isset($_GET['religion']) ? $_GET['religion'] : '';
$monthFilter = isset($_GET['month']) ? $_GET['month'] : '';
$collectionFilter = isset($_GET['collection']) ? $_GET['collection'] : '';

// Build WHERE conditions
$whereConditions = [];
$params = [];
$types = '';

if ($religionFilter) {
 // Map HTML option values to database names
    $religionMap = [
        'hindu' => 'Hinduism',
        'christian' => 'Christianity', 
        'islamic' => 'Islam',
        'buddhist' => 'Buddhism',
        'secular' => 'Secular'
    ];
    
    $dbReligionName = $religionMap[$religionFilter] ?? ucfirst($religionFilter);
    $whereConditions[] = "r.name = ?";
    $params[] = $dbReligionName;
    $types .= 's';
}

if ($monthFilter) {
    $monthNumber = date('m', strtotime($monthFilter . ' 1'));
    $whereConditions[] = "MONTH(f.start_date) = ?";
    $params[] = $monthNumber;
    $types .= 'i';
}

// For collection filter, you might need to add a category field to festival table
// For now, we'll skip this or use a placeholder

$whereClause = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';

// Main query with filters (no pagination for filter)
$sql = "
    SELECT f.festival_id, f.slug, f.name, f.description, f.thumbnail_url, f.start_date, r.name as religion_name
    FROM festival f 
    LEFT JOIN religion r ON f.religion_id = r.religion_id 
    $whereClause
    ORDER BY 
        CASE 
            WHEN f.start_date >= CURDATE() THEN f.start_date
            ELSE DATE_ADD(f.start_date, INTERVAL 1 YEAR)
        END ASC
";

if (!empty($params)) {
    $stmt = $db->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $db->query($sql);
}
?>

<div class="categories-grid">
  <?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="category-card">
        <img src="<?= htmlspecialchars($row['thumbnail_url'] ?: 'assets/images/default.jpg') ?>"
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
    <div style="grid-column: 1/-1; text-align: center; padding: 2rem;">
      <p>Không tìm thấy festival nào phù hợp với bộ lọc.</p>
    </div>
  <?php endif; ?>
</div>

<!-- No pagination for filtered results -->
<?php if (!empty($whereConditions)): ?>
  <div style="text-align: center; padding: 1rem; color: #666;">
    <p>Hiển thị kết quả lọc (<?= $result->num_rows ?> festivals). <a href="#festivals" onclick="clearFilters()">Xem tất cả</a></p>
  </div>
<?php endif; ?>