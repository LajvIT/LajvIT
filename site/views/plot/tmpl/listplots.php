<?php

// No direct access
defined('_JEXEC') or die('Restricted access');
?>
<?php
$plotheadSortOrder = $this->orderBy == 'heading' && $this->sortOrder == 'ASC' ? 'DESC' : 'ASC';
$statusSortOrder = $this->orderBy == 'statusname' && $this->sortOrder == 'ASC' ? 'DESC' : 'ASC';
$creatorSortOrder = $this->orderBy == 'plotCreatorName' && $this->sortOrder == 'ASC' ? 'DESC' : 'ASC';
$createdSortOrder = $this->orderBy == 'created' && $this->sortOrder == 'ASC' ? 'DESC' : 'ASC';
$updatedSortOrder = $this->orderBy == 'updated' && $this->sortOrder == 'ASC' ? 'DESC' : 'ASC';

function getLink($event, $item, $orderBy, $sortOrder, $characterStatus, $confirmation, $page, $faction) {
	$link = "index.php?option=com_lajvit&view=plot&layout=listplots";
	$link .= "&eid=" . $event;
	$link .= "&Itemid=" . $item;
	$link .= "&orderBy=" . $orderBy;
	$link .= "&sortOrder=" . $sortOrder;
	return $link;
}
?>

<h1>Intriger</h1>

<table>
	<thead style="text-aling: left;">
		<tr>
			<th><a href="<?php echo getLink($this->eventId, $this->itemId, "heading", $plotheadSortOrder)?>" title="Metarubrik">Metarubrik</a></th>
			<th><a href="<?php echo getLink($this->eventId, $this->itemId, "statusname", $statusSortOrder)?>" title="Status">Status</a></th>
			<th><a href="<?php echo getLink($this->eventId, $this->itemId, "plotCreatorName", $creatorSortOrder)?>" title="Skapad av">Skapad av</a></th>
			<th><a href="<?php echo getLink($this->eventId, $this->itemId, "created", $createdSortOrder)?>" title="Skapad">Skapad</a></th>
			<th><a href="<?php echo getLink($this->eventId, $this->itemId, "updated", $updatedSortOrder)?>" title="Uppdaterad">Uppdaterad</a></th>
		</tr>
	</thead>
	<tbody style="vertical-align: top;">

<?php
			foreach ($this->plots as $plot) {
				if ($this->debug) { print_r($plot); echo "setstatus:".$this->mergedrole->character_setstatus . ",creator:". $plot->creatorpersonid .",person:" .$this->person->id ; }
				if ($this->mergedrole->character_setstatus || $plot->creatorpersonid == $this->person->id ) {
				?>
		<tr>
			<td>
				<a href="index.php?option=com_lajvit&view=plot&layout=editplot&eid=<?php echo $this->eventId; ?>&pid=<?php echo $plot->id; ?>&Itemid=<?php echo $this->itemId; ?>">
					<?php echo $plot->heading;?>
				</a>
			</td>
			<td><?php echo $plot->statusname; ?></td>
			<td><?php echo $plot->plotCreatorName; ?></td>
			<td><?php echo $plot->created; ?></td>
			<td><?php echo $plot->updated; ?></td>
		</tr>
		<tr>
			<td colspan="5" style="padding-left: 20px; padding-bottom: 15px;"><?php echo nl2br($plot->description); ?></td>
		</tr>
<?php 	}
			} ?>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td colspan="2">
			<a href="index.php?option=com_lajvit&view=plot&layout=editplot&eid=<?php echo $this->eventId; ?>&Itemid=<?php echo $this->itemId; ?>">
					Lägg till ny intrig
				</a>
		</td></tr>

	</tbody>
</table>

