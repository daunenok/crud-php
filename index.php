<?php
$months = ["January", "February", "March", "April",
           "May", "June", "July", "August",
           "September", "October", "November", "December"];

require_once "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

	$sql = "INSERT INTO album(title, artist, label, released) ";
	$sql .= "VALUES(?, ?, ?, ?)";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$title, $artist, $label, $released]);
}

$sql = "SELECT id, title, artist, label, released FROM album";
$data = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
$len = count($data);

require_once "disconnect.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="paper.min.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<div class="container">
	<div class="jumbotron">
		<h1>CRUD Application</h1>
	</div>

	<div class="alert alert-info">
  		There are only <?=$len?> albums in the database. Add some more!
	</div>

	<form class="form-horizontal" method="post">
	<fieldset>
		<legend>Add Album</legend>

		<div class="form-group">
			<label for="title" class="col-xs-2 control-label">
				Title
			</label>
			<div class="col-xs-10">
				<input type="text" class="form-control" id="title" name="title">
			</div>
		</div>

		<div class="form-group">
			<label for="artist" class="col-xs-2 control-label">
				Artist
			</label>
			<div class="col-xs-10">
				<input type="text" class="form-control" id="artist" name="artist">
			</div>
		</div>

		<div class="form-group">
			<label for="label" class="col-xs-2 control-label">
				Label
			</label>
			<div class="col-xs-10">
				<input type="text" class="form-control" id="label" name="label">
			</div>
		</div>

		<div class="form-group">
			<label for="label" class="col-xs-2 control-label">
				Released:
			</label>
			<div class="col-xs-10">
				Day &nbsp;&nbsp;
				<input type="number" id="day" min="1" max="31" value="1" name="day">
				&nbsp;&nbsp;&nbsp;&nbsp; Month &nbsp;&nbsp;
				<select  id="month" name="month">
					<option>January</option>
					<option>February</option>
					<option>March</option>
					<option>April</option>
					<option>May</option>
					<option>June</option>
					<option>July</option>
					<option>August</option>
					<option>September</option>
					<option>October</option>
					<option>November</option>
					<option>December</option>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp; Year &nbsp;&nbsp;
				<input type="number" id="year" min="1930" max="2018" value="2017" name="year">	
			</div>
		</div>

		<div class="form-group">
			<div class="col-xs-10 col-xs-offset-2">
				<button type="submit" class="btn btn-primary">
					Add Album
				</button>
			</div>
		</div>
	</fieldset>
	</form>

	<h3>Albums</h3>
	<table class="table table-striped table-hover albums">
  	<thead>
	    <tr>
			<th>Title</th>
			<th>Artist</th>
			<th>Label</th>
			<th>Released</th>
			<th>Action</th>
	    </tr>
  	</thead>
  	<tbody>
  		<?php 
  		foreach ($data as $album) {
  			echo "<tr>";
  			echo "<td>" . $album["title"] . "</td>";
  			echo "<td>" . $album["artist"] . "</td>";
  			echo "<td>" . $album["label"] . "</td>";
  			echo "<td>" . $album["released"] . "</td>";
  			echo "<td>";
  			echo "<a class='btn btn-primary' href='album.php?id=" . $album["id"] . "'>Edit</a> &nbsp;&nbsp;&nbsp;";
    		echo "<a class='btn btn-danger' href='delete.php?id=" . $album["id"] . "'>Delete</a>";
    		echo "</td>";
    		echo "</tr>";
  		}
  		?>
    </tbody>
    </table>
</div>

</body>
</html>