<?php

// No direct access
defined('_JEXEC') or die('Restricted access');
?>

<h1>Intriger för:</h1>

<table>
	<tbody>
		<tr>
			<td colspan="2"><h2>Karaktär</h2></td>
		</tr><?php
			foreach ($this->plotObjectsCharacter as $plotObject) {
				?>
		<tr>
			<td><h3><?php echo $plotObject->heading;?></h3></td>
			<td><?php echo $plotObject->description; ?></td>
		</tr><?php
			} ?>
		<tr><td colspan="2"></td></tr>
		<tr>
			<td colspan="2"><h2>Koncept</h2></td>
		</tr><?php
			foreach ($this->plotObjectsConcept as $plotObject) {
				?>
		<tr>
			<td><h3><?php echo $plotObject->heading;?></h3></td>
			<td><?php echo $plotObject->description; ?></td>
		</tr><?php
			} ?>
		<tr><td colspan="2"></td></tr>
		<tr>
			<td colspan="2"><h2>Kultur</h2></td>
		</tr><?php
			foreach ($this->plotObjectsCulture as $plotObject) {
				?>
		<tr>
			<td><h3><?php echo $plotObject->heading;?></h3></td>
			<td><?php echo $plotObject->description; ?></td>
		</tr><?php
			} ?>
		<tr><td colspan="2"></td></tr>
		<tr>
			<td colspan="2"><h2>Faktion</h2></td>
		</tr><?php
			foreach ($this->plotObjectsFaction as $plotObject) {
				?>
		<tr>
			<td><h3><?php echo $plotObject->heading;?></h3></td>
			<td><?php echo $plotObject->description; ?></td>
		</tr><?php
			} ?>
		<tr><td colspan="2"></td></tr>
	</tbody>
</table>

