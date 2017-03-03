/* global document */
/* eslint-disable no-undef */
$(document).ready(() => {
  console.log('Amarr Victor');
  const row = $('.ore-log__wrapper');
  const container = $('#ore-log-container');

  $('.ore-log__close').click(function close() {
    $(this).parent().parent().remove();
  });

  $('#add-ore-type').click(() => {
    row.clone(true).appendTo(container);
    $('.ore-log__close').click(function close() {
      $(this).parent().parent().remove();
    });
  });

  $('#submit-ore-log').click(() => {
    $('#submit-ore-log').prop('disabled', true);
    // grab the totals
    const oreLogs = $('.ore-log');

    let oreData = {};

    oreLogs.each(function (index) {
      let oreType = oreLogs[index].firstElementChild.value;
      let oreAmmount = $(oreLogs[index]).find('input')[0].value;
      let oreObject = {};

      oreObject[oreType] = oreAmmount;

      oreData[index] = oreObject;
    });

    $.ajax({
      type: 'POST',
      // TODO: make base of this an env variable
      url: 'http://straylight.dev/wp-json/sot/v1/logs/submit',
      data: {
        log_title: 'Straylight Systems',
        log_description: 'Here is a description of the first post test',
        log_data: oreData,
        id: wp.id,
      },
      success: (res) => {
        console.log('Log Submitted Successfully');
        $('.ore-log__wrapper').remove();
        $('#submit-ore-log').replaceWith('<h2 style="padding-top:5rem;">Thank you commander, your Ore Log has been submitted.</h2>');
      },
      dataType: 'json',
    });
  });
});
