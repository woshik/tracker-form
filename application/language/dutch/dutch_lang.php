<?php
defined('BASEPATH') or exit('No direct script access allowed');

$lang['title'] = "Inbouw formulier - Rental Tracker";
$lang['installation_form'] = "Inbouw Formulier";
$lang['required'] = "verplicht";
$lang['installation_company'] = "Inbouwbedrijf";
$lang['engineer_name'] = "Naam monteur";
$lang['telephone_number_engineer'] = "Telefoonnummer van de ingenieur";
$lang['email_address'] = "Emailadres";
$lang['company_name'] = "Bedrijfsnaam klant";
$lang['order_number'] = "Ordernummer";
$lang['license_plate'] = "Kenteken / Meldcode";
$lang['mileage'] = "Kilometerstand";
$lang['scan_your_imei_or_activation_code'] = "Scan uw IMEI of activeringscode";
$lang['imei_or_activation_code'] = "IMEI of activeringscode";
$lang['start_block'] = "Startblokkade";
$lang['yes'] = "JA";
$lang['no'] = "NEE";
$lang['tracker_placement_in_vehicle'] = "Plaatsing tracker in voertuig";
$lang['upload_picture_of_imei_code'] = "Upload afbeelding van IMEI code";
$lang['picture_of_imei_code'] = "Afbeelding van IMEI-code";
$lang['upload_image_of_license_plate_or_chassis_number'] = "Upload afbeelding van kenteken of chassisnummer";
$lang['license_plate_or_chassis_number'] = "Afbeelding van nummerplaat of chassisnummer";
$lang['submit'] = "VERZENDEN";
$lang['lang'] = "nl";
$lang['send_copy_of_installation_form_to_email_address'] = "Stuur kopie van inbouwformulier naar emailadres";
$lang['send_copy_of_installation_form_to_second'] = "Stuur kopie van inbouwformulier naar tweede emailadres";
$lang['pay_attention'] = "Let op! Vul alleen de letters en cijfers in van het kenteken of de meldcode.";
$lang['imei_or_activation_code'] = "IMEI of activatiecode";
$lang['is_required'] = "veld is verplicht";
$lang['upload_jpg_or_png_file'] = "Upload foto van IMEI-code is vereist in 5 MB";
$lang['enter_valid_mail_address'] = "Voer een geldig e-mailadres in";
$lang['important'] = "Opmerking: alleen 5 MB png en jpg bestand acceptabel voor beide velden";
$lang['submit_successful'] = "Formulier is verzonden";
$lang['server_error'] = "Serverfout. Probeer het opnieuw";
$lang['select_bra_qr_scanner'] = "Selecteer Barcode / QR-code Scanner";
$lang['select'] = "Selecteer";
$lang['is_not_valid'] = "is niet geldig";
$lang['email_subject'] = "Nieuw inbouw formulier - IMEI-(%IMEI%) - (%LICENSE%)";
$lang['email_body'] = "
Beste,\n
Er is een inbouwformulier ingevuld op https://rentaltracker.nl. In deze mail sturen wij u het inbouwformulier in PDF formaat op.\n
Met vriendelijke groet,
Rental Tracker\n
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
$lang['form_submit_message'] = "Uw vorige formulier is succesvol verzonden.";
