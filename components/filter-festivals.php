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
        'secular' => null
    ];
    
    if (array_key_exists($religionFilter, $religionMap)) {
        if ($religionMap[$religionFilter] === null) {
            $whereConditions[] = "f.religion_id IS NULL";
        } else {
            $whereConditions[] = "r.name = ?";
            $params[] = $religionMap[$religionFilter];
            $types .= 's';
        }
    }
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

<?php if ($result->num_rows > 0): ?>
  <div class="categories-grid">
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
  </div>

<?php if (!empty($whereConditions)): ?>
    <div id="filterResultInfo" style="text-align:center; padding:1rem; color:#666;">
      Hiển thị kết quả lọc (<?= $result->num_rows ?> festivals).
      <a href="index.php#festivals" onclick="clearFilters(event)">Xem tất cả</a>
    </div>
 <?php endif; ?>

<?php else: ?>
  <!-- No result: render an independent block (not inside .categories-grid) -->
  <div class="no-results-message">
    <p>Không tìm thấy festival nào phù hợp với bộ lọc.</p>
    <p><a href="index.php#festivals" onclick="clearFilters(event)">Xem tất cả</a></p>
  </div>
<?php endif; ?>
