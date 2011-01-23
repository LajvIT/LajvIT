<?php
 
// No direct access
 
defined('_JEXEC') or die('Restricted access'); ?>
<h1><?php echo $this->greeting; ?></h1>

<form action="index.php" method="post" name="personEditForm">

<h1>Bekräfta registrering</h1>
<p>Kontrollera att dina personuppgifter stämmer. I annat fall kan du <a href="index.php?option=com_lajvit&view=person&layout=edit">editera dem</a> här innan du försöker registera dig på nytt.  </p>
<p>Namn: <? echo $this->givenname.' '.$this->surname; ?></p>
<p>Personummer: <? echo $this->pnumber; ?></p>
<p>Adress: <? echo $this->street; ?></p>
<p>Postort: <? echo $this->zip.' '.$this->town; ?></p>

<p>Epost: <? echo $this->email; ?></p>
<p>Publik epost: <? echo $this->publicemail; ?></p>
<p>Telefon1: <? echo $this->phone1; ?></p>
<p>Telefon2: <? echo $this->phone2; ?></p>
<p>ICQ: <? echo $this->icq; ?></p>
<p>MSN: <? echo $this->msn; ?></p>
<p>Skype: <? echo $this->skype; ?></p>
<p>Facebook: <? echo $this->facebook; ?></p>

<strong><p><? echo $this->events[$this->eventid]->name; ?></p></strong>

<input type="submit" value="Bekräfta registrering"/>
<input type="hidden" name="option" value="com_lajvit"/>
<input type="hidden" name="task" value="register"/>
<input type="hidden" name="controller" value="event"/>
<input type="hidden" name="eid" value="<? echo $this->eventid; ?>"/>

</form>
