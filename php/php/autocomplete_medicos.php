<?php
include "conn.php";

$term = isset($_GET['term']) ? $_GET['term'] : '';

$sql = "SELECT medico, nome FROM tbmedicos WHERE nome LIKE ? LIMIT 10";
$stmt = $conn->prepare($sql);
$searchTerm = "%$term%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = ["label" => $row['nome'], "value" => $row['nome'], "id" => $row['medico']];
}

echo json_encode($data);
?>
