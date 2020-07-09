<!DOCTYPE html>
<html lang="<?= $lang ?>">

<head>
    <title><?= $title ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="theme-color" content="#4285F4">
    <meta name="msapplication-navbutton-color" content="#4285F4">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="description" content="Rental Tracker Installation Form" />
    <meta name="keywords" content="rental, tracker, tracker installation" />
    <meta name="author" content="Rental Tracker" />
    <link rel="icon" type="image/png" href="<?= base_url('/assets/images/icon.png') ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/custom.css') ?>">
</head>

<body>
    <div id="qrcode-wrapper">
        <button class="close" onclick="stopCam()">X</button>
        <div id="qr-reader"></div>
    </div>

    <div id="content-wrapper">
        <header>
            <nav>
                <a href="<?= base_url($lang) ?>"><img src="<?= base_url('/assets/images/Rental-Tracker-logo.png') ?>"></a>
            </nav>
        </header>
        <div id="server-message" style="-webkit-transform: translateX(300px);-moz-transform: translateX(300px);-ms-transform: translateX(300px);-o-transform: translateX(300px);transform: translateX(300px);"></div>
        <div class="container-contact100">
            <div class="wrap-contact100">
                <?= form_open($lang . '/form/submit', ['class' => 'contact100-form', 'id' => 'installation-form']); ?>
                <div class="form-success-message" style="opacity: 0;"><?= $form_submit_message ?></div>
                <span class="contact100-form-title ">
                    <?= $installation_form ?>
                </span>

                <div class="wrap-input100 validate-input" data-validate="Name is required">
                    <label class="label-input100" for="installation_company"><?= $installation_company ?> (<?= $required ?>)</label>
                    <input class="input100" type="text" name="installation_company" id="installation_company" autocomplete="off">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input">
                    <label class="label-input100" for="engineer_name"><?= $engineer_name ?> (<?= $required ?>)</label>
                    <input class="input100" type="text" name="engineer_name" id="engineer_name" autocomplete="off">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input">
                    <label class="label-input100" for="engineer_number"><?= $telephone_number_engineer ?> (<?= $required ?>)</label>
                    <input class="input100" type="text" name="engineer_number" id="engineer_number" autocomplete="off">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input">
                    <label class="label-input100" for="email_address"><?= $email_address ?> (<?= $required ?>)</label>
                    <input class="input100" type="text" name="email_address" id="email_address" placeholder="<?= $send_copy_of_installation_form_to_email_address ?>" autocomplete="off">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input">
                    <label class="label-input100" for="email_address_2"><?= $email_address ?> 2</label>
                    <input class="input100" type="text" name="email_address_2" id="email_address_2" placeholder="<?= $send_copy_of_installation_form_to_second ?>" autocomplete="off">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input">
                    <label class="label-input100" for="company_name"><?= $company_name ?> (<?= $required ?>)</label>
                    <input class="input100" type="text" name="company_name" id="company_name" autocomplete="off">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input">
                    <label class="label-input100" for="order_number"><?= $order_number ?></label>
                    <input class="input100" type="text" name="order_number" id="order_number" autocomplete="off">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input">
                    <label class="label-input100" for="license_plate"><?= $license_plate ?> (<?= $required ?>)</label>
                    <input class="input100" type="text" name="license_plate" id="license_plate" placeholder="<?= $pay_attention ?>" autocomplete="off">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input">
                    <label class="label-input100" for="mileage"><?= $mileage ?> (<?= $required ?>)</label>
                    <input class="input100" type="text" name="mileage" id="mileage" autocomplete="off">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input">
                    <label class="label-input100" for="imei_code"><?= $scan_your_imei_or_activation_code ?> (<?= $required ?>)</label>
                    <img src="<?= base_url('/assets/images/qr-code.svg') ?>" alt="QRcode scanner" class="qr-image" onclick="startCam(this)" />
                    <input class="input100" type="text" name="imei_code" id="imei_code" placeholder="<?= $imei_or_activation_code ?>" autocomplete="off">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input input100-select">
                    <label class="label-input100" for="start_block"><?= $start_block ?> (<?= $required ?>)</label>
                    <div>
                        <select class="selection-2" name="start_block" id="start_block">
                            <option value="---" selected>---</option>
                            <option value="<?= $yes ?>"><?= $yes ?></option>
                            <option value="<?= $no ?>"><?= $no ?></option>
                        </select>
                    </div>
                </div>

                <div class="wrap-input100 validate-input">
                    <label class="label-input100" for="tracker_placement"><?= $tracker_placement_in_vehicle ?> (<?= $required ?>)</label>
                    <input class="input100" type="text" name="tracker_placement" id="tracker_placement" autocomplete="off">
                    <span class="focus-input100"></span>
                </div>

                <p class="text-important"><?= $important ?></p>
                <div class="wrap-input100 validate-input file-wrap">
                    <label class="label-input100 file-input-label" id="for_picture_of_imei_code" for="picture_of_imei_code"><?= $upload_picture_of_imei_code ?> (<?= $required ?>)</label>
                    <input class="input100" type="file" name="picture_of_imei_code" accept=".png,.jpg,.jpeg" id="picture_of_imei_code" autocomplete="off">
                </div>

                <div class="wrap-input100 validate-input file-wrap">
                    <label class="label-input100 file-input-label" id="for_picture_of_license_plate" for="picture_of_license_plate"><?= $upload_image_of_license_plate_or_chassis_number ?></label>
                    <input class="input100" type="file" name="picture_of_license_plate" accept=".png,.jpg,.jpeg" id="picture_of_license_plate" autocomplete="off">
                </div>

                <div class="button-wrap">
                    <button class="submit-button" type="submit"><?= $submit ?></button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <script src="<?= base_url('/assets/js/jquery-3.5.1.min.js') ?>" defer></script>
    <script src="<?= base_url('/assets/js/lib/html5-qrcode.min.js') ?>" defer></script>
    <script src="<?= base_url('/assets/js/main.js') ?>" defer></script>
    <script src="<?= base_url('/assets/js/qr-code-scanner.js') ?>" defer></script>
</body>

</html>