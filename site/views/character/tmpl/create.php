<?php
 
// No direct access
 
defined('_JEXEC') or die('Restricted access'); ?>

<script language="javascript"><!--
	function setConceptOptions(chosen) {
		var selbox = document.characterCreateForm.conceptid;
		selbox.options.length = 0;
		if (chosen == 0) {
			selbox.options[selbox.options.length] = new Option('Välj kultur först','0');
		}
		
<? 		foreach ($this->cultures as $culture) { ?>
			if (chosen == '<? echo $culture->id; ?>') {
				selbox.options[selbox.options.length] = new Option('Välj huvudsakligt rollkoncept','0');
<?				foreach ($this->concepts as $concept) {
					if ($concept->cultureid == $culture->id) { ?>
						selbox.options[selbox.options.length] = new Option('<? echo $concept->name; ?>','<? echo $concept->id; ?>');
<?					} ?>					
<?				} ?>
			}
<?		} ?>
	}
--></script> 


<h1><? echo $this->events[$this->eventid]->shortname; ?> - Skapa karaktär</h1>

<form action="index.php" method="post" name="characterCreateForm">

<table>
<tbody>

<tr>
<td><strong>Arrangemang:</strong></td>
<td><strong><? echo $this->events[$this->eventid]->name; ?></strong></td>
</tr>

<tr>
<td><strong>Rollens namn:</strong></td>
<td><input type="text" name="fullname" value="" size="40" >*</td>
</tr>

<tr>
<td><strong>Faktion:</strong></td>
<td><select name="factionid">
<option value="0" selected="selected">Välj faktion</option>
<? foreach ($this->factions as $faction) { ?>
<option value="<?echo $faction->id; ?>"><? echo $faction->name; ?></option>
<? } ?>
</select>*
</td>
</tr>

<tr>
<td><strong>Kultur:</strong></td>
<td><select name="cultureid" 
onchange="setConceptOptions(this.options[this.selectedIndex].value);">
<option value="0" selected="selected">Välj huvudsaklig kultur</option>
<? foreach ($this->cultures as $culture) { ?>
<option value="<?echo $culture->id; ?>"><? echo $culture->name; ?></option>
<? } ?>
</select>*
</td>
</tr>

<tr>
<td><strong>Rollkoncept:</strong></td>
<td>
<select name="conceptid" >
<option value="0" selected="selected">Välj kultur först</option>
</select>*
</td>
</tr>

<tr>
<td><strong>Specialiserat koncept:</strong></td>
<td><input type="text" name="concepttext" value="" size="25" ></td>
</tr>

<tr>
<td><strong>Gruppsamordnare:</strong></td>
<td><input type="text" name="groupleader" value="" size="40" ></td>
</tr>

<tr>
<td></td >
<td>
<input type="submit" value="Skapa karaktär"/>
</td>

</tr>

<tr>
<td colspan="2">
<p><strong>Förklaring:</strong></p>
<p>Rollkoncept - Rollens primära rollkoncept. Om du inte hittar ett lämpligt, välj konceptet Annat. </p>
<p>Specialiserat koncept - Rollens specialiserade rollkoncept. Exempel på rollkoncept med specialisering inom parentes: Hantverkare (Snickare), Värnfalk (Artillerist), Annat (Dödgrävare) </p>
</td>
</tr>


</tbody>
</table>

<input type="hidden" name="option" value="com_lajvit"/>
<input type="hidden" name="task" value="create"/>
<input type="hidden" name="controller" value="character"/>
<input type="hidden" name="eid" value="<? echo $this->eventid; ?>"/>
<input type="hidden" name="Itemid" value="<? echo $this->itemid; ?>"/>

</form>
