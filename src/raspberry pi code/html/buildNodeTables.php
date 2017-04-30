<?php 
$conn = new mysqli('localhost', 'root', 'delta5fpv', 'vtx');
if ($conn->connect_error) {	die("Connection error: " . $conn->connect_error); }


$results = $conn->query("SELECT * FROM `vtxReference` WHERE 1") or die($conn->error());
$vtxReference = array();
$index = 0;
while ($row = $results->fetch_assoc()) {
	$vtxReference[] = $row;
	echo $row[$index]['vtxNum']; # index might not be working, just call column names
	$index++;
}

$nodes = $conn->query("SELECT * FROM `nodes` WHERE 1") or die($conn->error());

while ($node = $nodes->fetch_assoc()) :
?>

<div class="mdl-cell mdl-cell--2-col">
<table class="delta5-table mdl-data-table mdl-js-data-table mdl-shadow--2dp">
<thead>
	<tr>
		<th>Node</th>
		<th><?php echo $node['node']; ?></th>
	</tr>
</thead>
<tbody>
<tr>
	<td>i2cAddr:</td>
	<td><?php echo $node['i2cAddr']; ?></td>
</tr>
<tr>
	<td>vtxNum:</td>
	<td><?php echo $node['vtxNum']; ?></td>
</tr>
<tr>
	<td>Channel:</td>
	<td><?php
			$key = array_search($node['vtxNum'], array_column($vtxReference, 'vtxNum'));
			echo $vtxReference[$key]['vtxChan'];
			echo " ";
			echo $vtxReference[$key]['vtxFreq'];
		?></td>
</tr>
<tr>
	<td>RSSI:</td>
	<td><?php echo $node['rssi']; ?></td>
</tr>
<tr>
	<td>Trigger:</td>
	<td><?php echo $node['rssiTrigger']; ?></td>
</tr>
</tbody>
</table>
</div>

<?php endwhile ?>
