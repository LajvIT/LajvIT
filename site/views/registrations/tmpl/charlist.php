<?php
defined('_JEXEC') or die('Restricted access');

$knownasSortOrder = ($this->orderBy == 'knownas' && $this->sortOrder == 'ASC') ? 'DESC' : 'ASC';
$cultureSortOrder = ($this->orderBy == 'culture' && $this->sortOrder == 'ASC') ? 'DESC' : 'ASC';
$conceptSortOrder = ($this->orderBy == 'concept' && $this->sortOrder == 'ASC') ? 'DESC' : 'ASC';
$personSortOrder = ($this->orderBy == 'personname' && $this->sortOrder == 'ASC') ? 'DESC' : 'ASC';
$createdSortOrder = ($this->orderBy == 'created' && $this->sortOrder == 'ASC') ? 'DESC' : 'ASC';
$updatedSortOrder = ($this->orderBy == 'updated' && $this->sortOrder == 'ASC') ? 'DESC' : 'ASC';

function getLink($event, $item, $orderBy, $sortOrder, $characterStatus, $confirmation, $page, $faction) {
  $link = "index.php?option=com_lajvit&view=registrations&layout=charlist";
  $link .= "&eid=" . $event;
  $link .= "&Itemid=" . $item;
  $link .= "&orderby=" . $orderBy;
  $link .= "&sortorder=" . $sortOrder;
  if ($characterStatus != NULL) {
    $link .= "&charstatus=" . $characterStatus;
  }
  if ($confirmation != NULL) {
    $link .= "&confirmation=" . $confirmation;
  }
  $link .= "&page=" . $page;
  if ($faction != NULL) {
    $link .= "&factionid=" . $faction;
  }
  return $link;
}

if ($this->mergedrole->character_list) { ?>
    <table>
      <tr>
        <td colspan="5">Filtrering:&nbsp;
          <a href="<?php echo getLink($this->event->id,
                                   $this->itemid,
                                   $this->orderBy,
                                   $this->sortOrder,
                                   NULL,
                                   NULL,
                                   $this->page,
                                   NULL)?>" title="Ingen">Ingen</a>
        </td>
      </tr>
      <tr>
        <td></td>
        <td colspan="4">
          Faktion:<?php
  foreach ($this->factions as $faction) { ?>
            <a href="<?php echo getLink($this->event->id,
                                   $this->itemid,
                                   $this->orderBy,
                                   $this->sortOrder,
                                   $this->characterStatus,
                                   $this->confirmation,
                                   $this->page,
                                   $faction->id)?>" title="<?php echo $faction->name?>"><?php echo $faction->name?></a><?php
  } ?>
        </td>
      </tr><?php
  if ($this->mergedrole->character_list) { ?>
        <tr>
          <td></td>
          <td colspan="4">
            Rollstatus:<?php
    foreach ($this->status as $status) { ?>
              <a href="<?php echo getLink($this->event->id,
                                     $this->itemid,
                                     $this->orderBy,
                                     $this->sortOrder,
                                     $status->id,
                                     $this->confirmation,
                                     $this->page,
                                     $this->factionid)?>" title="<?php echo $status->name?>"><?php echo $status->name?></a><?php
    } ?>
          </td>
        </tr><?php
  }
  if ($this->role->registration_list) { ?>
        <tr>
          <td></td>
          <td colspan="4">
            Betalning:<?php
    foreach ($this->confirmations as $confirmation) { ?>
              <a href="<?php echo getLink($this->event->id,
                                     $this->itemid,
                                     $this->orderBy,
                                     $this->sortOrder,
                                     $this->characterStatus,
                                     $confirmation->id,
                                     $this->page,
                                     $this->factionid)?>" title="<?php echo $confirmation->name?>"><?php echo $confirmation->name?></a><?php
    } ?>
          </td>
        </tr><?php
  } ?>
    </table>
    <textarea name="csvdata"
      cols="80" rows="50">Förnamn;Efternamn;Rollnamn;Rollkoncept;Kultur;Faktion<?php
  echo "\n";
  foreach ($this->factions as $faction) {
    foreach ($faction->characters as $char) {
      if (!$char->role->character_list) {
        continue;
      }

      echo $char->person->givenname.';';
      echo $char->person->surname.';';
      echo $char->fullname.';';
      echo $char->conceptname;
      if (!is_NULL($char->concepttext) && strlen($char->concepttext) > 0) {
        echo " (" . $char->concepttext . ")";
      }
      echo ';';
      echo $char->culturename.';';
      echo $char->factionname."\n";
    }
  } ?>
  </textarea><?php
} ?>
