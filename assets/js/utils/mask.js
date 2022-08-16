// mascaras
$(document).ready(() => {
  $('input.date').inputmask('99/99/9999');
  $('input.time').inputmask('99:99:99');
  $('input.date-time').inputmask('99/99/9999 99:99:99');

  $('input.cep').inputmask('99999-999');
  $('input.cpf').inputmask('999.999.999-99');
  $('input.rg').inputmask('99.999.999-99');
  $('input.cnpj').inputmask('99.999.999/9999-99');

  $('input.phone').inputmask('(99)99999-9999');
  $('input.mobile-phone').inputmask('(99)99999-9999');

  // $('input.money').mask('000.000.000.000.000,00', { reverse: true });
  $('.money').maskMoney({
    thousands: '.',
    decimal: ',',
    precision: 2,
    allowZero: false
  });
});