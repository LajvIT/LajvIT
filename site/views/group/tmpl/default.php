<?php
defined('_JEXEC') or die('Restricted access'); ?>

<?php
$user = JFactory::getUser();
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
  <table>
    <tbody>
      <tr>
        <td><strong>Namn:</strong></td>
        <td><?php echo $this->groupName; ?></td>
      </tr>
      <tr>
        <td><strong>Beskrivning:</strong></td>
        <td><?php echo $this->groupDescription; ?></td>
      </tr>
      <tr>
        <td><strong>Max antal medlemmar:</strong></td>
        <td><?php echo $this->groupMaxParticipants; ?></td>
      </tr>
      <tr>
        <td><strong>Förväntat antal deltagare:</strong></td>
        <td><?php echo $this->groupExpectedParticipants; ?></td>
      </tr>
      <tr>
        <td><strong>Information till arrangör:</strong></td>
        <td><?php echo $this->groupAdminInfo; ?></td>
      </tr>
      <tr>
        <td><strong>Hemsida:</strong></td>
        <td><?php echo $this->groupUrl; ?></td>
      </tr>
      <tr>
        <td><strong>Synlighet för alla deltagare:</strong></td>
        <td><?php echo $this->groupVisible ? "Synlig" : "Gömd"; ?></td>
      </tr>
      <tr>
        <td><strong>Fraktion:</strong></td>
        <td><?php echo $this->groupFactionName ?></td>
      </tr>
    </tbody>
  </table>
  <br /><?php
echo '  <table>    <tbody>';
echo '      <tr><td><strong style="float: left; margin-right: 5px;">' . 'Karaktärer</strong> ';
echo '<div class="icon new_character"><a class="icon" href="index.php?option=com_lajvit&view=group&layout=addchartogroup&groupId=' . $this->groupId . '" title="Lägg till karaktär"></a></div>';
echo '</td></tr>';
if (isset($this->charactersInGroup)) {
  foreach ($this->charactersInGroup as $character) {
    echo '<tr><td>';
    echo '<div class="text">';
    echo $character->knownas . " - " . $character->cultureName . ", " . $character->conceptName;
    echo '</div>';
    echo '<div class="icon info"><a class="icon" ';
    echo 'href="index.php?option=com_lajvit&view=character&eid=' . $this->eventId;
    echo '&cid=' . $character->id . '&Itemid=' . $this->itemId .'" title="Info"></a></div>';

    if ($this->lajvitModel->isCharacterOwnedByPerson($character->id, $user->id)) {
      echo '<div class="icon delete_character"><a class="icon" ';
      echo 'href="index.php?option=com_lajvit&controller=group&task=removeCharacterFromGroup';
      echo '&groupId=' . $this->groupId . '&characterId=' . $character->id;
      echo '&Itemid=' . $this->itemId . '"></a></div>';
    }
  }
}
echo '</td></tr>';
echo '    </tbody>  </table>';
?>