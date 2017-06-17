<?php
$id = $_GET["id"];
require_once "connect.php";

$sql = "DELETE FROM album WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

require_once "disconnect.php";

header("Location: index.php");
exit;
?>
