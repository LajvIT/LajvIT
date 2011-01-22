<?php
 
// No direct access
 
defined('_JEXEC') or die('Restricted access'); ?>


	<h1>Mina Arrangemang
<?	if (false) { ?>
		&nbsp;<a href="event_new.html"><img src="components/com_lajvit/new_organizer.gif"/></a>
<?	} ?>
	</h1>

<?	foreach ($this->events as $event) { ?>
		<h2><? echo $event->name; ?><a href="<? echo $event->url; ?>"><img src="components/com_lajvit/info.gif"/></a>
<?		if (false) { ?>
			&nbsp;<a href="event_edit.html"><img src="components/com_lajvit/edit_organizer.gif"/></a>
<?		} ?>
		</h2>
		<p>Start: <? echo $event->startdate; ?> Slut: <? echo $event->enddate; ?></p>
		
<?		if (!$event->registered) { ?>
<strong><p>Ej Registrerad.&nbsp<a href="registration_confirmnew.html"><img src="components/com_lajvit/new.gif"/></a></p></strong>
<?		} else { ?>
			<strong><p>
				Betalning: <? echo ($event->confirmed ? 'Godkänd' : 'Ej godkänd'); ?>
				(<? echo $event->payment; ?> kr)
			</p></strong>
			
<?			foreach ($event->characters as $char) { ?>
				<strong><p>
					<? echo $char->knownas; ?> - <? echo $char->statusdesc; ?>
					&nbsp;<a href="index.php?option=com_lajvit&view=character&eid=<? echo $event->id; ?>&cid=<? echo $char->id; ?>"><img src="components/com_lajvit/info.gif"/></a>
					&nbsp;<a href="index.php?option=com_lajvit&view=character&layout=edit&eid=<? echo $event->id; ?>&cid=<? echo $char->id; ?>"><img src="components/com_lajvit/edit.gif"/></a>
					&nbsp;<a href="index.php?option=com_lajvit&view=character&layout=delete&eid=<? echo $event->id; ?>&cid=<? echo $char->id; ?>"><img src="components/com_lajvit/delete.gif"/></a>
				</p></strong>
				<p><? echo $char->conceptname; ?></p>
<?			} ?>
<?		} ?>
		
		<strong><p>
			Lägg till karaktär
			&nbsp;<a href="index.php?option=com_lajvit&view=character&layout=new&eid=<? echo $event->id; ?>"><img src="components/com_lajvit/new.gif"/></a>
		</p></strong>
<?	} ?>

<!--

<h2>Krigshjärta 5: En saga&nbsp<a href="http://www.krigshjarta.com/kh/index.php?option=com_content&view=article&id=67&Itemid=3"><img src="info.gif"/></a>&nbsp<a href="event_edit.html"><img src="edit_organizer.gif"/></a></h2> 
<p>Start: 2011-10-01 Slut: 2011-10-05</p>
<strong><p>Betalning: Godkänd (500 kr)</p></strong>
<strong><p>Grim Björnklo - Godkänd&nbsp<a href="character_view.html"><img src="info.gif"/></a>&nbsp<a href="character_edit.html"><img src="edit.gif"/></a>&nbsp<a href="concept_confirmdelete.html"><img src="delete.gif"/></a></p></strong>
<p>Cordov, Skyttefalk (rotemästare)</p>

<strong><p>Fjodor D - Koncept godkänt&nbsp<a href="character_view.html"><img src="info.gif"/></a>&nbsp<a href="character_edit.html"><img src="edit.gif"/></a>&nbsp<a href="concept_confirmdelete.html"><img src="delete.gif"/></a></p></strong>
<p>Gillet, Hantverkare(Snickare)</p>

<strong><p>Ale Tyrsson - Ej Godkänd&nbsp<a href="character_view.html"><img src="info.gif"/></a>&nbsp<a href="character_edit.html"><img src="edit.gif"/></a>&nbsp<a href="concept_confirmdelete.html"><img src="delete.gif"/></a></p></strong>
<p>Skaegi, Annat (råttfångare)</p>

<strong><p>Nytt rollkoncept&nbsp<a href="concept_new.html"><img src="new.gif"/></a></p></strong>





<h2>Krigshjärta 6: Ytterligare en saga&nbsp<a href="http://www.krigshjarta.com/kh/index.php?option=com_content&view=article&id=67&Itemid=3"><img src="info.gif"/></a>&nbsp<a href="event_edit.html"><img src="edit_organizer.gif"/></a></h2> 
<p>Start: 2011-10-01 Slut: 2011-10-05</p>

<strong><p>Betalning: Ej godkänd (0 kr)</p></strong>
<strong><p>Rollkoncept saknas&nbsp<a href="concept_new.html"><img src="new.gif"/></a></p></strong>

<h2>Krigshjärta 7: En saga till&nbsp<a href="http://www.krigshjarta.com/kh/index.php?option=com_content&view=article&id=67&Itemid=3"><img src="info.gif"/></a>&nbsp<a href="event_edit.html"><img src="edit_organizer.gif"/></a></h2> 
<p>Start: 2011-10-01 Slut: 2011-10-05</p>
<strong><p>Ej Registrerad.&nbsp<a href="registration_confirmnew.html"><img src="new.gif"/></a></p></strong>
<p></p>
<p>Förklaring: <img src="info.gif"/>&nbsp Visa &nbsp <img src="edit.gif"/>&nbsp Uppdatera &nbsp <img src="delete.gif"/>&nbsp Radera</p>

-->
