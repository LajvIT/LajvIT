<?php

// No direct access
defined('_JEXEC') or die('Restricted access');

$personrow = array();
?>

<h1>Sökresultat - Karaktärer</h1>

<form action="index.php" method="post" enctype="multipart/form-data" name="registrationsDefaultForm">

	<h2>
	<? echo $this->event->name; ?>
		&nbsp;<a href="<? echo $this->event->url; ?>" title="Info"><img
			src="components/com_lajvit/info.png" alt="Info" /> </a>
	</h2>
	<?php
	$knownasSortOrder = $this->orderBy == 'knownas' && $this->sortOrder == 'ASC' ? 'DESC' : 'ASC';
	$cultureSortOrder = $this->orderBy == 'culture' && $this->sortOrder == 'ASC' ? 'DESC' : 'ASC';
	$conceptSortOrder = $this->orderBy == 'concept' && $this->sortOrder == 'ASC' ? 'DESC' : 'ASC';
	$personSortOrder = $this->orderBy == 'personname' && $this->sortOrder == 'ASC' ? 'DESC' : 'ASC';
	$createdSortOrder = $this->orderBy == 'created' && $this->sortOrder == 'ASC' ? 'DESC' : 'ASC';
	$updatedSortOrder = $this->orderBy == 'updated' && $this->sortOrder == 'ASC' ? 'DESC' : 'ASC';

	function getLink($event, $item, $orderBy, $sortOrder, $characterStatus, $confirmation) {
		$link = "index.php?option=com_lajvit&view=registrations";
		$link .= "&eid=" . $event;
		$link .= "&Itemid=" . $item;
		$link .= "&orderby=" . $orderBy;
		$link .= "&sortorder=" . $sortOrder;
		if ($characterStatus != NULL) { $link .= "&charstatus=" . $characterStatus; }
		if ($confirmation != NULL) { $link .= "&confirmation=" . $confirmation; }
		return $link;
	}
	?>

	<table>
		<tbody>
			<tr>
				<td colspan="5">Sortering: &nbsp;<a href="<?php echo getLink($this->event->id, $this->itemid, "knownas", $knownasSortOrder, null, null)?>"
					title="Karaktär">Karaktär</a> &nbsp;<a
					href="<?php echo getLink($this->event->id, $this->itemid, "culture", $cultureSortOrder, $this->characterStatus, $this->confirmation)?>" title="Kultur">Kultur</a> &nbsp;<a
					href="<?php echo getLink($this->event->id, $this->itemid, "concept", $conceptSortOrder, $this->characterStatus, $this->confirmation)?>" title="Koncept">Koncept</a> &nbsp;<a
					href="<?php echo getLink($this->event->id, $this->itemid, "personname", $personSortOrder, $this->characterStatus, $this->confirmation)?>" title="Spelare">Spelare</a> &nbsp;<a
					href="<?php echo getLink($this->event->id, $this->itemid, "created", $createdSortOrder, $this->characterStatus, $this->confirmation)?>" title="Skapad">Skapad</a> &nbsp;<a
					href="<?php echo getLink($this->event->id, $this->itemid, "updated", $updatedSortOrder, $this->characterStatus, $this->confirmation)?>" title="Ändrad">Ändrad</a>
				</td>
			</tr>
			<tr>
				<td colspan="5">Filtrering:&nbsp;<a
					href="<?php echo getLink($this->event->id, $this->itemid, $this->orderBy, $this->sortOrder, null, null)?>"
					title="Ingen">Ingen</a>
				</td>
			</tr>
			<tr>
				<td></td>
				<td colspan="4">
					Rollstatus:
					<?php
					foreach ($this->status as $status) { ?>
						<a href="<?php echo getLink($this->event->id, $this->itemid, $this->orderBy, $this->sortOrder, $status->id, $this->confirmation)?>" title="<?php echo $status->name?>"><?php echo $status->name?></a>
					<?php
					}
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td colspan="4">
					Betalning:
					<?php
					foreach ($this->confirmations as $confirmation) { ?>
						<a href="<?php echo getLink($this->event->id, $this->itemid, $this->orderBy, $this->sortOrder, $this->characterStatus, $confirmation->id)?>" title="<?php echo $confirmation->name?>"><?php echo $confirmation->name?></a>
					<?php
					}
					?>
				</td>
			</tr>
			<?  foreach ($this->factions as $faction) { ?>
			<tr>
				<td colspan="4">
					<h3>
					<? echo $faction->name; ?>
					</h3>
				</td>
				<td></td>
			</tr>
<?    foreach ($faction->characters as $char) { ?>
			<tr>
<?      if ($this->role->character_list) { ?>
				<td></td>
				<td colspan="3">
					<strong>
						<?php
						echo $char->knownas . " - " . $char->culturename . ", " . $char->conceptname;
						if (!is_null($char->concepttext) && strlen($char->concepttext) > 0) {
							echo " (" . $char->concepttext . ")";
						} ?>
					</strong> <?
					if (false) { ?>
					&nbsp; <a href="index.php?option=com_lajvit&view=character&eid=<? echo $this->event->id; ?>&cid=<? echo $char->id; ?>&Itemid=<? echo $this->itemid; ?>" title="Info"><img src="components/com_lajvit/info.png" alt="Info" /> </a>
<?         } ?>
<?          if (false) { ?>
					&nbsp; <a href="index.php?option=com_lajvit&view=character&layout=edit&eid=<? echo $this->event->id; ?>&cid=<? echo $char->id; ?>&Itemid=<? echo $this->itemid; ?>" title="Redigera karaktär"><img src="components/com_lajvit/edit.gif" alt="Redigera karaktär" /></a>
<?          } ?>
					&nbsp;<a href="index.php?option=com_lajvit&view=character&layout=delete&eid=<? echo $this->event->id; ?>&cid=<? echo $char->id; ?>&Itemid=<? echo $this->itemid; ?>&redirect=registrations" title="Ta bort karaktär"><img src="components/com_lajvit/delete.gif" alt="Ta bort karaktär" /></a>
				</td>
				<td>
<?        if ($this->role->character_setstatus) { ?>
					<select name="characterstatus_<? echo $char->id; ?>">
<?					foreach ($this->status as $status) { ?>
						<option value="<?echo $status->id; ?>"
<?          	if ($char->statusid == $status->id) { ?> selected="selected"
<?            } ?>>
<? 						echo $status->name; ?>
						</option>
<?                } ?>
				</select>
<?            } else { ?>
<?							echo $char->statusname; ?>
<?            } ?>
				</td>
			</tr>
<?    }
			if ($this->role->registration_list) { ?>
			<tr>
				<td></td>
				<td></td>
				<td>
<?          if (!$personrow[$char->personid]) { ?>
					<a name="person_<? echo $char->personid; ?>"></a>
<?          } ?>
					<input type="hidden" name="pid_<? echo $char->id; ?>" value="<? echo $char->personid; ?>" /> <? echo $char->personname; ?> - <? echo $char->pnumber; ?>
					&nbsp;<a href="index.php?option=com_lajvit&view=person&pid=<? echo $char->personid; ?>&eid=<? echo $this->event->id; ?>&Itemid=<? echo $this->itemid; ?>" title="Info"><img src="components/com_lajvit/info.png" alt="Info" /> </a>
				</td>
				<td>
<?          if ($this->role->registration_setrole) {
							if ($personrow[$char->personid]) { ?>
						<a href="#person_<? echo $char->personid; ?>"><? echo $char->rolename; ?></a>
<?            } else { ?>
<?							echo $char->rolename; ?>
<?            }
						} ?>
				</td>
				<td>
<?            if (!$this->role->registration_setstatus) { ?>
<?							echo $char->confirmationname; ?>
<?							echo $char->payment; ?>&nbsp;kr
<?            } else if ($personrow[$char->personid]) { ?>
					<a href="#person_<? echo $char->personid; ?>"><? echo $char->confirmationname; ?> </a> <? echo $char->payment; ?>&nbsp;kr
<?            } else { ?> <select name="confirmationid_<? echo $char->id; ?>">
<?                foreach ($this->confirmations as $confirmation) { ?>
						<option value="<?echo $confirmation->id; ?>"
<?                  if ($char->confirmationid == $confirmation->id) { ?> selected="selected"
<?                  } ?>>
<? echo $confirmation->name; ?>
						</option>
<?                } ?>
				</select>
				<input type="text" name="payment_<? echo $char->id; ?>" value="<? echo $char->payment; ?>" size="3">&nbsp;kr
<?            } ?>
				</td>
			</tr>
<?        $personrow[$char->personid] = true;
			}
			if ($this->role->character_list) { ?>
			<tr>
				<td width="10px"></td>
				<td width="10px"></td>
				<td colspan="4"><small> Skapad: <? echo $char->created; ?>, ändrad: <? echo $char->updated; ?> </small>
				</td>
			</tr>
<?      }
			}
		} ?>
		</tbody>
	</table>

<? if ($this->role->character_setstatus || $this->role->registration_setstatus || $this->role->registration_setrole) { ?>
	<input type="submit" value="Spara ändringar" />
	<input type="hidden" name="option" value="com_lajvit" />
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="controller" value="registrations" />
	<input type="hidden" name="eid" value="<? echo $this->eventid; ?>" />
	<input type="hidden" name="cid" value="<? echo $this->characterlist; ?>" />
	<input type="hidden" name="Itemid" value="<? echo $this->itemid; ?>" />
<? } ?>

</form>

