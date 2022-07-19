$(document).ready(() => {
  // inserir "*" em inputs que forem required
  const input_list = $('input:required');
  input_list.each((index, el) => {
    const input_required = $(el);
    input_required.siblings('label').addClass('input-required');
  });

  // Configurções padrões do jquery.validate.js
  jQuery.validator.setDefaults({
    debug: true,
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.parent().append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    },
    onsubmit: false
  });

  // Validação se formulario está valido apra realizar o submit
  // $('.form_validate').submit((e) => {
  $('.btn-validate').click(() => {
    const form = $('.form_validate');
    if (!form.valid()) {
      console.log('Form is not valid, it was not submitted');
      return false;
    }

    // console.log(form);
    console.log('Form is valid, it will get submitted');
    form.submit();
  });

  $.fn.select2.defaults.set( "theme", "bootstrap" ); // estilo bootstrap padrão para o select2
  $('select').select2();
});