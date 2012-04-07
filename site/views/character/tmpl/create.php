<?php

defined('_JEXEC') or die('Restricted access'); ?>

<script language="javascript"><!--
  function setConceptOptions(chosen) {
    var selbox = document.characterCreateForm.conceptid;
    selbox.options.length = 0;
    if (chosen == 0) {
      selbox.options[selbox.options.length] = new Option('Välj kultur först','0');
    }
<?php
foreach ($this->cultures as $culture) {
  echo '    if (chosen == ' . $culture->id . ') {';
  echo '      selbox.options[selbox.options.length] =' .
      ' new Option("Välj huvudsakligt rollkoncept","0")';
  foreach ($this->concepts as $concept) {
    if ($concept->cultureid == $culture->id) {
      echo '      selbox.options[selbox.options.length] = new Option(' .
          $concept->name .', ' . $concept->id . ')';
    }
  }
  echo '    }';
}
echo '  }';
?> -->
</script>


<h1><?php echo $this->events[$this->eventid]->shortname; ?> - Skapa karaktär</h1>

<?php
if ($this->failed == 1) { ?>
  <p style="color:red;">Några obligatoriska fält är inte ifyllda.</p><?php
} ?>

<form action="index.php" method="post" name="characterCreateForm">

<table>
<tbody>

<tr>
<td><strong>Arrangemang:</strong></td>
<td><strong><?php echo $this->events[$this->eventid]->name; ?></strong></td>
</tr>

<tr>
<td><strong>Rollens namn:</strong></td>
<td><input type="text" name="fullname" value="<?php echo $this->fullname; ?>" size="40" >*</td>
</tr>

<tr>
<td><strong>Faktion:</strong></td>
<td><select name="factionid">
<option value="0"<?php
if ($this->factionid <= 0) { ?>
  selected="selected"<?php
} ?>
>
  Välj faktion
</option><?php
foreach ($this->factions as $faction) { ?>
    <option value="<?php echo $faction->id; ?>"<?php
  if ($this->factionid == $faction->id) { ?>
      selected="selected"<?php
  } ?>
    ><?php
  echo $faction->name; ?>
    </option><?php
} ?>
</select>*
</td>
</tr>

<tr>
<td><strong>Kultur:</strong></td>
<td><select name="cultureid" onchange="setConceptOptions(this.options[this.selectedIndex].value);">
<option value="0"<?php
if ($this->cultureid <= 0) { ?>
  selected="selected"<?php
} ?>
>
  Välj huvudsaklig kultur
</option><?php
foreach ($this->cultures as $culture) { ?>
    <option value="<?php echo $culture->id; ?>"<?php
  if ($this->cultureid == $culture->id) { ?>
      selected="selected"<?php
  } ?>
    ><?php
  echo $culture->name; ?>
    </option><?php
} ?>
</select>*
</td>
</tr>

<tr>
<td><strong>Rollkoncept:</strong></td>
<td>
<select name="conceptid" selected="<?php echo $this->conceptid; ?>"><?php
if ($this->cultureid > 0) { ?>
    <option value="0">Välj huvudsakligt rollkoncept</option><?php
  foreach ($this->concepts as $concept) {
    if ($concept->cultureid == $this->cultureid) { ?>
        <option value="<?php echo $concept->id; ?>"<?php
      if ($this->conceptid == $concept->id) { ?>
          selected="selected"<?php
      } ?>
        ><?php
      echo $concept->name; ?>
        </option><?php
    }
  }
} else { ?>
    <option value="0" selected="selected">Välj kultur först</option><?php
} ?>
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
<p>Faktion - Den huvudfaktion du anser att din karaktär tillhör.</p>
<p>Kultur - Din karaktärs kulturella bakgrund. Ofta den region där karaktären vuxit upp.</p>
<p>Rollkoncept - Karaktärens primära rollkoncept. Om du inte hittar ett lämpligt,
 välj konceptet Annat.</p>
<p>Specialiserat koncept - Karaktärens specialiserade rollkoncept. Exempel på rollkoncept med
specialisering inom parentes: Hantverkare (Snickare), Värnfalk (Artillerist), Annat
(Dödgrävare)</p>
<p>Gruppsamordnare - Om karaktären tillhör en offgrupp, ange namnet på gruppens
kontaktperson/samordnare här.</p>
</td>
</tr>


</tbody>
</table>

<input type="hidden" name="option" value="com_lajvit"/>
<input type="hidden" name="task" value="create"/>
<input type="hidden" name="controller" value="character"/>
<input type="hidden" name="eid" value="<?php echo $this->eventid; ?>"/>
<input type="hidden" name="Itemid" value="<?php echo $this->itemid; ?>"/>

</form>
