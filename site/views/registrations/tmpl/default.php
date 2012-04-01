<?php
defined('_JEXEC') or die('Restricted access');

$pagesz = 25;
$personrow = array();
?>

<h1>Sökresultat - Karaktärer</h1>
<h2>
<?php echo $this->event->name; ?>
  &nbsp;<a href="<?php echo $this->event->url; ?>" title="Info"><img
    src="components/com_lajvit/info.png" alt="Info" /> </a>
</h2>
<?php
$knownasSortOrder = ($this->orderBy == 'knownas' && $this->sortOrder == 'ASC') ? 'DESC' : 'ASC';
$cultureSortOrder = ($this->orderBy == 'culture' && $this->sortOrder == 'ASC') ? 'DESC' : 'ASC';
$conceptSortOrder = ($this->orderBy == 'concept' && $this->sortOrder == 'ASC') ? 'DESC' : 'ASC';
$personSortOrder = ($this->orderBy == 'personname' && $this->sortOrder == 'ASC') ? 'DESC' : 'ASC';
$createdSortOrder = ($this->orderBy == 'created' && $this->sortOrder == 'ASC') ? 'DESC' : 'ASC';
$updatedSortOrder = ($this->orderBy == 'updated' && $this->sortOrder == 'ASC') ? 'DESC' : 'ASC';

function getLink($event, $item, $orderBy, $sortOrder,
    $characterStatus, $confirmation, $page, $faction) {
  $link = "index.php?option=com_lajvit&view=registrations";
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
?>

<table>
  <tbody>
<?php    if ($this->mergedrole->character_list) { ?>
    <tr>
      <td colspan="5">Sortering: &nbsp;
        <a href="<?php echo getLink($this->event->id, $this->itemid, "knownas", $knownasSortOrder,
            NULL, NULL, $this->page)?>" title="Karaktär">Karaktär</a> &nbsp;
        <a href="<?php echo getLink($this->event->id, $this->itemid, "culture",
            $cultureSortOrder, $this->characterStatus, $this->confirmation,
            $this->page, $this->factionid)?>" title="Kultur">Kultur</a> &nbsp;
        <a href="<?php echo getLink($this->event->id, $this->itemid, "concept",
            $conceptSortOrder, $this->characterStatus, $this->confirmation,
            $this->page, $this->factionid)?>" title="Koncept">Koncept</a> &nbsp;
        <a href="<?php echo getLink($this->event->id, $this->itemid, "personname",
            $personSortOrder, $this->characterStatus, $this->confirmation, $this->page,
            $this->factionid)?>" title="Spelare">Spelare</a> &nbsp;
        <a href="<?php echo getLink($this->event->id, $this->itemid, "created",
            $createdSortOrder, $this->characterStatus, $this->confirmation,
            $this->page, $this->factionid)?>" title="Skapad">Skapad</a> &nbsp;
        <a href="<?php echo getLink($this->event->id, $this->itemid, "updated",
            $updatedSortOrder, $this->characterStatus, $this->confirmation,
            $this->page, $this->factionid)?>" title="Ändrad">Ändrad</a>
      </td>
    </tr><?php
} ?>
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
                                 $faction->id)?>" title="<?php echo $faction->name?>">
                                 <?php echo $faction->name?></a><?php
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
                                 $this->factionid)?>" title="<?php echo $status->name?>">
                                 <?php echo $status->name?></a><?php
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
                                 $this->factionid)?>" title="<?php echo $confirmation->name?>">
                                 <?php echo $confirmation->name?></a><?php
  } ?>
      </td>
    </tr><?php
}

$uglypagecnt = 0;
$lastpage = 0;
foreach ($this->factions as $faction) {
  $lastpage += count($faction->characters);
} ?>
    <tr>
      <td colspan="5">
        Sida:<?php
foreach ($this->factions as $faction) {
  foreach ($faction->characters as $char) {
    if ($uglypagecnt % $pagesz == 0) {
      $linktxt = ($uglypagecnt + 1). "-" . min($uglypagecnt + $pagesz, $lastpage);
      if ($uglypagecnt / $pagesz == $this->page / $pagesz) {
        echo $linktxt." ";
      } else { ?>
        <a href="<?php echo getLink($this->event->id, $this->itemid, $this->orderBy,
            $this->sortOrder, $this->characterStatus, $this->confirmation, $uglypagecnt,
            $this->factionid)?>" title="<?php echo $linktext; ?>"><?php echo $linktxt; ?></a><?php
      }
    }
    $uglypagecnt++;
  }
} ?>
      </td>
    </tr>
  </tbody>
</table>

<form action="index.php" method="post" enctype="multipart/form-data" name="registrationsDefaultForm">
  <table>
    <tbody>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr><?php
