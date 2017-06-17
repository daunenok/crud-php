<?php
require_once "connect.php";

$id = $_POST["id"];
$track = $_POST["track"];
$title = $_POST["title"];
$duration = $_POST["duration"];

$sql = "SELECT view_to_sec(?) AS result";
$stmt = $conn->prepare($sql);
$stmt->execute([$duration]);
$duration = $stmt->fetch(PDO::FETCH_ASSOC)["result"];

$sql = "INSERT INTO track(album_id, title, track_number, duration) ";
$sql .= "VALUES(?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->execute([$id, $title, $track, $duration]);

require_once "disconnect.php";

header("Location: album.php?id=$id");
exit;
?>