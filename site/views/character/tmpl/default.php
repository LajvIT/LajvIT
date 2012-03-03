<?php

// No direct access

defined('_JEXEC') or die('Restricted access'); ?>

<h1><?php echo $this->events[$this->eventid]->shortname; ?> - Karaktärsinfo</h1>

<table>
<tbody>
<tr>
  <td>Karaktärens namn:</td>
  <td><?php echo $this->character->fullname; ?></td>

  <td rowspan="6">
<?php     if (!is_null($this->character->image)) { ?>
      <img src="<?php echo $this->character->image; ?>"/>
<?php    } ?>
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
  <td><?php echo $this->character->age; ?></td>
</tr>

<tr>
  <td></td>
  <td></td>
</tr>

<?php  if ($this->role->character_view_lvl3) { ?>
  <tr>
    <td colspan="3">Beskrivning nivå 3 (För vänner, familj...):</td>
  </tr>
  <tr>
    <td colspan="3">
      <textarea name="description3" cols="70" rows="20" disabled="disabled"><?php echo $this->character->description3; ?></textarea>
    </td>
  </tr>
<?php  } ?>

<?php  if ($this->role->character_view_lvl2) { ?>
    <tr>
      <td colspan="3">Beskrivning nivå 2 (För bekanta, grannar...):</td>
    </tr>
    <tr>
      <td colspan="3">
        <textarea name="description2" cols="70" rows="10" disabled="disabled"><?php echo $this->character->description2; ?></textarea>
      </td>
    </tr>
<?php  } ?>

<?php  if ($this->role->character_view_lvl1) { ?>
  <tr>
    <td colspan="3">Beskrivning nivå 1 (Rykten...):</td>
  </tr>
  <tr>
    <td colspan="3">
      <textarea name="description1" cols="70" rows="5" disabled="disabled"><?php echo $this->character->description1; ?></textarea>
    </td>
  </tr>
<?php  } ?>

<?php  if ($this->role->character_view_private) { ?>
  <tr>
    <td colspan="3">Privat information (För spelaren, arrangörer och rollcoach):</td>
  </tr>
  <tr>
    <td colspan="3">
      <textarea name="privateinfo" cols="70" rows="10" disabled="disabled"><?php echo $this->character->privateinfo; ?></textarea>
    </td>

  </tr>
<?php  } ?>

</tbody>
</table>

