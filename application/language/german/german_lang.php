<?php
defined('BASEPATH') or exit('No direct script access allowed');

$lang['title'] = "Installationsformular - Rental Tracker";
$lang['installation_form'] = "Installationsformular";
$lang['required'] = "Obligatorisch";
$lang['installation_company'] = "Installationsfirma";
$lang['engineer_name'] = "Name des Mechanikersr";
$lang['telephone_number_engineer'] = "Telefonnummer des Mechanikers";
$lang['email_address'] = "E-Mail-Adresse";
$lang['company_name'] = "Name der Kundenfirma";
$lang['order_number'] = "Bestellnummer";
$lang['license_plate'] = "Kennzeichen / Report-Code";
$lang['mileage'] = "Kilometerstand";
$lang['scan_your_imei_or_activation_code'] = "Geben Sie Ihren IMEI-Code oder Aktivierungscode ein";
$lang['start_block'] = "Startblock";
$lang['yes'] = "Ja";
$lang['no'] = "Nein";
$lang['tracker_placement_in_vehicle'] = "Standort des Trackers";
$lang['upload_picture_of_imei_code'] = "Bild des IMEI-Codes hochladen";
$lang['picture_of_imei_code'] = "Bild des IMEI-Codes";
$lang['upload_image_of_license_plate_or_chassis_number'] = "Laden Sie das Bild des Kennzeichens oder der Fahrgestellnummer hoch";
$lang['license_plate_or_chassis_number'] = "Bild des Kennzeichens oder der Fahrgestellnummer";
$lang['submit'] = "EINREICHEN";
$lang['lang'] = "de";
$lang['send_copy_of_installation_form_to_email_address'] = "Senden Sie eine Kopie des Installationsformulars an die E-Mail-Adresse";
$lang['send_copy_of_installation_form_to_second'] = "Kopie des Installationsformulars an die zweite E-Mail-Adresse senden";
$lang['pay_attention'] = "Passt auf! Geben Sie nur die Buchstaben und Nummern der Registrierungsnummer oder des Berichtscodes ein.";
$lang['imei_or_activation_code'] = "IMEI oder Aktivierungscode";
$lang['is_required'] = "Feld ist erforderlich";
$lang['upload_jpg_or_png_file'] = "Das Hochladen eines Bildes des IMEI-Codes in 5 MB ist erforderlich";
$lang['enter_valid_mail_address'] = "Geben Sie eine gültige E-Mail-Adresse ein";
$lang['important'] = "Hinweis: Nur 5 MB PNG- und JPG-Datei sind für beide Felder zulässig";
$lang['submit_successful'] = "Das Formular wurde erfolgreich eingereicht";
$lang['server_error'] = "Serverfehler, bitte versuchen Sie es erneut";
$lang['select_bra_qr_scanner'] = "Wählen Sie Barcode / QR-Code-Scanner";
$lang['select'] = "Wählen";
$lang['is_not_valid'] = "ist nicht gültig";
$lang['email_subject'] = "Neues Installationsformular - IMEI-(%IMEI%) - (%LICENSE%)";
$lang['email_body'] = "
Hallo,\n
Ein eingebautes Formular wurde unter ausgefüllt. In dieser E-Mail senden wir Ihnen das Installationsformular im PDF-Format.\n
Mit freundlichen Grüßen,
Vermietung Tracker
https://rentaltracker.de\n
(%LANG_installation_company%): (%installation_company%)
(%LANG_engineer_name%): (%engineer_name%)
(%LANG_engineer_number%): (%engineer_number%)
(%LANG_email_address%): (%email_address%)
(%LANG_email_address_2%): (%email_address_2%)
(%LANG_company_name%): (%company_name%)
(%LANG_order_number%): (%order_number%)
(%LANG_license_plate%): (%license_plate%)
(%LANG_mileage%): (%mileage%)
(%LANG_imei_code%): (%imei_code%)
(%LANG_start_block%): (%start_block%)
(%LANG_tracker_placement%): (%tracker_placement%)
";

$lang['form_submit_message'] = "Ihr vorheriges Formular wurde erfolgreich gesendet.";