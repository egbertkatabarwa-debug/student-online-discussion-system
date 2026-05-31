<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "discussion_system";

$conn = new mysqli($host, $user, $pass, $db);

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT file_name, file_type, file_data FROM session_documents WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        header("Content-Type: " . $row['file_type']);
        header("Content-Disposition: inline; filename=\"" . $row['file_name'] . "\"");
        echo $row['file_data'];
    } else {
        echo "Document not found.";
    }
}
$conn->close();
?>