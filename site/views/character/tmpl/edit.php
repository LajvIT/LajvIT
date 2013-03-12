<?php

// No direct access

defined('_JEXEC') or die('Restricted access'); ?>

<h1><?php echo $this->events[$this->eventid]->shortname; ?> - Uppdatera karaktär</h1>

<p>Här kan du uppdatera din karaktär. För att ändra namn, rollkoncept och kultur måste du ta
 hjälp av arrangör eller radera din karaktär och skapa en ny.</p>

<form action="index.php" method="post" enctype="multipart/form-data" name="characterEditForm">

<table>
<tbody>
<tr>
  <td>Karaktärens namn:</td>
  <td><?php echo $this->character->fullname; ?></td>

  <td rowspan="6">
<?php
if (!is_null($this->character->image)) {
  echo '    <img src="' . $this->character->image . '"/>';
} ?>
  </td>
</tr>

<tr>
  <td>Faktion:</td>
  <td><?php echo $this->character->factionname; ?></td>
</tr>

<tr>
  <td>Kultur:</td>
  <td><?php echo $this->character->culturename; ?></td>
</tr>

<tr>

  <td>Rollkoncept:</td>
  <td><?php echo $this->character->conceptname; ?></td>
</tr>

<tr>
  <td>Specialiserat rollkoncept:</td>
  <td><?php echo $this->character->concepttext; ?></td>
</tr>

<tr>
  <td>Ålder:</td>
  <td>
    <input type="text" name="age" size="5" value="<?php echo $this->character->age; ?>"/>
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
  <td colspan="3"><?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_FOR_GROUPMEMBERS'); ?>:</td>
</tr>
<tr>
  <td colspan="3">
    <textarea name="description3" cols="70" rows="20">
      <?php echo $this->character->description3; ?>
    </textarea>
  </td>
</tr>
<?php if (FALSE) { ?>
<tr>
  <td colspan="3">Beskrivning nivå 2 (För bekanta, grannar...):</td>
</tr>
<tr>
  <td colspan="3">
    <textarea name="description2" cols="70" rows="10">
      <?php echo $this->character->description2; ?>
    </textarea>
  </td>
</tr>
<?php } ?>
<tr>
  <td colspan="3"><?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_RUMOURS'); ?>:</td>
</tr>
<tr>
  <td colspan="3">
    <textarea name="description1" cols="70" rows="5">
      <?php echo $this->character->description1; ?>
    </textarea>
  </td>
</tr>

<tr>
  <td colspan="3"><?php echo JText::_('COM_LAJVIT_CHARACTER_INFO_FOR_GROUPLEADER'); ?>:</td>
</tr>
<tr>
  <td colspan="3">
    <textarea name="infoforgroupleader" cols="70" rows="10">
      <?php echo $this->character->infoforgroupleader; ?>
    </textarea>
  </td>
</tr>

<tr>
  <td colspan="3"><?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_PRIVATE'); ?>:</td>
</tr>
<tr>
  <td colspan="3">
  <textarea name="privateinfo" cols="70" rows="10">
    <?php echo $this->character->privateinfo; ?>
  </textarea>
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
<p><?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_FOR_GROUPMEMBERS'); ?> - <?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_FOR_GROUPMEMBERS_EXPLANATION'); ?></p>
<p><?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_RUMOURS'); ?> - <?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_RUMOURS_EXPLANATION'); ?></p>
<p><?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_NOTE1'); ?></p>
<p><?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_PRIVATE'); ?> - <?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_PRIVATE_EXPLANATION'); ?></p>
<p><?php echo JText::_('COM_LAJVIT_CHARACTER_DESC_NOTE2'); ?></p>
</td>
</tr>

</tbody>
</table>

<input type="hidden" name="option" value="com_lajvit"/>
<input type="hidden" name="task" value="save"/>
<input type="hidden" name="controller" value="character"/>
<input type="hidden" name="eid" value="<?php echo $this->eventid; ?>"/>
<input type="hidden" name="cid" value="<?php echo $this->characterid; ?>"/>
<input type="hidden" name="Itemid" value="<?php echo $this->itemid; ?>"/>

</form>
