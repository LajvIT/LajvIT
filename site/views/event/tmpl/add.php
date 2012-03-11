<?php
defined('_JEXEC') or die('Restricted access'); ?>

<h1>
  Lägg till arrangemang
</h1>

<form action="index.php" method="post" name="eventAddForm">
  <table>
    <tbody>
      <tr>
        <td><strong>Namn:</strong></td>
        <td><input type="text" name="eventName" value="" size="40"></td>
      </tr>
      <tr>
        <td><strong>Kort namn:</strong></td>
        <td><input type="text" name="eventShortName" value="" size="40"></td>
      </tr>
      <tr>
        <td><strong>Startdatum:</strong></td>
        <td><input type="text" name="eventStartDate" value="" size="40"></td>
      </tr>
      <tr>
        <td><strong>Slutdatum:</strong></td>
        <td><input type="text" name="eventEndDate" value="" size="40"></td>
      </tr>
      <tr>
        <td><strong>Hemsida:</strong></td>
        <td><input type="text" name="eventUrl" value="" size="40"></td>
      </tr>
      <tr>
        <td><strong>Status:</strong></td>
        <td><select name="eventStatus">
            <option value="0" selected="selected">Created</option>
            <option value="34">Open</option>
            <option value="2">Closed</option>
            <option value="3">Hidden</option>
        </select>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <input type="submit" value="Lägg till arrangemang" />
          <input type="hidden" name="option" value="com_lajvit" />
          <input type="hidden" name="task" value="add" />
          <input type="hidden" name="controller" value="event" />
          <input type="hidden" name="Itemid" value="<?php echo $this->itemId; ?>" />
        </td>
      </tr>
    </tbody>
  </table>
</form>
