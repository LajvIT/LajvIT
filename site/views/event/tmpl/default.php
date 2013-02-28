<?php
defined('_JEXEC') or die('Restricted access'); ?>

<h1>
  Mina Arrangemang
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
  <div class="event">
    <div class="group">
      <div class="container">
        <div class="eventName"><?php echo $event->name; ?></div>
        <div class="icon info">
          <a href="<?php echo $event->url; ?>" title="Info"></a>
        </div>
  <?php
  if ($allowedToListRegistrations || $allowedToListCharacters) { ?>
        <div class="icon list">
          <a class="icon" href="index.php?option=com_lajvit&view=registrations&eid=<?php echo $event->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Anmälningar">
          </a>
        </div><?php
  }
  if ($this->userType == "Super Administrator" || $allowedToDeleteEvent) { ?>
        <div class="icon delete_organizer">
          <a class="icon" href="index.php?option=com_lajvit&view=event&layout=delete&eid=<?php echo $event->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Radera arrangemang">
          </a>
        </div>
      <?php
  }
  if ($allowedToEditEvent) { ?>
        <div class="icon edit_organizer">
          <a class="icon" href="index.php?option=com_lajvit&view=event&layout=edit&eid=<?php echo $event->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Redigera arrangemang">
          </a>
        </div><?php
  } ?>
      </div>
    </div>

    <div class="group">
      <div class="eventDuration">Start: <?php echo $event->startdate; ?> Slut: <?php echo $event->enddate; ?></div>
    </div>

  <?php
  if (!$event->registered && $isEventOpen) { ?>
    <div class="group">
      <div class="container">
        <div class="infoText">Ej Registrerad</div>
        <div class="icon new_character"><a class="icon" href="index.php?option=com_lajvit&view=event&layout=register&eid=<?php echo $event->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Registrera"></a></div>
      </div>
    </div>
    <?php
  } else if ($isEventOpen) { ?>
    <div class="group">
      <div class="infoText" style="margin-bottom: 10px">Betalning: <?php
    echo $event->confirmationname;
    echo '(' . $event->payment . ' kr)'; ?>
      </div>
    </div><?php
    foreach ($event->characters as $char) { ?>
      <div class="group">
      <div class="container">
        <div class="infoText"><?php
      echo $char->knownas . ' - ' . $char->statusname; ?>
        </div>
        <div class="icon edit_character"><a class="icon" href="index.php?option=com_lajvit&view=character&layout=edit&eid=<?php echo $event->id; ?>&cid=<?php echo $char->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Redigera karaktär"></a></div>
        <div class="icon delete_character"><a class="icon" href="index.php?option=com_lajvit&view=character&layout=delete&eid=<?php echo $event->id; ?>&cid=<?php echo $char->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Ta bort karaktär"></a></div>
        <div class="icon plot"><a class="icon" href="index.php?option=com_lajvit&view=plot&layout=listdistributedplots&eid=<?php echo $event->id; ?>&cid=<?php echo $char->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Intriger för karaktär"></a></div>
      </div>
      <div class="eventCharacterDetails"><?php
      echo $char->culturename . ' - ' . $char->conceptname;
      if (!is_null($char->concepttext)) {
        echo '(' .$char->concepttext . ')';
      } ?>
      </div>
      </div><?php
    } ?>

    <div class="group">
      <div class="container">
        <div class="infoText">Lägg till karaktär</div>
        <a class="icon" href="index.php?option=com_lajvit&view=character&layout=create&eid=<?php echo $event->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Lägg till karaktär"><img src="media/com_lajvit/images/new_character.png" alt="Lägg till karaktär"/></a>
      </div>
    </div>
    <div class="group">
      <div class="container">
        <div class="infoText">Grupper</div>
        <div class="icon show_group"><a class="icon" href="index.php?option=com_lajvit&view=groups&eid=<?php echo $event->id; ?>&Itemid=<?php echo $this->itemid; ?>" title="Visa grupper"></a></div>
      </div>
    </div>
  <?php
  } ?>
  </div><?php
} ?>

