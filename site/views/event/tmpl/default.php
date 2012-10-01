<?php
defined('_JEXEC') or die('Restricted access'); ?>

<h1>
  Mina Arrangemang
<?php if ($this->userType == 'Super Administrator') { ?>
  &nbsp;<a href="index.php?option=com_lajvit&view=event&Itemid=<?php echo $this->itemid; ?>&layout=add" title="Lägg till arrangemang"><img
    src="media/com_lajvit/images/new_organizer.gif" alt="Lägg till arrangemang" /> </a>
  <?php
}
  ?>
</h1>

<?php


foreach ($this->events as $event) {
  $isEventOpen = ($event->status == 'open' ? TRUE : FALSE);
  $isEventHidden = ($event->status == 'hidden' ? TRUE : FALSE);
  $allowedToListRegistrations = FALSE;
  $allowedToListCharacters = FALSE;
  $allowedToEditEvent = FALSE;
  $allowedToDeleteEvent = FALSE;
  if (isset($event->role) && is_object($event->role)) {
    $allowedToListRegistrations = ($event->role->registration_list == 1 ? TRUE : FALSE);
    $allowedToListCharacters = ($event->role->character_list == 1 ? TRUE : FALSE);
    $allowedToEditEvent = ($event->role->event_edit == 1 ? TRUE : FALSE);
    $allowedToDeleteEvent = ($event->role->event_delete == 1 ? TRUE : FALSE);
  }

  if ($isEventHidden && $this->userType != 'Super Administrator') {
    continue;
  }?>
  <h2><?php echo $event->name; ?>&nbsp;<a href="<?php echo $event->url; ?>" title="Info"><img
    src="media/com_lajvit/images/info.png" alt="Info"/></a>
  <?php
  if ($allowedToListRegistrations || $allowedToListCharacters) { ?>
    &nbsp;<a href="index.php?option=com_lajvit&view=registrations&eid=<?php echo $event->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Anmälningar"><img
      src="media/com_lajvit/images/list.png" alt="Anmälningar"/></a><?php
  }
  if ($this->userType == "Super Administrator" || $allowedToDeleteEvent) { ?>
      &nbsp;<a href="index.php?option=com_lajvit&view=event&layout=delete&eid=<?php echo $event->id; ?>&Itemid=<?php echo $this->itemid; ?>"
        title="Radera arrangemang"><img src="media/com_lajvit/images/delete_organizer.gif"
        alt="Radera arrangemang"/></a><?php
  }
  if ($allowedToEditEvent) { ?>
      &nbsp;<a href="index.php?option=com_lajvit&view=event&layout=edit&eid=<?php echo $event->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Redigera arrangemang"><img src="media/com_lajvit/images/edit_organizer.gif" alt="Redigera arrangemang"/></a><?php
  } ?>
  </h2>
  <p>Start: <?php echo $event->startdate; ?> Slut: <?php echo $event->enddate; ?></p>

  <?php
  if (!$event->registered && $isEventOpen) { ?>
    <p><strong>Ej Registrerad.&nbsp;<a href="index.php?option=com_lajvit&view=event&layout=register&eid=<?php echo $event->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Registrera"><img src="media/com_lajvit/images/new_character.png" alt="Registrera"/></a></strong></p><?php
  } else if ($isEventOpen) { ?>
    <p><strong>Betalning: <?php
    echo $event->confirmationname;
    echo '(' . $event->payment . ' kr)'; ?></strong></p><?php
    foreach ($event->characters as $char) { ?>
      <p><strong><?php
      echo $char->knownas . ' - ' . $char->statusname;
      if (FALSE) { ?>
        &nbsp;<a href="index.php?option=com_lajvit&view=character&eid=<?php echo $event->id; ?>&cid=<?php echo $char->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Info"><img src="media/com_lajvit/images/info.png" alt="Info"/></a><?php
      } ?>
      &nbsp;<a href="index.php?option=com_lajvit&view=character&layout=edit&eid=<?php echo $event->id; ?>&cid=<?php echo $char->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Redigera karaktär"><img src="media/com_lajvit/images/edit_character.png" alt="Redigera karaktär"/></a>
      &nbsp;<a href="index.php?option=com_lajvit&view=character&layout=delete&eid=<?php echo $event->id; ?>&cid=<?php echo $char->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Ta bort karaktär"><img src="media/com_lajvit/images/delete_character.png" alt="Ta bort karaktär"/></a>
      &nbsp;<a href="index.php?option=com_lajvit&view=plot&layout=listdistributedplots&eid=<?php echo $event->id; ?>&cid=<?php echo $char->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Intriger för karaktär"><img src="media/com_lajvit/images/plot.png" alt="Intriger för karaktär"/></a>
      </strong></p>
      <p><?php
      echo $char->culturename . ' - ' . $char->conceptname;
      if (!is_null($char->concepttext)) {
        echo '(' .$char->concepttext . ')';
      } ?>
      </p><?php
    } ?>

      <p><strong>
        Lägg till karaktär
        &nbsp;<a href="index.php?option=com_lajvit&view=character&layout=create&eid=<?php echo $event->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Lägg till karaktär"><img src="media/com_lajvit/images/new_character.png" alt="Lägg till karaktär"/></a>
      </strong></p><?php
  }
} ?>
