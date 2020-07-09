'use strict';

var validArray = [
    'installation_company',
    'engineer_name',
    'engineer_number',
    'email_address',
    'email_address_2',
    'company_name',
    'order_number',
  ],
  imageFieldInnerText1 = null,
  imageFieldInnerText2 = null,
  serverMessage,
  serverMessageShowTimeOut;

$(document).ready(function () {
  retriveFormData();

  !imageFieldInnerText1 && (imageFieldInnerText1 = document.getElementById('for_picture_of_imei_code').innerText);
  !imageFieldInnerText2 && (imageFieldInnerText2 = document.getElementById('for_picture_of_license_plate').innerText);

  document.getElementById('picture_of_imei_code').addEventListener('change', function (e) {
    document.getElementById('for_picture_of_imei_code').innerText = event.target.files[0].name;
  });

  document.getElementById('picture_of_license_plate').addEventListener('change', function (e) {
    document.getElementById('for_picture_of_license_plate').innerText = event.target.files[0].name;
  });

  serverMessage = document.getElementById('server-message');

  serverMessage.addEventListener('click', function () {
    serverMessage.classList.remove('show-message');
    clearTimeout(serverMessageShowTimeOut);
  });

  $('#installation-form')
    .unbind('submit')
    .bind('submit', function (e) {
      e.preventDefault();
      var form = $(this);
      var url = form.attr('action');
      var type = form.attr('method');
      var data = new FormData(this);

      var button = document.querySelector('.submit-button');
      button.innerHTML += '<div id="spinner-icon" class="lds-ring"><div></div><div></div><div></div><div></div></div>';
      button.setAttribute('disabled', 'disabled');

      setTimeout(function () {
        $.ajax({
          url: url,
          type: type,
          data: data,
          dataType: 'json',
          cache: false,
          contentType: false,
          processData: false,
          async: false,
          success: function success(res) {
            var message = '';
            clearTimeout(serverMessageShowTimeOut);
            if (res.success === false) {
              for (var key in res.messages) {
                if (res.messages.hasOwnProperty(key)) {
                  res.messages[key] && (message += res.messages[key]);
                }
              }

              showServerMessage(message, '#c0392b');
            } else {
              localStorage.saveFrmData = JSON.stringify(form.serializeArray());

              if (!res.error) {
                form.serializeArray().forEach(function (item) {
                  if (validArray.indexOf(item.name) === -1 && !item.name.match(/^csrf/)) {
                    document.getElementById(item.name).value = '';
                  }
                });
                
                document.querySelector('.form-success-message').classList.add('show-form-success-message');
                document.getElementById('for_picture_of_imei_code').innerText = imageFieldInnerText1;
                document.getElementById('for_picture_of_license_plate').innerText = imageFieldInnerText2;

                $('html,body').animate(
                  {
                    scrollTop: 0,
                  },
                  'slow'
                );
              }

              showServerMessage(res.messages, res.error ? '#c0392b' : '#27ae60');
            }
          },
          complete: function complete() {
            setTimeout(function () {
              document.getElementById('spinner-icon').remove();
              document.querySelector('.submit-button').removeAttribute('disabled');
            }, 1000);
          },
        });
      }, 500);
    });
});

function retriveFormData() {
  var formData = localStorage.saveFrmData;

  if (formData) {
    formData = JSON.parse(formData);
    formData.forEach(function (item) {
      if (validArray.indexOf(item.name) !== -1) {
        document.getElementById(item.name).value = item.value;
      }
    });
  }
}

function showServerMessage(message, color) {
  serverMessage.innerHTML = '<ul>' + message + '</ul>';
  serverMessage.classList.add('show-message');
  serverMessage.style.backgroundColor = color;

  serverMessageShowTimeOut = setTimeout(function () {
    serverMessage.classList.remove('show-message');
  }, 15000);
}
