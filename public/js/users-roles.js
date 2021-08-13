$(function () {
    $(document).on('change', '#role_id', function(e) {
      $('#branch_id').val('');

      showOrHideBranches($(this).val());
    })

    $(document).on('click', '#create', function(e) {
      showOrHideBranches('');
    })
});

function customizeEdit(data) {
	showOrHideBranches(data.role_id);
}

function showOrHideBranches(role_id) {
  if(role_id == 2) {
    $('.div-brand-id').removeClass('d-none');
  }else {
    $('.div-brand-id').addClass('d-none');
  }
}
