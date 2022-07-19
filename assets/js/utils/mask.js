// mascaras
$(document).ready(() => {
  $('input.date').mask('00/00/0000');
  $('input.time').mask('00:00:00');
  $('input.date-time').mask('00/00/0000 00:00:00');

  $('input.cep').mask('00000-000');
  $('input.cpf').mask('000.000.000-00');
  $('input.rg').mask('00.000.000-00');
  $('input.cnpj').mask('00.000.000/0000-00');

  $('input.phone').mask('(00) 0000-0000');
  $('input.mobile-phone').mask('(00) 90000-0000');

  // $('input.money').mask('000.000.000.000.000,00', { reverse: true });
  $('.money').maskMoney({
    thousands: '.',
    decimal: ',',
    precision: 2,
    allowZero: false
  });
});