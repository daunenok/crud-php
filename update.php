<?php
require_once "connect.php";

$months = ["January", "February", "March", "April",
           "May", "June", "July", "August",
           "September", "October", "November", "December"];

$id = $_POST["id"];
$title = $_POST["title"];
$artist = $_POST["artist"];
$label = $_POST["label"];
$day = $_POST["day"];
$month = $_POST["month"];
$year = $_POST["year"];
$released = $year;
$month = array_search($month, $months) + 1;
$released .= "-" . str_pad($month, 2, "0", STR_PAD_LEFT);
$released .= "-" . str_pad($day, 2, "0", STR_PAD_LEFT);

$sql = "UPDATE album ";
$sql .= "SET title=?, artist=?, label=?, released=? ";
$sql .= "WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$title, $artist, $label, $released, $id]);

require_once "disconnect.php";

header("Location: album.php?id=$id");
exit;
?>