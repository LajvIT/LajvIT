<?php
 
// No direct access
 
defined('_JEXEC') or die('Restricted access'); ?>

<h1><? echo $this->events[$this->eventid]->shortname; ?> - Uppdatera karaktär</h1>

<p>Här kan du uppdatera din karaktär. För att ändra namn, rollkoncept och kultur måste du ta hjälp av arrangör eller radera din karaktär och skapa en ny.</p>

<form action="index.php" method="post" enctype="multipart/form-data" name="characterEditForm">

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
	<td colspan="3">Beskrivning nivå 3 (För vänner, familj...):</td>
</tr>
<tr>
	<td colspan="3">
		<textarea name="description3" cols="70" rows="20"><? echo $this->character->description3; ?></textarea>
	</td>
</tr>

<tr>
	<td colspan="3">Beskrivning nivå 2 (För bekanta, grannar...):</td>
</tr>				
<tr>
	<td colspan="3">
		<textarea name="description2" cols="70" rows="10"><? echo $this->character->description2; ?></textarea>
	</td>
</tr>

<tr>
	<td colspan="3">Beskrivning nivå 1 (Rykten...):</td>
</tr>				
<tr>
	<td colspan="3">
		<textarea name="description1" cols="70" rows="5"><? echo $this->character->description1; ?></textarea>
	</td>
</tr>

<tr>
	<td colspan="3">Privat information (För Spelaren/Arrangören/Rollcoachen):</td>
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

<tr>
<td colspan="2">
<p><strong>Förklaring:</strong></p>
<p>Ålder - Din karaktärs ålder</p>
<p>Beskrivning nivå 3 - Den mest detaljerade beskrivningen av din karaktär. Det som dina närmaste vänner och familj känner till.</p>
<p>Beskrivning nivå 2 - Det som dina bekanta och grannar känner till.</p>
<p>Beskrivning nivå 1 - Din karaktärs rykte, eller det som man mycket lätt kan ta reda på genom att fråga folk i trakten. Bör vara mycket kortfattat. Denna information kommer vara synlig för nästan alla spelare.</p>
<p>Notera att varje nivå måste vara självförklarande.</p>
<p>Privat information (För spelaren och arrangören) - Här skriver du information som du inte vill att någon annan spelare ska läsa, men som kan vara bra för arrangören att känna till om din karaktär. Här kan du också skriva eventuella intrigförslag.</p>
<p>Beskriv viktiga saker kring din karaktär. Men skriv överlag kort och koncist för både dina arrangörers och medspelares skull.</p>
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
