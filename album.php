<?php
$id = $_GET["id"];
require_once "connect.php";

$sql = "SELECT title, artist, label, released FROM album WHERE id=?"; 
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$album = $stmt->fetch(PDO::FETCH_ASSOC);

$album["year"] = (int)substr($album["released"], 0, 4);
$album["month"] = (int)substr($album["released"], 5, 2);
$album["day"] = (int)substr($album["released"], 8, 2);

$sql = "SELECT id, track_number, title, dview FROM track_view WHERE album_id=?"; 
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$tracks = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

	<form class="form-horizontal" method="post" action="update.php">
	<fieldset>
		<legend>Edit Album</legend>

		<div class="form-group">
			<label for="title" class="col-xs-2 control-label">
				Title
			</label>
			<div class="col-xs-10">
				<input type="text" class="form-control" name="title" id="title" value="<?=$album['title']?>">
			</div>
		</div>

		<div class="form-group">
			<label for="artist" class="col-xs-2 control-label">
				Artist
			</label>
			<div class="col-xs-10">
				<input type="text" class="form-control" name="artist" id="artist" value="<?=$album['artist']?>">
			</div>
		</div>

		<div class="form-group">
			<label for="label" class="col-xs-2 control-label">
				Label
			</label>
			<div class="col-xs-10">
				<input type="text" class="form-control" id="label" name="label" value="<?=$album['label']?>">
			</div>
		</div>

		<div class="form-group">
			<label for="label" class="col-xs-2 control-label">
				Released:
			</label>
			<div class="col-xs-10">
				Day &nbsp;&nbsp;
				<input type="number" id="day" name="day" min="1" max="31" value="<?=$album['day']?>">
				&nbsp;&nbsp;&nbsp;&nbsp; Month &nbsp;&nbsp;
				<select  id="month" name="month">
					<option
					<?php if ($album['month']==1) echo " selected"; ?>
					>January</option>
					<option
					<?php if ($album['month']==2) echo " selected"; ?>
					>February</option>
					<option
					<?php if ($album['month']==3) echo " selected"; ?>
					>March</option>
					<option
					<?php if ($album['month']==4) echo " selected"; ?>
					>April</option>
					<option
					<?php if ($album['month']==5) echo " selected"; ?>
			 		>May</option>
					<option
					<?php if ($album['month']==6) echo " selected"; ?>
					>June</option>
					<option
					<?php if ($album['month']==7) echo " selected"; ?>
					>July</option>
					<option
					<?php if ($album['month']==8) echo " selected"; ?>
					>August</option>
					<option
					<?php if ($album['month']==9) echo " selected"; ?>
					>September</option>
					<option
					<?php if ($album['month']==10) echo " selected"; ?>
					>October</option>
					<option
					<?php if ($album['month']==11) echo " selected"; ?>
					>November</option>
					<option
					<?php if ($album['month']==12) echo " selected"; ?>
					>December</option>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp; Year &nbsp;&nbsp;
				<input type="number" id="year" name="year" min="1930" max="2018" value="<?=$album['year']?>">	
			</div>
		</div>

		<div class="form-group">
			<div class="col-xs-10 col-xs-offset-2">
				<button class='btn btn-primary' type="submit">
					Update
				</button>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a class='btn btn-primary' href='index.php'>
					Done
				</a>
			</div>
		</div>
		<input type="hidden" name="id" value="<?=$id?>">
	</fieldset>
	</form>

	<h3>Tracks</h3>
	<table class="table table-striped table-hover tracks">
  	<thead>
	    <tr>
			<th>Track</th>
			<th>Title</th>
			<th>Duration</th>
			<th>Action</th>
	    </tr>
  	</thead>
  	<tbody>
    	<tr>
    	<form method="post" action="add.php">
    	<input type="hidden" name="id" value="<?=$id?>">
    		<td>
    			<input type="text" name="track" id="track">
    		</td>
    		<td>
    			<input type="text" name="title" id="title">
    		</td>
    		<td>
    			<input type="text" name="duration" id="duration">
    		</td>
    		<td>
    			<button type="submit" class="btn btn-sm btn-warning">
					Add
				</button>
    		</td>
    	</form>
    	</tr>
    	<?php foreach($tracks as $track) { ?>
    	<form method="post" action="updatet.php">
    	<input type="hidden" name="id" value="<?=$track['id']?>">
    	<input type="hidden" name="ida" value="<?=$id?>">
    	<tr>
    		<td>
    			<input type="text" name="track" id="track" value="<?=$track['track_number']?>">
    		</td>
    		<td>
    			<input type="text" name="title" id="title" value="<?=$track['title']?>">
    		</td>
    		<td>
    			<input type="text" name="duration" id="duration" value="<?=$track['dview']?>">
    		</td>
    		<td>
    			<button type="submit" class="btn btn-sm btn-primary">
					Update
				</button>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a href='deletet.php?id=<?=$track["id"]?>&ida=<?=$id?>'  class="btn btn-sm btn-danger">
					Delete
				</a>
    		</td>
    	</tr>
    	</form>
    	<?php } ?>
    </tbody>
    </table>
</div>

</body>
</html>