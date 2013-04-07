<?php

// No direct access

defined('_JEXEC') or die('Restricted access'); ?>
<script language="javascript"><!--
  function setConceptOptions(chosen) {
    var selbox = document.characterEditConceptForm.conceptid;
    selbox.options.length = 0;
    if (chosen == 0) {
      selbox.options[selbox.options.length] = new Option('<?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT_CHOOSE_CULTURE_FIRST'); ?>','0');
    }
<?php
foreach ($this->cultures as $culture) {
  echo "    if (chosen == " . $culture->id . ") {\n";
  echo "      selbox.options[selbox.options.length] =" .
      " new Option(\"" . JText::_('COM_LAJVIT_CHARACTER_EDIT_CHOOSE_MAIN_CONCEPT') . "\",\"0\")\n";
  foreach ($this->concepts as $concept) {
    if ($concept->cultureid == $culture->id) {
      echo "      selbox.options[selbox.options.length] = new Option(\"" .
          $concept->name ."\", " . $concept->id . ")\n";
    }
  }
  echo "    }\n";
}
echo "  }\n";
?> -->
</script>

<h1><?php echo $this->events[$this->eventid]->shortname; ?> - <?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT_UPDATE_CONCEPT'); ?></h1>

<p><?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT_CONCEPT_DESC'); ?></p>

<form action="index.php" method="post" enctype="multipart/form-data" name="characterEditConceptForm">

<table>
  <tbody>
  <tr>
<td><strong><?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT_NAME'); ?>:</strong></td>
<td><input type="text" name="fullname" value="<?php echo $this->fullname; ?>" size="40" >*</td>
</tr>

<tr>
<td><strong><?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT_FACTION'); ?>:</strong></td>
<td><select name="factionid">
<option value="0"<?php
if ($this->factionid <= 0) { ?>
  selected="selected"<?php
} ?>
>
  <?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT_CHOOSE_FACTION'); ?>
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
<td><strong><?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT_CULTURE'); ?>:</strong></td>
<td><select name="cultureid" onchange="setConceptOptions(this.options[this.selectedIndex].value);">
<option value="0"<?php
if ($this->cultureid <= 0) { ?>
  selected="selected"<?php
} ?>
>
  <?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT_CHOOSE_MAIN_CULTURE'); ?>
</option><?php
foreach ($this->cultures as $culture) {
  if ($culture->id < 108) { continue; } ?>
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
      <td><strong><?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT_CONCEPT'); ?>:</strong></td>
      <td>
        <select name="conceptid" selected="<?php echo $this->conceptid; ?>"><?php
        if ($this->cultureid > 0) { ?>
          <option value="0"><?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT_CHOOSE_MAIN_CONCEPT'); ?></option><?php
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
            <option value="0" selected="selected"><?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT_CHOOSE_CULTURE_FIRST'); ?></option><?php
        } ?>
        </select>*
      </td>
    </tr>

    <tr>
      <td><strong><?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT_SPECIALISED_CONCEPT'); ?>:</strong></td>
      <td><input type="text" name="concepttext" value="<?php echo $this->character->concepttext; ?>" size="25" ></td>
    </tr>

    <tr>
  <td></td>
  <td>
    <input type="submit" value="<?php echo JText::_('COM_LAJVIT_CHARACTER_EDIT_SAVE'); ?>" title="save" />
  </td>
</tr>

  </tbody>
</table>

<input type="hidden" name="option" value="com_lajvit"/>
<input type="hidden" name="task" value="saveConcept"/>
<input type="hidden" name="controller" value="character"/>
<input type="hidden" name="eid" value="<?php echo $this->eventid; ?>"/>
<input type="hidden" name="cid" value="<?php echo $this->characterid; ?>"/>
<input type="hidden" name="Itemid" value="<?php echo $this->itemid; ?>"/>

</form>
