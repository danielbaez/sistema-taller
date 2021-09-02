$(function () {
    $(document).on('change', '#document_id', function(e) {
      showOrHideDocument($(this).val());
    })

    $(document).on('click', '#create', function(e) {
      showOrHideDocument('');
    })
});

function customizeEdit(data) {
  showOrHideDocument(data.document_id);
}

function showOrHideDocument(document_id) {
  if(document_id == 6) {
    $('.div-company-id').removeClass('d-none');
  }else {
    $('.div-company-id').addClass('d-none');
  }
}
