<?php
defined('_JEXEC') or die('Restricted access'); ?>

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
