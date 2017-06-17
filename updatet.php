<?php
require_once "connect.php";

$months = ["January", "February", "March", "April",
           "May", "June", "July", "August",
           "September", "October", "November", "December"];

$id = $_POST["id"];
$ida = $_POST["ida"];
$title = $_POST["title"];
$track_number = $_POST["track"];
$duration = $_POST["duration"];

$sql = "SELECT view_to_sec(?) AS result";
$stmt = $conn->prepare($sql);
$stmt->execute([$duration]);
$duration = $stmt->fetch(PDO::FETCH_ASSOC)["result"];

$sql = "UPDATE track ";
$sql .= "SET track_number=?, title=?, duration=? ";
$sql .= "WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$track_number, $title, $duration, $id]);

require_once "disconnect.php";

header("Location: album.php?id=$ida");
exit;
?>