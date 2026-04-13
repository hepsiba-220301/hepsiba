<?php
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir);
}
if (isset($_POST['upload'])) {
    $fileName = $_FILES['file']['name'];
    $tempName = $_FILES['file']['tmp_name'];
    $target = $uploadDir . basename($fileName);
    if (move_uploaded_file($tempName, $target)) {
        echo "<p style='color:green;'>File uploaded successfully!</p>";
        // WRITE FILE NAME TO LOG FILE
        $log = fopen("log.txt", "a");
        fwrite($log, "Uploaded: " . $fileName . "\n");
        fclose($log);
    } else {
        echo "<p style='color:red;'>Upload failed!</p>";
    }
}

if (isset($_GET['download'])) {
    $file = $uploadDir . $_GET['download'];
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        readfile($file);
        exit;
    } else {
        echo "File not found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>File Upload & Download</title>
</head>
<body>
<h2>📁 File Upload & Download System</h2>
<form method="POST" enctype="multipart/form-data">
    Select File:
    <input type="file" name="file" required>
    <button type="submit" name="upload">Upload</button>
</form>
<hr>
<h3>📂 Uploaded Files</h3>
<?php
$files = scandir($uploadDir);
foreach ($files as $file) {
    if ($file != "." && $file != "..") {
        echo $file . " ";
        // DOWNLOAD LINK
        echo "<a href='?download=$file'>Download</a><br>";
    }
}
?>
<hr>
<h3>📜 File Log (Using PHP File Functions)</h3>
<?php
// READ LOG FILE
if (file_exists("log.txt")) {
    $log = fopen("log.txt", "r");
    echo "<pre>" . fread($log, filesize("log.txt")) . "</pre>";
    fclose($log);
} else {
    echo "No logs yet.";
}
?>
</body>
</html>