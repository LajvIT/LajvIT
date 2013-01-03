<?php
defined('_JEXEC') or die('Restricted access'); ?>

<h1>
  Grupper
</h1>

<?php
foreach ($this->items as $item) { ?>
  <div class="group">
    <div class="container">
      <div class="infoText">
        <a href="index.php/component/lajvit/?view=group&groupId=<?php echo $item->id?>">
        <?php echo $item->name; ?></a>
      </div>
    </div>
    <div class="container">
      <div class="text">Gruppledare: <?php echo $item->groupLeaderPersonId; ?></div>
      <div class="text">Max: <?php echo $item->maxParticipants; ?></div>
      <div class="text">Förväntat: <?php echo $item->expectedParticipants; ?></div>
      <div class="text">Synlig: <?php echo $item->visible; ?></div>
      <div class="text">Status: <?php echo $item->status; ?></div>
    </div>
    <div class="container">
      <div class="text"><?php echo $item->url; ?></div>
    </div>
    <div class="container">
      <div class="text"><?php echo $item->description; ?></div>
    </div>
  </div>
<?php } ?>