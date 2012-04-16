<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

$knownasSortOrder = ($this->orderBy == 'knownas' && $this->sortOrder == 'ASC') ? 'DESC' : 'ASC';
$cultureSortOrder = ($this->orderBy == 'culture' && $this->sortOrder == 'ASC') ? 'DESC' : 'ASC';
$conceptSortOrder = ($this->orderBy == 'concept' && $this->sortOrder == 'ASC') ? 'DESC' : 'ASC';
$personSortOrder = ($this->orderBy == 'personname' && $this->sortOrder == 'ASC') ? 'DESC' : 'ASC';
$createdSortOrder = ($this->orderBy == 'created' && $this->sortOrder == 'ASC') ? 'DESC' : 'ASC';
$updatedSortOrder = ($this->orderBy == 'updated' && $this->sortOrder == 'ASC') ? 'DESC' : 'ASC';

function getLink($event, $item, $orderBy, $sortOrder,
    $characterStatus, $confirmation, $page, $faction) {
  $link = "index.php?option=com_lajvit&view=registrations&layout=export";
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

if ($this->mergedrole->registration_list && $this->mergedrole->person_viewcontactinfo) {
  $personrow = array(); ?>

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
    </tr>
  </table>

  <textarea name="csvdata" cols="80" rows="50">Förnamn;Efternamn;Personnummer;Medlemsavgift;Startdatum;Slutdatum;Kön;CO-Adress;Gatuadress;Postnr;Ort;Land;E-postadress;Telefon 1;Telefon 2<?php
  echo "\n";
  foreach ($this->factions as $faction) {
    foreach ($faction->characters as $char) {
      if (!$char->role->registration_list || !$char->role->person_viewcontactinfo) {
        continue;
      }
      if (array_key_exists($char->personid, $personrow)) {
        continue;
      }

      echo $char->person->givenname.';';
      echo $char->person->surname.';';
      echo $char->person->pnumber.';';
      echo '50;';
      echo $char->timeofconfirmation.';';
      echo '0000-00-00;';
      echo $char->person->sex.';';
      echo ';';
      echo $char->person->street.';';
      echo $char->person->zip.';';
      echo $char->person->town.';';
      echo ';';
      echo $char->person->email.';';
      echo $char->person->phone1.';';
      echo $char->person->phone2."\n";

      $personrow[$char->personid] = TRUE;
    }
  } ?>
  </textarea><?php
} ?>
