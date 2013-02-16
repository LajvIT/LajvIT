<?php
defined('_JEXEC') or die('Restricted access'); ?>

<?php
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
    </tbody>
  </table>
