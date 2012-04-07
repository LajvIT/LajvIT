<?php
defined('_JEXEC') or die('Restricted access'); ?>

<h1>
  Lägg till arrangemang
</h1>
<?php
$eventStatuses = Array('created', 'open', 'closed', 'hidden');
?>
<form action="index.php" method="post" name="eventAddForm">
  <table>
    <tbody>
      <tr>
        <td><strong>Namn:</strong></td>
        <td><input type="text" name="eventName" value="<?php echo $this->eventName; ?>" size="40"></td>
      </tr>
      <tr>
        <td><strong>Kort namn:</strong></td>
        <td><input type="text" name="eventShortName" value="<?php echo $this->eventShortName; ?>" size="40"></td>
      </tr>
      <tr>
        <td><strong>Startdatum:</strong></td>
        <td><input type="text" name="eventStartDate" value="<?php echo $this->eventStartDate; ?>" size="40"></td>
      </tr>
      <tr>
        <td><strong>Slutdatum:</strong></td>
        <td><input type="text" name="eventEndDate" value="<?php echo $this->eventEndDate; ?>" size="40"></td>
      </tr>
      <tr>
        <td><strong>Hemsida:</strong></td>
        <td><input type="text" name="eventUrl" value="<?php echo $this->eventUrl; ?>" size="40"></td>
      </tr>
      <tr>
        <td><strong>Status:</strong></td>
        <td><select name="eventStatus"><?php
foreach ($eventStatuses as $status) {
  echo '<option value="' . $status . '"';
  if ($this->eventStatus == $status) {
    echo 'selected="selected"';
  }
  echo ' >' . ucfirst($status) . '</option>\n';
}?>
        </select>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <input type="submit" value="Spara arrangemang" />
          <input type="hidden" name="option" value="com_lajvit" />
          <input type="hidden" name="task" value="edit" />
          <input type="hidden" name="controller" value="event" />
          <input type="hidden" name="eventId" value="<?php echo $this->eventId; ?>" />
          <input type="hidden" name="Itemid" value="<?php echo $this->itemId; ?>" />
        </td>
      </tr>
    </tbody>
  </table>
</form>
