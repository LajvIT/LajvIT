<?php

// No direct access

defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="personEditForm">

	<h1>Mina personuppgifter</h1>
	<p>Dessa uppgifter kommer användas när du anmäler dig till olika arrangemang. Se till att de hålls
		uppdaterade.</p>
		<?  if ($this->incomplete_person) { ?>
	<p style="color: red;">Några obligatoriska fält är inte ifyllda.</p>
	<?  } ?>

	<table class="contentpaneopen">

		<tbody>
			<tr>
				<td>Förnamn:</td>
				<td><input type="text" name="givenname" value="<? echo $this->givenname; ?>" size="25">*</td>
			</tr>

			<tr>
				<td><label for="surname">Efternamn:</label></td>
				<td><input type="text" name="surname" value="<? echo $this->surname; ?>" mosreq="1"
					moslabel="Efternamn" size="25">*</td>
			</tr>
			<tr>
				<td><label for="pnumber" title=>Personnummer:</label></td>
				<td><input type="text" name="pnumber" value="<? echo $this->pnumber; ?>" mosreq="1"
					moslabel="E-post" size="25" />*</td>
			</tr>
			<tr>
				<td><label for="sex">Kön:</label></td>
				<td id="cbfv_50">Man<input type="radio" name="sex" title="Man" value="M"
				<? echo ($this->sex == 'M' ? 'checked="1"' : ""); ?> /> Kvinna<input type="radio" name="sex"
					title="Kvinna" value="F" <? echo ($this->sex == 'F' ? 'checked="1"' : ""); ?> />*</td>
			</tr>
			<tr>
				<td><label for="idnum">E-post:</label></td>
				<td><input type="text" name="email" value="<? echo $this->email; ?>" mosreq="1"
					moslabel="E-post" size="25" />*</td>
			</tr>
			<tr>
				<td>Epost publik:</label></td>
				<td><input type="text" name="publicemail" value="<? echo $this->publicemail; ?>" size="25" />
				</td>
			</tr>
			<tr>
				<td>Telefon:</td>
				<td><input type="text" name="phone1" id="label" value="<? echo $this->phone1; ?>" size="25" />*</td>
			</tr>
			<tr>
				<td>Alternativ telefon:</label></td>
				<td><input type="text" name="phone2" value="<? echo $this->phone2; ?>" size="25" />
				</td>
			</tr>
			<tr>
				<td>Adress:</label></td>
				<td><input type="text" name="street" value="<? echo $this->street; ?>" size="25">*</td>
			</tr>
			<tr>
				<td><label for="zip">Postnummer:</label></td>
				<td><input type="text" name="zip" id="zip" value="<? echo $this->zip; ?>" size="25">*</td>
			</tr>
			<tr>
				<td>Stad:</label></td>
				<td><input type="text" name="town" value="<? echo $this->town; ?>" size="25">*</td>
			</tr>
			<tr>
				<td><label for="cb_msn">Icq:</label></td>
				<td><input type="text" name="icq" value="<? echo $this->icq; ?>" size="25"></td>
			</tr>
			<tr>
				<td><label for="cb_msn">Msn:</label></td>
				<td><input type="text" name="msn" value="<? echo $this->msn; ?>" size="25"></td>
			</tr>
			<tr>
				<td><label for="skype">Skype:</label></td>
				<td><input type="text" name="skype" value="<? echo $this->skype; ?>" size="25"></td>
			</tr>
			<tr>
				<td><label for="cb_facebook">Facebook:</label></td>
				<td><input type="text" name="facebook" value="<? echo $this->facebook; ?>" size="25"></td>
			</tr>
			<tr>
				<td><label for="info">Eventuella sjukdomar:</label></td>
				<td><textarea name="illness" cols="50" rows="10">
				<? echo $this->illness; ?>
          </textarea></td>
			</tr>
			<tr>
				<td><label for="info">Eventuella allergier:</label></td>
				<td><textarea name="allergies" cols="50" rows="10">
				<? echo $this->allergies; ?>
          </textarea></td>
			</tr>
			<tr>
				<td><label for="info">Eventuella mediciner:</label></td>
				<td><textarea name="medicine" cols="50" rows="10">
				<? echo $this->medicine; ?>
          </textarea></td>
			</tr>
			<tr>
				<td><label for="info">Beskrivning:</label></td>
				<td><textarea name="info" cols="50" rows="10">
				<? echo $this->info; ?>
          </textarea></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="Spara ändringar" title="save" /></td>
			</tr>
		</tbody>
	</table>

	<input type="hidden" name="option" value="com_lajvit" /> <input type="hidden" name="task"
		value="save" /> <input type="hidden" name="controller" value="person" /> <input type="hidden"
		name="Itemid" value="<? echo $this->itemid; ?>" />

</form>
