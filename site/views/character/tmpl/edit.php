<?php
 
// No direct access
 
defined('_JEXEC') or die('Restricted access'); ?>

<h1><? echo $this->events[$this->eventid]->shortname; ?> - Uppdatera karaktär</h1>

<p>Här kan du uppdatera din karaktär. För att ändra namn, rollkoncept och kultur måste du ta hjälp av arrangör eller radera din karaktär och skapa en ny.</p>

<form action="index.php" method="post" enctype="multipart/form-data" name="characterEditForm">

<table>
<tbody>
<tr>
	<td>Rollens namn:</td>
	<td><? echo $this->character->fullname; ?></td>

	<td rowspan="6">
<? 		if (!is_null($this->character->image)) { ?>
			<img src="<? echo $this->character->image; ?>"/>
<?		} ?>
	</td>
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
	<td>
		<input type="text" name="age" size="5" value="<? echo $this->character->age; ?>"/>
	</td>
</tr>

<tr>
	<td></td>
	<td></td>
</tr>
 
<tr>
	<td>Foto:</td>
	<td colspan="2">
		<input type="file" name="photo" size="25"/>
		(Max 300x300 pixlar.)
	</td>
</tr>

<tr>
	<td colspan="3">Beskrivning nivå 3**  (Vänner, familj...):</td>
</tr>
<tr>
	<td colspan="3">
		<textarea name="description3" cols="70" rows="20"><? echo $this->character->description3; ?></textarea>
	</td>
</tr>

<tr>
	<td colspan="3">Beskrivning nivå 2** (Bekannta, grannar...):</td>
</tr>				
<tr>
	<td colspan="3">
		<textarea name="description2" cols="70" rows="10"><? echo $this->character->description2; ?></textarea>
	</td>
</tr>

<tr>
	<td colspan="3">Beskrivning nivå 1** (Rykten..):</td>
</tr>				
<tr>
	<td colspan="3">
		<textarea name="description1" cols="70" rows="5"><? echo $this->character->description1; ?></textarea>
	</td>
</tr>

<tr>
	<td colspan="3">Privat information (För spelaren och arrangören):</td>
</tr>				
<tr>
	<td colspan="3">
	<textarea name="privateinfo" cols="70" rows="10"><? echo $this->character->privateinfo; ?></textarea>
	</td>

</tr>

<tr>
	<td></td>
	<td>
		<input type="submit" value="Spara ändringar" title="save" />
	</td>
</tr>

</tbody>
</table>

<input type="hidden" name="option" value="com_lajvit"/>
<input type="hidden" name="task" value="save"/>
<input type="hidden" name="controller" value="character"/>
<input type="hidden" name="eid" value="<? echo $this->eventid; ?>"/>
<input type="hidden" name="cid" value="<? echo $this->characterid; ?>"/>
<input type="hidden" name="Itemid" value="<? echo $this->itemid; ?>"/>

</form>
