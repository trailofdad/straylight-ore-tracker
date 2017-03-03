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
});
