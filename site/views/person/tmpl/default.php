<?php
defined('_JEXEC') or die('Restricted access'); ?>

<h1>Personuppgifter</h1>

<table><tbody>
  <tr>
    <td>Förnamn:</td>
    <td><?php echo $this->givenname; ?></td>
  </tr>
  <tr>
    <td>Efternamn:</td>
    <td><?php echo $this->surname; ?></td>
  </tr><?php
if ($this->role->person_viewcontactinfo || $this->role->person_viewmedical) { ?>
    <tr>
      <td>Personnummer:</td>
      <td><?php echo $this->pnumber; ?></td>
    </tr>
    <tr>
      <td>Kön:</td>
      <td><?php
  if ($this->sex == 'M') {
    echo 'Man';
  } else if ($this->sex == 'F') {
    echo 'Kvinna';
  } ?>
      </td>
    </tr><?php
}

if ($this->role->person_viewcontactinfo) { ?>
    <tr>
      <td>E-post:</td>
      <td><?php echo $this->email; ?></td>
    </tr><?php
} ?>
  <tr>
    <td>Epost publik:</td>
    <td><?php echo $this->publicemail; ?></td>
  </tr><?php

if ($this->role->person_viewcontactinfo) { ?>
    <tr>
      <td>Telefon:</td>
      <td><?php echo $this->phone1; ?></td>
    </tr>
    <tr>
      <td>Alternativ telefon:</td>
      <td><?php echo $this->phone2; ?></td>
    </tr>
    <tr>
      <td>Adress:</td>
      <td><?php echo $this->street; ?></td>
    </tr>
    <tr>
      <td>Postnummer:</td>
      <td><?php echo $this->zip; ?></td>
    </tr><?php
} ?>
  <tr>
    <td>Stad:</td>
    <td><?php echo $this->town; ?></td>
  </tr><?php
if ($this->role->person_viewcontactinfo) { ?>
    <tr>
      <td>Icq:</td>
      <td><?php echo $this->icq; ?></td>
    </tr>
    <tr>
      <td>Msn:</td>
      <td><?php echo $this->msn; ?></td>
    </tr>
    <tr>
      <td>Skype:</td>
      <td><?php echo $this->skype; ?></td>
    </tr>
    <tr>
      <td>Facebook:</td>
      <td><?php echo $this->facebook; ?></td>
    </tr><?php
}

if ($this->role->person_viewmedical) { ?>
    <tr>
      <td>Eventuella sjukdomar:</td>
      <td><?php echo $this->illness; ?></td>
    </tr>
    <tr>
      <td>Eventuella allergier:</td>
      <td><?php echo $this->allergies; ?></td>
    </tr>
    <tr>
      <td>Eventuella mediciner:</td>
      <td><?php echo $this->medicine; ?></td>
    </tr><?php
} ?>
  <tr>
    <td>Beskrivning:</td>
    <td><?php echo $this->info; ?></td>
  </tr>
  <tr>
    <td>Användarnamn:</td>
    <td><?php echo $this->username; ?></td>
  </tr><?php

if ($this->role->registration_list) { ?>
    <tr>
      <td>Roller <?php echo $this->eventname; ?>:</td>
      <td><?php echo $this->personrolenames; ?></td>
    </tr><?php
} ?>
</tbody></table>