$uglypagecnt = -1;
foreach ($this->factions as $faction) { ?>
        <tr>
          <td colspan="4">
            <h3>
              <?php echo $faction->name; ?>
            </h3>
          </td>
          <td></td>
         </tr><?php
  foreach ($faction->characters as $char) {
    $uglypagecnt++;
    if ($uglypagecnt < $this->page || $uglypagecnt >= $this->page + $pagesz) {
      continue;
    }
    if ($char->role->character_list) { ?>
            <tr>
              <td></td>
              <td colspan="3">
                <strong><?php
      echo $char->knownas . " - " . $char->culturename . ", " . $char->conceptname;
      if (!is_NULL($char->concepttext) && strlen($char->concepttext) > 0) {
        echo " (" . $char->concepttext . ")";
      } ?>
                </strong>
                &nbsp;<a href="index.php?option=com_lajvit&view=character&eid=
                <?php echo $this->event->id; ?>&cid=<?php echo $char->id; ?>&Itemid=
                <?php echo $this->itemid; ?>" title="Info">
                <img src="components/com_lajvit/info.png" alt="Info" /></a><?php
      if (FALSE) { ?>
                  &nbsp;<a href="index.php?option=com_lajvit&view=character&layout=edit&eid=
                  <?php echo $this->event->id; ?>&cid=<?php echo $char->id; ?>&Itemid=
                  <?php echo $this->itemid; ?>" title="Redigera karaktär">
                  <img src="components/com_lajvit/edit_character.png" alt="Redigera karaktär" /></a><?php
      }
      if ($char->role->character_delete) { ?>
                  &nbsp;<a href="index.php?option=com_lajvit&view=character&layout=delete&eid=
                  <?php echo $this->event->id; ?>&cid=<?php echo $char->id; ?>&Itemid=
                  <?php echo $this->itemid; ?>&redirect=registrations" title="Ta bort karaktär">
                  <img src="components/com_lajvit/delete_character.png" alt="Ta bort karaktär" /></a><?php
      } ?>
              </td>
              <td><?php
      if ($char->role->character_setstatus) { ?>
                  <select name="characterstatus_<?php echo $char->id; ?>"><?php
        foreach ($this->status as $status) { ?>
                      <option value="<?php echo $status->id; ?>"<?php
          if ($char->statusid == $status->id) {
            echo 'selected="selected"';
          } ?> > <?php
          echo $status->name; ?>
                      </option><?php
        } ?>
                  </select><?php
      } else {
        echo $char->statusname;
      } ?>
              </td>
            </tr><?php
    }
    if ($char->role->character_list || $this->role->registration_list) {
      if ($this->role->registration_list) { ?>
              <tr>
                <td></td>
                <td></td>
                <td><?php
        if (!$personrow[$char->personid]) { ?>
                    <a name="person_<?php echo $char->personid; ?>"></a><?php
        } ?>
                  <input type="hidden" name="pid_<?php echo $char->id; ?>" value="<?php echo $char->personid; ?>" /><?php
        echo $char->personname;
        if ($this->role->person_viewcontactinfo) {
          echo ' - ' . $char->pnumber;
        }
        echo '(' . $char->username . ')'; ?>
                  &nbsp;<a href="index.php?option=com_lajvit&view=person&pid=
                  <?php echo $char->personid; ?>&eid=<?php echo $this->event->id; ?>&Itemid=
                  <?php echo $this->itemid; ?>" title="Info">
                  <img src="components/com_lajvit/info.png" alt="Info" /></a>
                </td>
                <td><?php
        if ($this->role->registration_setrole) {
          if ($personrow[$char->personid]) { ?>
                      <a href="#person_<?php echo $char->personid; ?>"><?php echo $char->rolename; ?></a><?php
          } else {
            echo $char->rolename;
          }
        } ?>
                </td>
                <td><?php
        if (!$this->role->registration_setstatus) {
          echo $char->confirmationname;
          echo $char->payment . '&nbsp;kr';
        } else if ($personrow[$char->personid]) { ?>
                    <a href="#person_<?php echo $char->personid; ?>"><?php echo $char->confirmationname; ?></a> <?php echo $char->payment; ?>&nbsp;kr<?php
        } else { ?>
                    <select name="confirmationid_<?php echo $char->id; ?>"><?php
          foreach ($this->confirmations as $confirmation) { ?>
                        <option value="<?echo $confirmation->id; ?>"<?php
            if ($char->confirmationid == $confirmation->id) { ?>
                            selected="selected"<?php
            } ?> ><?php
            echo $confirmation->name; ?>
                        </option><?php
          } ?>
                    </select>
                    <input type="text" name="payment_<?php echo $char->id; ?>"
                    value="<?php echo $char->payment; ?>" size="3">&nbsp;kr<?php
        } ?>
                </td>

              </tr><?php
        $personrow[$char->personid] = TRUE;
      } else { ?>
              <tr>
                <td></td>
                <td></td>
                <td colspan="3">
                  <?php echo $char->username; ?>
                  &nbsp;<a href="index.php?option=com_lajvit&view=person&
                  pid=<?php echo $char->personid; ?>&eid=<?php echo $this->event->id; ?>
                  &Itemid=<?php echo $this->itemid; ?>" title="Info">
                  <img src="components/com_lajvit/info.png" alt="Info" /></a>
                </td>
              </tr><?php
      }
    }
    if ($char->role->character_list) { ?>
            <tr>
              <td width="10px"></td>
              <td width="10px"></td>
              <td colspan="3">
                <small> Skapad: <?php echo $char->created; ?>, ändrad: <?php echo $char->updated; ?></small>
              </td>
            </tr><?php
    }
  }
} ?>
    </tbody>
  </table><?php

if ($this->mergedrole->character_setstatus || $this->mergedrole->registration_setstatus ||
    $this->mergedrole->registration_setrole) { ?>
  <input type="submit" value="Spara ändringar" />
  <input type="hidden" name="option" value="com_lajvit" />
  <input type="hidden" name="task" value="save" />
  <input type="hidden" name="controller" value="registrations" />
  <input type="hidden" name="eid" value="<?php echo $this->eventid; ?>" />
  <input type="hidden" name="cid" value="<?php echo $this->characterlist; ?>" />
  <input type="hidden" name="Itemid" value="<?php echo $this->itemid; ?>" /><?php
} ?>

</form>

