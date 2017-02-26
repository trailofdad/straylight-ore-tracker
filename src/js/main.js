/* global document */
/* eslint-disable no-undef */
$(document).ready(() => {
  console.log('Amarr Victor');
  const row = $('.ore-log__wrapper');
  const container = $('#ore-log-container');
  $('#add-ore-type').click(() => {
    row.clone().appendTo(container);
  });
});
