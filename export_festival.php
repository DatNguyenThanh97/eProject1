<?php
require_once __DIR__ . '/db_connect.php';
require_once __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

// Validate slug
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';
if ($slug === '') {
    http_response_code(400);
    echo 'Missing slug';
    exit;
}

$db = get_db();

// Fetch festival details
$sql = "
    SELECT f.festival_id, f.name, f.slug, f.description, f.history, f.thumbnail_url,
           DATE_FORMAT(f.start_date, '%Y-%m-%d') AS start_date,
           DATE_FORMAT(f.end_date, '%Y-%m-%d') AS end_date,
           r.name AS religion_name,
           GROUP_CONCAT(DISTINCT co.name ORDER BY co.name SEPARATOR ', ') AS countries
    FROM festival f
    LEFT JOIN religion r ON f.religion_id = r.religion_id
    LEFT JOIN festival_country fc ON f.festival_id = fc.festival_id
    LEFT JOIN country co ON fc.country_id = co.country_id
    WHERE f.slug = ?
    GROUP BY f.festival_id
    LIMIT 1
";

$stmt = $db->prepare($sql);
$stmt->bind_param('s', $slug);
$stmt->execute();
$res = $stmt->get_result();
$festival = $res->fetch_assoc();

if (!$festival) {
    http_response_code(404);
    echo 'Festival not found';
    exit;
}

// Get data
$title = $festival['name'];
$description = $festival['description'] ?? '';
$history = $festival['history'] ?? '';
$startDate = $festival['start_date'];
$endDate = $festival['end_date'];
$thumb = $festival['thumbnail_url'] ?? '';

// Format duration
function format_human_date(?string $d): string {
    if (!$d) return 'TBD';
    $ts = strtotime($d);
    if ($ts === false) return $d;
    return date('F j, Y', $ts);
}
$durationText = format_human_date($startDate) . ' → ' . format_human_date($endDate);

try {
    // Create PHPWord document
    $phpWord = new PhpWord();
    
    // Set document properties
    $phpWord->getDocInfo()->setCreator('MOONLIGHT EVENTS');
    $phpWord->getDocInfo()->setTitle($title);
    
    // Add section
    $section = $phpWord->addSection();
    
    // Title
    $section->addText(
        $title,
        array('name' => 'Times New Roman', 'size' => 18, 'bold' => true),
        array('alignment' => 'center', 'spaceAfter' => 300)
    );
    
    // Add local image from thumbnail folder
    if (!empty($thumb)) {
        $localImagePath = $thumb;
        
        if (file_exists($localImagePath)) {
            try {
                // Check if it's a valid image
                $imageInfo = @getimagesize($localImagePath);
                if ($imageInfo !== false && in_array($imageInfo[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF])) {
                    $section->addImage(
                        $localImagePath,
                        array(
                            'width' => 400,
                            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
                        )
                    );
                    $section->addTextBreak(1);
                } else {
                    $section->addText(
                        'Invalid image format: ' . basename($localImagePath),
                        array('name' => 'Times New Roman', 'size' => 10, 'italic' => true, 'color' => 'CC0000'),
                        array('alignment' => 'center', 'spaceAfter' => 200)
                    );
                }
            } catch (Exception $e) {
                $section->addText(
                    'Error loading image: ' . $e->getMessage(),
                    array('name' => 'Times New Roman', 'size' => 10, 'italic' => true, 'color' => 'CC0000'),
                    array('alignment' => 'center', 'spaceAfter' => 200)
                );
            }
        } else {
            $section->addText(
                'Image file not found: ' . basename($localImagePath),
                array('name' => 'Times New Roman', 'size' => 10, 'italic' => true, 'color' => 'CC0000'),
                array('alignment' => 'center', 'spaceAfter' => 200)
            );
        }
    }
    
    // Description
    if (!empty($description)) {
        $section->addText(
            'Description',
            array('name' => 'Times New Roman', 'size' => 14, 'bold' => true),
            array('spaceAfter' => 100)
        );
        $section->addText(
            $description,
            array('name' => 'Times New Roman', 'size' => 12),
            array('spaceAfter' => 200, 'alignment' => 'both')
        );
    }
    
    // History
    if (!empty($history)) {
        $section->addText(
            'History',
            array('name' => 'Times New Roman', 'size' => 14, 'bold' => true),
            array('spaceAfter' => 100)
        );
        $section->addText(
            $history,
            array('name' => 'Times New Roman', 'size' => 12),
            array('spaceAfter' => 200, 'alignment' => 'both')
        );
    }
    
    // Duration
    $section->addText(
        'Duration',
        array('name' => 'Times New Roman', 'size' => 14, 'bold' => true),
        array('spaceAfter' => 100)
    );
    $section->addText(
        $durationText,
        array('name' => 'Times New Roman', 'size' => 12, 'bold' => true, 'color' => 'CC0000'),
        array('spaceAfter' => 200)
    );
    
    // Additional Information
    if (!empty($festival['religion_name']) || !empty($festival['countries'])) {
        $section->addText(
            'Additional Information',
            array('name' => 'Times New Roman', 'size' => 14, 'bold' => true),
            array('spaceAfter' => 100)
        );
        
        if (!empty($festival['religion_name'])) {
            $section->addText(
                'Religion: ' . $festival['religion_name'],
                array('name' => 'Times New Roman', 'size' => 12)
            );
        }
        
        if (!empty($festival['countries'])) {
            $section->addText(
                'Countries: ' . $festival['countries'],
                array('name' => 'Times New Roman', 'size' => 12),
                array('spaceAfter' => 200)
            );
        }
    }
    
    // Footer
    $section->addTextBreak(2);
    $section->addText(
        '──────────────────────────',
        array('name' => 'Times New Roman', 'size' => 10, 'color' => 'CCCCCC'),
        array('alignment' => 'center')
    );
    $section->addText(
        'Generated by MOONLIGHT EVENTS',
        array('name' => 'Times New Roman', 'size' => 10, 'color' => '666666', 'italic' => true),
        array('alignment' => 'center')
    );
    $section->addText(
        date('F j, Y - H:i'),
        array('name' => 'Times New Roman', 'size' => 9, 'color' => '999999'),
        array('alignment' => 'center')
    );
    
    // Generate filename
    $filename = preg_replace('/[^a-z0-9\-]+/i', '-', $festival['slug']) . '.docx';
    
    // Set headers for download
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    header('Pragma: public');
    
    // Save to output
    $writer = IOFactory::createWriter($phpWord, 'Word2007');
    $writer->save('php://output');
    
} catch (Exception $e) {
    http_response_code(500);
    echo 'Error creating document: ' . $e->getMessage();
}

exit;