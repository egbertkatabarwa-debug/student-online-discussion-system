<?php
// Prevent PHP from outputting HTML errors
ini_set('display_errors', 0);
error_reporting(E_ALL);
header("Content-Type: application/json");

// Prevent MySQLi from throwing exceptions (which cause 500 errors)
mysqli_report(MYSQLI_REPORT_OFF);

$host = "127.0.0.1"; // Using the IP address often resolves DNS latency issues in XAMPP
$user = "root";
$pass = "";
$db = "discussion_system";

@$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Database Connection failed: " . $conn->connect_error]));
}

$action = $_GET['action'] ?? '';
$data = json_decode(file_get_contents("php://input"), true);

// Handle JSON parsing errors
if (json_last_error() !== JSON_ERROR_NONE && in_array($action, ['signup', 'login', 'save_members', 'save_questions'])) {
    die(json_encode(["success" => false, "message" => "Invalid JSON input"]));
}

switch ($action) {
    case 'signup':
        if (!$data) { die(json_encode(["success" => false, "message" => "No data provided"])); }
        $stmt = $conn->prepare("INSERT INTO `users` (`fullname`, `email`, `username`, `password`) VALUES (?, ?, ?, ?)");
        if (!$stmt) { die(json_encode(["success" => false, "message" => "SQL Error: " . $conn->error])); }

        $stmt->bind_param("ssss", $data['fullname'], $data['email'], $data['username'], $data['password']);
        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Registration failed: " . $stmt->error]);
        }
        break;

    case 'login':
        if (!$data) { die(json_encode(["success" => false, "message" => "No credentials provided"])); }
        $stmt = $conn->prepare("SELECT `password` FROM `users` WHERE `username` = ?");
        if (!$stmt) { die(json_encode(["success" => false, "message" => "SQL Error: " . $conn->error])); }

        $stmt->bind_param("s", $data['username']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($userRow = $result->fetch_assoc()) {
            if ($data['password'] === $userRow['password']) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "message" => "Invalid password"]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "User not found"]);
        }
        break;

    case 'save_members':
        if (!isset($data['members']) || !is_array($data['members'])) {
            echo json_encode(["success" => false, "message" => "No member data received"]);
            exit;
        }

        $conn->query("DELETE FROM `members`"); 
        $stmt = $conn->prepare("INSERT INTO `members` (`name`, `role`, `phone`, `level`) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
            exit;
        }
        
        foreach ($data['members'] as $m) {
            $stmt->bind_param("sssi", $m['name'], $m['role'], $m['phone'], $m['level']);
            if (!$stmt->execute()) {
                echo json_encode(["success" => false, "message" => "Failed to insert " . $m['name']]);
                exit;
            }
        }
        echo json_encode(["success" => true]);
        break;

    case 'get_members':
        $result = $conn->query("SELECT * FROM `members` ORDER BY `level` ASC");
        $members = [];
        while ($row = $result->fetch_assoc()) {
            $members[] = $row;
        }
        echo json_encode(["success" => true, "members" => $members]);
        break;

    case 'save_questions':
        if (!isset($data['questions']) || !is_array($data['questions'])) {
            echo json_encode(["success" => false, "message" => "No questions received"]);
            exit;
        }
        $conn->query("DELETE FROM uploaded_questions");
        $stmt = $conn->prepare("INSERT INTO uploaded_questions (question_text) VALUES (?)");
        if (!$stmt) { die(json_encode(["success" => false, "message" => "SQL Error: " . $conn->error])); }

        foreach ($data['questions'] as $q) {
            $stmt->bind_param("s", $q);
            $stmt->execute();
        }
        echo json_encode(["success" => true]);
        break;

    case 'get_questions':
        $result = $conn->query("SELECT question_text FROM uploaded_questions");
        $questions = [];
        while ($row = $result->fetch_assoc()) {
            $questions[] = $row['question_text'];
        }
        echo json_encode(["success" => true, "questions" => $questions]);
        break;

    case 'upload_document':
        if (!isset($_FILES['document'])) {
            echo json_encode(["success" => false, "message" => "No file uploaded"]);
            exit;
        }
        $file = $_FILES['document'];
        $name = $file['name'];
        $type = $file['type'];
        $content = file_get_contents($file['tmp_name']);

        // Use REPLACE INTO to avoid primary key conflicts with ID 1
        $stmt = $conn->prepare("REPLACE INTO session_documents (id, file_name, file_type, file_data) VALUES (1, ?, ?, ?)");
        if (!$stmt) { die(json_encode(["success" => false, "message" => "SQL Error: " . $conn->error])); }

        $stmt->bind_param("sss", $name, $type, $content);
        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "MySQL Error: " . $conn->error]);
        }
        break;

    default:
        echo json_encode(["success" => false, "message" => "Invalid action"]);
}
$conn->close();
?>