<?php
 
// No direct access
 
defined('_JEXEC') or die('Restricted access'); ?>

<h1><? echo $this->events[$this->eventid]->shortname; ?> - Karaktärsinfo</h1>

<table>
<tbody>
<tr>
	<td>Karaktärens namn:</td>
	<td><? echo $this->character->fullname; ?></td>

	<td rowspan="6">
<? 		if (!is_null($this->character->image)) { ?>
			<img src="<? echo $this->character->image; ?>"/>
<?		} ?>
	</td>
</tr>

<tr>
	<td>Faktion:</td>
	<td><? echo $this->character->factionname; ?></td>
</tr>

<tr>
	<td>Kultur:</td>
	<td><? echo $this->character->culturename; ?></td>
</tr>

<tr>

	<td>Rollkoncept:</td>
	<td><? echo $this->character->conceptname; ?></td>
</tr>

<tr>
	<td>Specialiserat rollkoncept:</td>
	<td><? echo $this->character->concepttext; ?></td>
</tr>

<tr>
	<td>Ålder:</td>
	<td><? echo $this->character->age; ?></td>
</tr>

<tr>
	<td></td>
	<td></td>
</tr>

<tr>
	<td colspan="3">Beskrivning nivå 3 (För vänner, familj...):</td>
</tr>
<tr>
	<td colspan="3">
		<textarea name="description3" cols="70" rows="20" disabled="disabled"><? echo $this->character->description3; ?></textarea>
	</td>
</tr>

<?	if ($this->role->character_list) { ?>
		<tr>
			<td colspan="3">Beskrivning nivå 2 (För bekanta, grannar...):</td>
		</tr>				
		<tr>
			<td colspan="3">
				<textarea name="description2" cols="70" rows="10" disabled="disabled"><? echo $this->character->description2; ?></textarea>
			</td>
		</tr>
<?	} ?>

<?	if ($this->role->character_list) { ?>
	<tr>
		<td colspan="3">Beskrivning nivå 1 (Rykten...):</td>
	</tr>				
	<tr>
		<td colspan="3">
			<textarea name="description1" cols="70" rows="5" disabled="disabled"><? echo $this->character->description1; ?></textarea>
		</td>
	</tr>
<?	} ?>

<?	if ($this->role->character_list) { ?>
	<tr>
		<td colspan="3">Privat information (För spelaren och arrangören):</td>
	</tr>				
	<tr>
		<td colspan="3">
			<textarea name="privateinfo" cols="70" rows="10" disabled="disabled"><? echo $this->character->privateinfo; ?></textarea>
		</td>
	
	</tr>
<?	} ?>

</tbody>
</table>

