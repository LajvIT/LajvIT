<?php
defined('_JEXEC') or die('Restricted access'); ?>

<h1>
  Redigera grupp
</h1>
<?php
$groupStatuses = Array('created','approved','rejected','open','closed');
if (isset($this->errorMsg)) { echo $this->errorMsg . "<br><br>"; }
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
            <option value="0" <?php echo $this->groupVisible == 0 ? "selected": "";?>>Gömd</option>
            <option value="1" <?php echo $this->groupVisible == 1 ? "selected": "";?>>Synlig</option>
          </select>
        </td>
      </tr>
      <tr>
        <td><strong>Gruppstatus:</strong></td>
        <td>
          <select name="groupStatus"><?php
foreach ($groupStatuses as $status) {
  echo '<option value="' . $status . '"';
  if ($this->groupStatus == $status) {
    echo 'selected="selected"';
  }
  echo ' >' . ucfirst($status) . '</option>\n';
}?>
        </select>
        </td>
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
echo '      <tr><td><strong>' . 'Karaktärer<strong> ';
echo '<a href="index.php?option=com_lajvit&view=group&layout=addchartogroup&eid=' . $this->eventId . '&groupId=' . $this->groupId . '">Lägg till karaktär</a>';
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
