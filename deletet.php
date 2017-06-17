<?php
$id = $_GET["id"];
$ida = $_GET["ida"];
require_once "connect.php";

$sql = "DELETE FROM track WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

require_once "disconnect.php";

header("Location: album.php?id=$ida");
exit;
?>