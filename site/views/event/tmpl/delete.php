<?php
defined('_JEXEC') or die('Restricted access'); ?>

<h1>
  Ta bort arrangemang
</h1>

<form action="index.php" method="post" name="eventDeleteForm">
  <table>
    <tbody>
      <tr>
        <td><strong>Detta kommer ta bort arrangemanget</strong></td>
      </tr>
      <tr>
        <td>
          <input type="submit" value="Bekräfta borttagning" />
          <input type="hidden" name="option" value="com_lajvit" />
          <input type="hidden" name="task" value="delete" />
          <input type="hidden" name="controller" value="event" />
          <input type="hidden" name="confirmed" value="true" />
          <input type="hidden" name="eid" value="<?php echo $this->eventId; ?>" />
          <input type="hidden" name="Itemid" value="<?php echo $this->itemId; ?>" />
        </td>
      </tr>
    </tbody>
  </table>
</form>