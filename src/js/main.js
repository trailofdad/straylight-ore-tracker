/* global document */
/* eslint-disable no-undef */
$(document).ready(() => {
  function validate() {
    // validate ore values
    const oreValues = $('.ore-log__input');
    oreValues.each(function (index) {
      if (!oreValues[index].validity.valid) {
        return false;
      }
    });
    // validate title & description
    const title = $('#log-title')[0];
    const description = $('#log-description')[0];
    if (!title.validity.valid || !description.validity.valid) {
      return false;
    }
    return true;
  }

  function submitLog() {
    $('#submit-ore-log').prop('disabled', true);
    // grab the totals
    const oreLogs = $('.ore-log');
    const logTitle = $('#log-title').val();
    const logDescription = $('#log-description').val();
    let oreData = {};

    oreLogs.each(function (index) {
      let oreType = oreLogs[index].firstElementChild.value;
      let oreAmmount = $(oreLogs[index]).find('input')[0].value;
      let oreObject = {};

      oreObject[oreType] = oreAmmount;

      oreData[index] = oreObject;
    });

    if (validate()) {
      $.ajax({
        type: 'POST',
        // TODO: make base of this an env variable
        url: 'http://straylight.dev/wp-json/sot/v1/logs/submit',
        data: {
          log_title: logTitle,
          log_description: logDescription,
          log_data: oreData,
          id: wp.id,
        },
        success: () => {
          console.log('Log Submitted Successfully');
          $('.ore-log__wrapper').remove();
          $('#submit-ore-log').replaceWith('<h2 style="padding-top:5rem;">Thank you commander, your Ore Log has been submitted.</h2>');
        },
        error: () => {
          console.log('Something has gone terribly wrong with submitting the log');
        },
        dataType: 'json',
      });
    } else {
      alert('Please ensure you have filled out all fields');
      $('#submit-ore-log').prop('disabled', false);
    }
  }

  function addEventListeners() {
    const row = $('.ore-log__wrapper');
    const container = $('#ore-log-container');

    // Remove ore type
    $('.ore-log__close').click(function close() {
      $(this).parent().parent().remove();
    });

    // Add new Ore Type
    $('#add-ore-type').click(() => {
      let newLog = row.clone(true);
      newLog.children().children()[1].value = '';
      newLog.appendTo(container);
    });

    // Submit
    $('#submit-ore-log').click(() => {
      submitLog();
    });
  }

  function init() {
    console.log('Amarr Victor');
    addEventListeners();
  }

  init();
});
