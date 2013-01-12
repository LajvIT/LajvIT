<?php

defined('_JEXEC') or die('Restricted Access');
?>
<tr>
  <th width="5">
    <?php echo JText::_('COM_LAJVIT_EVENTS_HEADING_ID'); ?>
  </th>
  <th width="20">
    <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
  </th>
  <th>
    <?php echo JText::_('COM_LAJVIT_EVENTS_HEADING_NAME'); ?>
  </th>
</tr>

