<?php
defined('_JEXEC') or die('Restricted access'); ?>

<h1>
  Mina Arrangemang
<?php if (TRUE) { ?>
  &nbsp;<a href="index.php?option=com_lajvit&view=event&Itemid=<?php echo $this->itemid; ?>&layout=add" title="Lägg till arrangemang"><img
    src="components/com_lajvit/new_organizer.gif" alt="Lägg till arrangemang" /> </a>
  <?php
}
  ?>
</h1>

<?php
foreach ($this->events as $event) {
  if ($event->status != 'open' && $this->userType != 'Super Administrator') {
    continue;
  }?>
  <h2><?php echo $event->name; ?>&nbsp;<a href="<?php echo $event->url; ?>" title="Info"><img
    src="components/com_lajvit/info.png" alt="Info"/></a>
  <?php
  if ($event->role->registration_list || $event->role->character_list) { ?>
    &nbsp;<a href="index.php?option=com_lajvit&view=registrations&eid=<?php echo $event->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Lista kända karaktärer"><img
      src="components/com_lajvit/list.png" alt="Lista kända karaktärer"/></a><?php
  }
  if ($this->userType == "Super Administrator") { ?>
      &nbsp;<a href="index.php?option=com_lajvit&view=event&layout=delete&eid=<?php echo $event->id; ?>&Itemid=<?php echo $this->itemid; ?>"
        title="Radera arrangemang"><img src="components/com_lajvit/delete_organizer.gif"
        alt="Radera arrangemang"/></a><?php
  }
  if ($this->userType == 'Super Administrator') { ?>
      &nbsp;<a href="index.php?option=com_lajvit&view=event&layout=edit&eid=<?php echo $event->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Redigera arrangemang"><img src="components/com_lajvit/edit_organizer.gif" alt="Redigera arrangemang"/></a><?php
  } ?>
  </h2>
  <p>Start: <?php echo $event->startdate; ?> Slut: <?php echo $event->enddate; ?></p>

  <?php
  if (!$event->registered) { ?>
    <p><strong>Ej Registrerad.&nbsp;<a href="index.php?option=com_lajvit&view=event&layout=register&eid=<?php echo $event->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Registrera"><img src="components/com_lajvit/new_character.png" alt="Registrera"/></a></strong></p><?php
  } else { ?>
    <p><strong>Betalning: <?php
    echo $event->confirmationname;
    echo '(' . $event->payment . ' kr)'; ?></strong></p><?php
    foreach ($event->characters as $char) { ?>
      <p><strong><?php
      echo $char->knownas . ' - ' . $char->statusname;
      if (FALSE) { ?>
        &nbsp;<a href="index.php?option=com_lajvit&view=character&eid=<?php echo $event->id; ?>&cid=<?php echo $char->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Info"><img src="components/com_lajvit/info.png" alt="Info"/></a><?php
      } ?>
      &nbsp;<a href="index.php?option=com_lajvit&view=character&layout=edit&eid=<?php echo $event->id; ?>&cid=<?php echo $char->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Redigera karaktär"><img src="components/com_lajvit/edit_character.png" alt="Redigera karaktär"/></a>
      &nbsp;<a href="index.php?option=com_lajvit&view=character&layout=delete&eid=<?php echo $event->id; ?>&cid=<?php echo $char->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Ta bort karaktär"><img src="components/com_lajvit/delete_character.png" alt="Ta bort karaktär"/></a>
      &nbsp;<a href="index.php?option=com_lajvit&view=plot&layout=listdistributedplots&eid=<?php echo $event->id; ?>&cid=<?php echo $char->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Intriger för karaktär"><img src="components/com_lajvit/plot.png" alt="Intriger för karaktär"/></a>
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
        &nbsp;<a href="index.php?option=com_lajvit&view=character&layout=create&eid=<?php echo $event->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Lägg till karaktär"><img src="components/com_lajvit/new_character.png" alt="Lägg till karaktär"/></a>
      </strong></p><?php
  }
} ?>
