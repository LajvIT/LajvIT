<?php
 
// No direct access
 
defined('_JEXEC') or die('Restricted access'); ?>


	<h1>Mina Arrangemang
<?	if (false) { ?>
		&nbsp;<a href="event_new.html" title="Lägg till arrangemang"><img src="components/com_lajvit/new_organizer.gif" alt="Lägg till arrangemang"/></a>
<?	} ?>
	</h1>

<?	foreach ($this->events as $event) { ?>
		<h2><? echo $event->name; ?><a href="<? echo $event->url; ?>" title="Info"><img src="components/com_lajvit/info.gif" alt="Info"/></a>
<?		if (false) { ?>
			&nbsp;<a href="event_edit.html" title="Redigera arrangemang"><img src="components/com_lajvit/edit_organizer.gif" alt="Redigera arrangemang"/></a>
<?		} ?>
		</h2>
		<p>Start: <? echo $event->startdate; ?> Slut: <? echo $event->enddate; ?></p>
		
<?		if (!$event->registered) { ?>
<strong><p>Ej Registrerad.&nbsp<a href="index.php?option=com_lajvit&view=event&layout=register&eid=<? echo $event->id; ?>&Itemid=<? echo $this->itemid; ?>" title="Registrera"><img src="components/com_lajvit/new.gif" alt="Registrera"/></a></p></strong>
<?		} else { ?>
			<strong><p>
				Betalning: <? echo ($event->confirmed ? 'Godkänd' : 'Ej godkänd'); ?>
				(<? echo $event->payment; ?> kr)
			</p></strong>
			
<?			foreach ($event->characters as $char) { ?>
				<strong><p>
					<? echo $char->knownas; ?> - <? echo $char->statusdesc; ?>
<?					if (false) { ?>
						&nbsp;<a href="index.php?option=com_lajvit&view=character&eid=<? echo $event->id; ?>&cid=<? echo $char->id; ?>&Itemid=<? echo $this->itemid; ?>" title="Info"><img src="components/com_lajvit/info.gif" alt="Info"/></a>
<?					} ?>
					&nbsp;<a href="index.php?option=com_lajvit&view=character&layout=edit&eid=<? echo $event->id; ?>&cid=<? echo $char->id; ?>&Itemid=<? echo $this->itemid; ?>" title="Redigera karaktär"><img src="components/com_lajvit/edit.gif" alt="Redigera karaktär"/></a>
<?					if (false) { ?>					
						&nbsp;<a href="index.php?option=com_lajvit&view=character&layout=delete&eid=<? echo $event->id; ?>&cid=<? echo $char->id; ?>&Itemid=<? echo $this->itemid; ?>" title="Ta bort karaktär"><img src="components/com_lajvit/delete.gif" alt="Ta bort karaktär"/></a>
<?					} ?>
				</p></strong>
				<p>
					<? echo $char->culturename;?> - <? echo $char->conceptname; ?>
<?					if (!is_null($char->concepttext)) { ?>
						(<? echo $char->concepttext; ?>)
<?					} ?>
					</p>
<?			} ?>
	
			<strong><p>
				Lägg till karaktär
				&nbsp;<a href="index.php?option=com_lajvit&view=character&layout=create&eid=<? echo $event->id; ?>&Itemid=<? echo $this->itemid; ?>" title="Lägg till karaktär"><img src="components/com_lajvit/new.gif" alt="Lägg till karaktär"/></a>
			</p></strong>
<?		} ?>
<?	} ?>
