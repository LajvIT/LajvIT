<?php
defined('_JEXEC') or die('Restricted access'); ?>

<h1>
  Skapa grupp
</h1>

<form action="index.php" method="post" name="groupCreateForm">
  <table>
    <tbody>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_NAME');?>:</strong></td>
        <td><input type="text" name="groupName" value="" size="40"></td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_DESCRIPTION');?>:</strong></td>
        <td><textArea name="groupPublicDescription" cols="40" rows="5" ></textArea></td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_DESCRIPTION_PRIVATE');?>:</strong></td>
        <td><textArea name="groupPrivateDescription" cols="40" rows="5" ></textArea></td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_MAX_NO_MEMBERS');?>:</strong></td>
        <td><input type="text" name="groupMaxParticipants" value="" size="3"></td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_EXPECTED_NO_MEMBERS');?>:</strong></td>
        <td><input type="text" name="groupExpectedParticipants" value="" size="3"></td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_INFO_FOR_ORGANIZER');?>:</strong></td>
        <td><textArea name="groupAdminInfo" cols="40" rows="5" ></textArea></td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_HOMEPAGE');?>:</strong></td>
        <td><input type="text" name="groupUrl" value="" size="40"></td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_FACTION');?>:</strong></td>
        <td><select name="groupFaction"><?php
foreach ($this->factions as $faction) {
  echo '<option value="' . $faction->id . '"';
  echo ' >' . ucfirst($faction->name) . '</option>\n';
}
?>
          </select></td>
      </tr>
      <tr>
        <td></td>
        <td>
          <input type="submit" value="<?php echo JText::_('COM_LAJVIT_GROUP_SAVE'); ?>" />
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
