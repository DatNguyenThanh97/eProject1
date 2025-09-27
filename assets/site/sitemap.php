<?php
// sitemap.php

$today = date("Y-m-d");

$urls = [
    [ "loc" => "http://localhost/project/#home", "freq" => "daily", "priority" => "1.0", "color" => "#4facfe" ],   // xanh dương
    [ "loc" => "http://localhost/project/#festivals", "freq" => "weekly", "priority" => "0.9", "color" => "#ff7675" ], // đỏ
    [ "loc" => "http://localhost/project/#gallery", "freq" => "monthly", "priority" => "0.8", "color" => "#a29bfe" ], // tím
    [ "loc" => "http://localhost/project/#about", "freq" => "monthly", "priority" => "0.7", "color" => "#ffeaa7" ],   // vàng
    [ "loc" => "http://localhost/project/#contact", "freq" => "monthly", "priority" => "0.6", "color" => "#55efc4" ], // xanh ngọc
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sitemap Vertical Tree</title>
<style>
  body { font-family: Arial, sans-serif; background: #f0f2f5; color: #333; }
  h2 { text-align: center; color: #444; }
  
  .tree ul { list-style-type: none; padding-left: 40px; position: relative; }
  .tree ul::before { content: ""; border-left: 2px solid #bbb; position: absolute; top: 0; bottom: 0; left: 15px; }
  .tree li { margin: 0; padding: 10px 5px 0 25px; position: relative; }
  .tree li::before { content: ""; position: absolute; top: 20px; left: 0; width: 20px; border-top: 2px solid #bbb; }
  
  .node { 
    display: inline-block; 
    padding: 10px 15px; 
    border-radius: 8px; 
    color: #333; 
    font-weight: bold;
    box-shadow: 0 3px 6px rgba(0,0,0,0.15);
    min-width: 220px;
  }
  .node small { 
    display: block; 
    font-size: 12px; 
    color: #555; 
    font-weight: normal; 
    margin-top: 4px;
  }
</style>
</head>
<body>
<h2>Sitemap Tree (Vertical)</h2>
<div class="tree">
  <ul>
    <?php foreach ($urls as $u): ?>
      <li>
        <div class="node" style="background: <?= $u['color'] ?>;">
          <?= htmlspecialchars($u['loc']) ?>
          <small>lastmod: <?= $today ?> | freq: <?= $u['freq'] ?> | priority: <?= $u['priority'] ?></small>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
</div>
</body>
</html>
