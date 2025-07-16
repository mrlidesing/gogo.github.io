<?php
$uploadDir = 'images2/';
$allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
$files = $_FILES['upload'];

function getCurrentImageCount($dir) {
  $images = glob($dir . 'em-*.jpg');
  return count($images);
}

$total = getCurrentImageCount($uploadDir);

foreach ($files['tmp_name'] as $index => $tmpName) {
  if (in_array($files['type'][$index], $allowedTypes)) {
    $total++;
    $newName = sprintf("em-%02d.jpg", $total);
    $targetPath = $uploadDir . $newName;
    if (move_uploaded_file($tmpName, $targetPath)) {
      echo "<p>✔ 上傳成功：$newName</p>";
    } else {
      echo "<p>✘ 上傳失敗：{$files['name'][$index]}</p>";
    }
  } else {
    echo "<p>✘ 檔案類型不允許：{$files['name'][$index]}</p>";
  }
}

file_put_contents($uploadDir . 'image-count.json', json_encode(["total" => $total]));
echo '<p><a href="upload.html">回上傳頁</a></p>';
?>
