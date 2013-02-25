<?php
defined('_JEXEC') or die('Restricted access'); ?>

<h1>
  Redigera grupp
</h1>
<?php
$groupStatusesAll = Array('created','approved','rejected','open','closed');
$groupStatusesCreated = Array('created');
$groupStatusesAccepted = Array('open','closed');
$groupStatusesRejected = Array('rejected');
$canDo = GroupHelper::getActions($this->groupId);
if (isset($this->errorMsg) && $this->errorMsg != '') {
  echo '<div style="color: red; font-weight: bold;">' . JText::_($this->errorMsg) . '</div><br><br>';
}
if (isset($this->message) && $this->message != '') {
  if (isset($this->character)) {
    echo JText::_($this->message) . ": " . $this->character;
  } else {
    echo JText::_($this->message);
  }
  echo "<br><br>";
}

?>
<form action="index.php" method="post" name="groupCreateForm">
  <table>
    <tbody>
      <tr>
        <td><strong>Namn:</strong></td>
        <td><input type="text" name="groupName" value="<?php echo $this->groupName; ?>" size="40"></td>
      </tr>
      <tr>
        <td><strong>Beskrivning:</strong></td>
        <td><textArea name="groupDescription" cols="40" rows="5" ><?php echo $this->groupDescription; ?></textArea></td>
      </tr>
      <tr>
        <td><strong>Max antal medlemmar:</strong></td>
        <td><input type="text" name="groupMaxParticipants" value="<?php echo $this->groupMaxParticipants; ?>" size="3"></td>
      </tr>
      <tr>
        <td><strong>Förväntat antal deltagare:</strong></td>
        <td><input type="text" name="groupExpectedParticipants" value="<?php echo $this->groupExpectedParticipants; ?>" size="3"></td>
      </tr>
      <tr>
        <td><strong>Information till arrangör:</strong></td>
        <td><textArea name="groupAdminInfo" cols="40" rows="5" ><?php echo $this->groupAdminInfo; ?></textArea></td>
      </tr>
      <tr>
        <td><strong>Hemsida:</strong></td>
        <td><input type="text" name="groupUrl" value="<?php echo $this->groupUrl; ?>" size="40"></td>
      </tr>
      <tr>
        <td><strong>Synlighet för alla deltagare:</strong></td>
        <td>
          <select name="groupVisible">
            <option value="0" <?php echo $this->groupVisible == 0 ? "selected": "";?>>Gömd</option><?php
  if ($this->groupStatus == 'open') { ?>
            <option value="1" <?php echo $this->groupVisible == 1 ? "selected": "";?>>Synlig</option><?php
  } ?>
          </select>
        </td>
      </tr>
      <tr>
        <td><strong>Gruppstatus:</strong></td>
        <td>
          <select name="groupStatus"><?php
  if (!$canDo->get('core.edit')) {
    if ($this->groupStatus == 'created') {
      $groupStatuses = $groupStatusesCreated;
    } elseif ($this->groupStatus != 'created' && $this->groupStatus != 'rejected') {
      $groupStatuses = $groupStatusesAccepted;
    } else {
      $groupStatuses = $groupStatusesRejected;
    }
  } else {
    $groupStatuses = $groupStatusesAll;
  }
  foreach ($groupStatuses as $status) {
    echo '<option value="' . $status . '"';
    if ($this->groupStatus == $status) {
      echo ' selected';
    }
    echo ' >' . ucfirst($status) . '</option>\n';
  }
?>
        </select>
        </td>
      </tr>
      <tr>
        <td><strong>Fraktion:</strong></td>
        <td><select name="groupFaction"><?php
  foreach ($this->factions as $faction) {
    echo '<option value="' . $faction->id . '"';
    if ($this->groupFaction == $faction->id) {
      echo ' selected';
    }
    echo ' >' . ucfirst($faction->name) . '</option>\n';
  }
?>
          </select></td>
      </tr>
      <tr>
        <td><strong>Gruppledare:</strong></td>
        <td><?php echo $this->groupLeaderPersonName; ?></td>
      </tr>
    </tbody>
  </table>
  <input type="submit" value="Spara grupp" />
  <input type="hidden" name="option" value="com_lajvit" />
  <input type="hidden" name="task" value="edit" />
  <input type="hidden" name="controller" value="group" />
  <input type="hidden" name="eventId" value="<?php echo $this->eventId; ?>" />
  <input type="hidden" name="groupId" value="<?php echo $this->groupId; ?>" />
  <input type="hidden" name="groupLeaderPersonId" value="<?php echo $this->groupLeaderPersonId; ?>" />
  <input type="hidden" name="Itemid" value="<?php echo $this->itemId; ?>" />
  <br/><br/>
      <?php
echo '  <table>    <tbody>';
echo '      <tr><td><strong style="float: left; margin-right: 5px;">' . 'Karaktärer</strong> ';
echo '<div class="icon new_character"><a class="icon" href="index.php?option=com_lajvit&view=group&layout=addchartogroup&groupId=' . $this->groupId . '" title="Lägg till karaktär"></a></div>';
echo '</td></tr>';
if (isset($this->charactersInGroup)) {
  foreach ($this->charactersInGroup as $character) {
    echo '<tr><td>';
    echo $character->knownas;
  }
}
echo '</td></tr>';
echo '    </tbody>  </table>';
?>

</form>
