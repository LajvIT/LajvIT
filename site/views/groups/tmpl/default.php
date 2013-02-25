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
  if ($item->visible == 1) {
    if ($canDo->get('core.edit') ||
        $canDo->get('core.edit.own') && $item->groupLeaderPersonId == $user->id) {

    } elseif ($canDo->get('lajvit.view.visible') && $item->status != 'open') {
      continue;
    } elseif ($canDo->get('lajvit.view.visible')) {

    } else {
      continue;
    }
  }
  if ($item->visible == 0 &&
      (!$canDo->get('lajvit.view.hidden') &&
          !($canDo->get('core.edit.own') &&
              $item->groupLeaderPersonId == $user->id))) {
    continue;
  }
  if (!$canDo->get('core.edit') &&
      !$this->groupModel->hasPersonApprovedCharacterInSameFaction($user, $item->id)) {
    continue;
  }
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
      <?php
//       <div class="icon delete_group"><a class="icon" href="index.php?option=com_lajvit&view=group&layout=delete" title="Ta bort grupp"></a></div>
  }
      ?>
      <div class="icon new_character"><a class="icon" href="index.php?option=com_lajvit&view=group&layout=addchartogroup&groupId=<?php echo $item->id; ?>" title="Lägg till karaktär"></a></div>
    </div>
    <div class="container">
      <div class="text">Gruppledare: <?php echo $item->groupLeaderPersonName;?></div>
      <div class="text">Max: <?php echo $item->maxParticipants; ?></div>
      <div class="text">Förväntat: <?php echo $item->expectedParticipants; ?></div>
    </div>
    <div class="container">
      <div class="text"><?php echo $item->url; ?></div>
    </div>
    <div class="container">
      <div class="text"><?php echo $item->description; ?></div>
    </div><?php
  if ($canDo->get('core.edit') ||
      $canDo->get('core.edit.own') && $item->groupLeaderPersonId == $user->id) { ?>
    <div class="container">
      <div class="text">Synlig: <?php echo $item->visible ? 'Ja' : 'Nej'; ?></div>
      <div class="text">Status: <?php echo $item->status; ?></div>
    </div><?php
  }
  ?>
  <!--
    <div class="container">
      <div class="infoText">View:</div><div class="text"><?php echo $user->authorise('lajvit.view.visible', $assetName); ?></div>
      <div class="infoText">View hidden:</div><div class="text"><?php echo $user->authorise('lajvit.view.hidden', $assetName); ?></div>
      <div class="infoText">Create:</div><div class="text"><?php echo $user->authorise('core.create', $assetName); ?></div>
      <div class="infoText">Edit:</div><div class="text"><?php echo $user->authorise('core.edit', $assetName); ?></div>
      <div class="infoText">Edit own:</div><div class="text"><?php echo $user->authorise('core.edit.own', $assetName); ?></div>
    </div>
     -->
  </div>
<?php } ?>
<input type="hidden" name="Itemid" value="<?php echo $this->itemId; ?>" />