<?php

// No direct access
defined('_JEXEC') or die('Restricted access');
?>

<h1>Intriger knutna till:</h1>

<table>
  <tbody  style="vertical-align: top;">
    <tr>
      <td><h2>Karaktär</h2></td>
    </tr><?php
      foreach ($this->plotObjectsCharacter as $plotObject) {
        ?>
    <tr>
      <td><h3><?php echo $plotObject->heading;?></h3></td>
    </tr>
    <tr>
      <td style="padding-left: 20px;"><?php echo nl2br(htmlspecialchars($plotObject->description)); ?></td>
    </tr><?php
      } ?>
    <tr><td></td></tr>
    <tr>
      <td><h2>Koncept</h2></td>
    </tr><?php
      foreach ($this->plotObjectsConcept as $plotObject) {
        ?>
    <tr>
      <td><h3><?php echo $plotObject->heading;?></h3></td>
    </tr>
    <tr>
      <td style="padding-left: 20px;"><?php echo nl2br(htmlspecialchars($plotObject->description)); ?></td>
    </tr><?php
      } ?>
    <tr><td></td></tr>
    <tr>
      <td><h2>Kultur</h2></td>
    </tr><?php
      foreach ($this->plotObjectsCulture as $plotObject) {
        ?>
    <tr>
      <td><h3><?php echo $plotObject->heading;?></h3></td>
    </tr>
    <tr>
      <td style="padding-left: 20px;"><?php echo nl2br(htmlspecialchars($plotObject->description)); ?></td>
    </tr><?php
      } ?>
    <tr><td></td></tr>
    <tr>
      <td><h2>Faktion</h2></td>
    </tr><?php
      foreach ($this->plotObjectsFaction as $plotObject) {
        ?>
    <tr>
      <td><h3><?php echo $plotObject->heading;?></h3></td>
    </tr>
    <tr>
      <td style="padding-left: 20px;"><?php echo nl2br(htmlspecialchars($plotObject->description)); ?></td>
    </tr><?php
      } ?>
    <tr><td></td></tr>
  </tbody>
</table>

