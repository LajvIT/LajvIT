<?php
defined('_JEXEC') or die('Restricted access'); ?>

<h1>
  Skapa grupp
</h1>

<form action="index.php" method="post" name="groupCreateForm">
  <table>
    <tbody>
      <tr>
        <td><strong>Namn:</strong></td>
        <td><input type="text" name="groupName" value="" size="40"></td>
      </tr>
      <tr>
        <td><strong>Beskrivning:</strong></td>
        <td><textArea name="groupDescription" cols="40" rows="5" ></textArea></td>
      </tr>
      <tr>
        <td><strong>Max antal medlemmar:</strong></td>
        <td><input type="text" name="groupMaxParticipants" value="" size="3"></td>
      </tr>
      <tr>
        <td><strong>Förväntat antal deltagare:</strong></td>
        <td><input type="text" name="groupExpectedParticipants" value="" size="3"></td>
      </tr>
      <tr>
        <td><strong>Information till arrangör:</strong></td>
        <td><textArea name="groupAdminInfo" cols="40" rows="5" ></textArea></td>
      </tr>
      <tr>
        <td><strong>Hemsida:</strong></td>
        <td><input type="text" name="groupUrl" value="" size="40"></td>
      </tr>
      <tr>
        <td><strong>Synlighet för alla deltagare:</strong></td>
        <td>
          <select name="groupVisible">
            <option value="0">Gömd</option>
            <option value="1">Synlig</option>
          </select>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <input type="submit" value="Skapa grupp" />
          <input type="hidden" name="option" value="com_lajvit" />
          <input type="hidden" name="task" value="create" />
          <input type="hidden" name="controller" value="group" />
          <input type="hidden" name="eventId" value="<?php echo $this->eventId; ?>" />
          <input type="hidden" name="Itemid" value="<?php echo $this->itemId; ?>" />
        </td>
      </tr>
    </tbody>
  </table>
</form>
