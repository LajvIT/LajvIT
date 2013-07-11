<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

$user = JFactory::getUser();
$canDo = EventHelper::getActions($this->event->id);

$knownasSortOrder = ($this->orderBy == 'knownas' && $this->sortOrder == 'ASC') ? 'DESC' : 'ASC';
$cultureSortOrder = ($this->orderBy == 'culture' && $this->sortOrder == 'ASC') ? 'DESC' : 'ASC';
$conceptSortOrder = ($this->orderBy == 'concept' && $this->sortOrder == 'ASC') ? 'DESC' : 'ASC';
$personSortOrder = ($this->orderBy == 'personname' && $this->sortOrder == 'ASC') ? 'DESC' : 'ASC';
$createdSortOrder = ($this->orderBy == 'created' && $this->sortOrder == 'ASC') ? 'DESC' : 'ASC';
$updatedSortOrder = ($this->orderBy == 'updated' && $this->sortOrder == 'ASC') ? 'DESC' : 'ASC';

function getLink($event, $item, $orderBy, $sortOrder, $characterStatus, $confirmation, $page, $faction) {
  $link = "index.php?option=com_lajvit&view=registrations&layout=medicine";
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
if ($canDo->get('lajvit.view.medical')) { ?>
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

    <textarea name="csvdata" cols="80" rows="50"><?php
  foreach ($this->factions as $faction) {
    $personrow = array();
    echo $faction->name."\n";
    ?>Förnamn;Efternamn;Personnummer;Kön;Gatuadress;Postnr;Ort;E-postadress;Telefon 1;Telefon 2;Publik epost;Allergier;Medicinsk info;Beskrivning;Rollnamn;Fraktion;Kultur;Koncept;Specialiserat koncept;Grupper<?php
    echo "\n";
    foreach ($faction->characters as $char) {
      if (array_key_exists($char->personid, $personrow)) {
        continue;
      }

      $char->person->allergies = trim($char->person->allergies);
      $char->person->medicine = trim($char->person->medicine);
      $char->person->info = trim($char->person->info);

      $char->person->allergies = str_replace("\r\n", "| ", $char->person->allergies);
      $char->person->medicine = str_replace("\r\n", "| ", $char->person->medicine);
      $char->person->info = str_replace("\r\n", "| ", $char->person->info);

      $char->person->allergies = str_replace("\n", "| ", $char->person->allergies);
      $char->person->medicine = str_replace("\n", "| ", $char->person->medicine);
      $char->person->info = str_replace("\n", "| ", $char->person->info);

      $char->person->allergies = str_replace("\r", "| ", $char->person->allergies);
      $char->person->medicine = str_replace("\r", "| ", $char->person->medicine);
      $char->person->info = str_replace("\r", "| ", $char->person->info);

      echo $char->person->givenname.';';
      echo $char->person->surname.';';
      echo $char->person->pnumber.';';
      echo $char->person->sex.';';
      echo $char->person->street.';';
      echo $char->person->zip.';';
      echo $char->person->town.';';
      echo $char->person->email.';';
      echo $char->person->phone1.';';
      echo $char->person->phone2.';';
      echo $char->person->publicemail.';';
      echo $char->person->allergies.';';
      echo $char->person->medicine.';';
      echo $char->person->info.';';

      echo $char->fullname.';';
      echo $faction->name.';';
      echo $char->culturename.';';
      echo $char->conceptname.';';
      echo $char->concepttext.';';

      echo $char->groupNames."\n";

      $personrow[$char->personid] = TRUE;
    }
    echo "\n";
  } ?>
  </textarea><?php
} ?>