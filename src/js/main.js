/* global document, $ */
$(document).ready(() => {
  function validate() {
    // validate ore values
    const oreValues = $('.ore-log__input');
    oreValues.each((index) => {
      if (!oreValues[index].validity.valid) {
        return false;
      }
      return true;
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
    const oreData = {};

    oreLogs.each((index) => {
      const oreType = oreLogs[index].firstElementChild.value;
      const oreAmmount = $(oreLogs[index]).find('input')[0].value;
      const oreObject = {};

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
          const warnings = $('.alert');
          if (warnings) {
            warnings.remove();
          }
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
      const warnings = $('.alert');
      if (warnings) {
        warnings.remove();
      }
      const message = `<div class="alert alert-warning">
                        <strong>Attention!</strong> Please ensure all fields have been filled out and are valid.
                      </div>`;
      $('#submit-container').prepend(message);
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
      const newLog = row.clone(true);
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
