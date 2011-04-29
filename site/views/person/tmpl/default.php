<?php
 
// No direct access
 
defined('_JEXEC') or die('Restricted access'); ?>


<h1>Personuppgifter</h1>

<table><tbody>
	<tr>
		<td>Förnamn:</td>
		<td><? echo $this->givenname; ?></td>
	</tr>
	<tr>
		<td>Efternamn:</td>
		<td><? echo $this->surname; ?></td>
	</tr>
<?	if ($this->role->person_viewcontactinfo || $this->role->person_viewmedical) { ?>
		<tr>
			<td>Personnummer:</td>
			<td><? echo $this->pnumber; ?></td>
		</tr>
		<tr>
			<td>Kön:</td>
			<td>
<?				if ($this->sex == 'M') { ?>
					Man
<?				} else if ($this->sex == 'F') { ?>
					Kvinna
<?				} ?>
			</td>
		</tr>
<?				}
	if ($this->role->person_viewcontactinfo) { ?>
		<tr>
			<td>E-post:</td>
			<td><? echo $this->email; ?></td>
		</tr>
<?	} ?>
	<tr>
		<td>Epost publik:</td>
		<td><? echo $this->publicemail; ?></td>
	</tr>
<?	if ($this->role->person_viewcontactinfo) { ?>
		<tr>
			<td>Telefon:</td>					
			<td><? echo $this->phone1; ?></td>
		</tr>
		<tr>
			<td>Alternativ telefon:</td>
			<td><? echo $this->phone2; ?></td>
		</tr>
		<tr>
			<td>Adress:</td>
			<td><? echo $this->street; ?></td>
		</tr>
		<tr>
			<td>Postnummer:</td>
			<td><? echo $this->zip; ?></td>
		</tr>
<?	} ?>
	<tr>
		<td>Stad:</td>
		<td><? echo $this->town; ?></td>
	</tr>
<?	if ($this->role->person_viewcontactinfo) { ?>
		<tr>
			<td>Icq:</td>
			<td><? echo $this->icq; ?></td>
		</tr>
		<tr>
			<td>Msn:</td>				
			<td><? echo $this->msn; ?></td>
		</tr>				
		<tr>
			<td>Skype:</td>				
			<td><? echo $this->skype; ?></td>
		</tr>
		<tr>
			<td>Facebook:</td>
			<td><? echo $this->facebook; ?></td>
		</tr>
<?	}
	if ($this->role->person_viewmedical) { ?>
		<tr>
			<td>Eventuella sjukdomar:</td>
			<td><? echo $this->illness; ?></td>
		</tr>
		<tr>
			<td>Eventuella allergier:</td>
			<td><? echo $this->allergies; ?></td>
		</tr>
		<tr>
			<td>Eventuella mediciner:</td>
			<td><? echo $this->medicine; ?></td>
		</tr>
<?	} ?>
	<tr>
		<td>Beskrivning:</td>
		<td><? echo $this->info; ?></td>
	</tr>
<?	if ($this->role->person_viewcontactinfo || $this->role->registration_list) { ?>
		<tr>
			<td>Användarnamn:</td>
			<td><? echo $this->username; ?></td>
		</tr>
<?	}
	if ($this->role->registration_list) { ?>
		<tr>
			<td>Roller <? echo $this->eventname; ?>:</td>
			<td><? echo $this->personrolenames; ?></td>
		</tr>
<?	} ?>
</tbody></table>
