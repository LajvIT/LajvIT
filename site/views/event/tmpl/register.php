<?php

// No direct access

defined('_JEXEC') or die('Restricted access'); ?>
<h1><?php echo $this->greeting; ?></h1>

<h1>Bekräfta registrering</h1>
<p>Kontrollera att dina personuppgifter stämmer. I annat fall kan du <a href="index.php?option=com_lajvit&view=person&layout=edit&Itemid=<? echo $this->itemid; ?>">editera dem</a> här innan du försöker registera dig på nytt.  </p>
<?	if ($this->incomplete_person) { ?>
	<p style="color:red;">Några obligatoriska uppgifter saknas.</p>
<?	} ?>
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
<p></p>
<p>
Genom att registrera dig för ett av våra arrangemang och betala medlemsavgiften blir du också medlem i den Sverok-anslutna föreningen <a href="http://www.krigshjarta.com/kh/index.php?option=com_content&view=article&id=4&Itemid=19">Krigshjärtan</a>. Föreningens arrangemang och träffar annonseras på forumet.
</p>

<?	if (!$this->incomplete_person) { ?>
	<form action="index.php" method="post" name="eventRegisterForm">
		<p><strong><? echo $this->events[$this->eventid]->name; ?></strong></p>
		<input type="submit" value="Bekräfta registrering"/>

		<input type="hidden" name="option" value="com_lajvit"/>
		<input type="hidden" name="task" value="register"/>
		<input type="hidden" name="controller" value="event"/>
		<input type="hidden" name="eid" value="<?php echo $this->eventid; ?>"/>
		<input type="hidden" name="Itemid" value="<?php echo $this->itemid; ?>"/>
	</form>
<?	} ?>

