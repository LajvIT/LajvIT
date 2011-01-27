<?php
 
// No direct access
 
defined('_JEXEC') or die('Restricted access'); ?>

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
<td><strong>Kultur:</strong></td>
<td><select name="cultureid" >
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
<option value="0" selected="selected">Välj huvudsakligt rollkoncept</option>
<? foreach ($this->concepts as $concept) { ?>
<option value="<?echo $concept->id; ?>"><? echo $concept->name; ?></option>
<? } ?>
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
