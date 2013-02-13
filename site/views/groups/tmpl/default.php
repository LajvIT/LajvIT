<?php
defined('_JEXEC') or die('Restricted access'); ?>

<h1>
  Grupper
</h1>

<?php
$user = JFactory::getUser();
foreach ($this->items as $item) {
$assetName = "com_lajvit.group." . $item->id;
$canDo = GroupHelper::getActions($item->id);
?>
  <div class="group">
    <div class="container">
      <div class="infoText">
        <a href="index.php/component/lajvit/?view=group&groupId=<?php echo $item->id?>">
        <?php echo $item->name; ?></a>
      </div><?php
  if ($canDo->get('core.edit') ||
      $canDo->get('core.edit.own') && $item->groupLeaderPersonId == $user->id) { ?>
      <div class="icon edit_group"><a class="icon" href="index.php?option=com_lajvit&view=group&layout=edit&groupId=<?php echo $item->id; ?>" title="Redigera grupp"></a></div>
      <div class="icon delete_group"><a class="icon" href="index.php?option=com_lajvit&view=group&layout=delete" title="Ta bort grupp"></a></div>
      <?php
  }
      ?>
    </div>
    <div class="container">
      <div class="text">Gruppledare: <?php echo $item->groupLeaderPersonName;?></div>
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
    <div class="container">
      <div class="infoText">View:</div><div class="text"><?php echo $user->authorise('lajvit.view.visible', $assetName); ?></div>
      <div class="infoText">View hidden:</div><div class="text"><?php echo $user->authorise('lajvit.view.hidden', $assetName); ?></div>
      <div class="infoText">Create:</div><div class="text"><?php echo $user->authorise('core.create', $assetName); ?></div>
      <div class="infoText">Edit:</div><div class="text"><?php echo $user->authorise('core.edit', $assetName); ?></div>
      <div class="infoText">Edit own:</div><div class="text"><?php echo $user->authorise('core.edit.own', $assetName); ?></div>
    </div>
  </div>
<?php } ?>