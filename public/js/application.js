$('.cr_amount').on('focus keyup change', function () {
  getTotal();
});
$('.dr_amount').on('focus keyup change', function () {
  getTotal();
});
$('.amount').on('focus keyup change', function () {
  getTotal();
});

function getTotal() {
  var cr_sum = 0;
  var dr_sum = 0;
  //iterate through each textboxes and add the values
  $('.cr_amount').each(function () {
    //add only if the value is number
    if (!isNaN(this.value) && this.value.length != 0) {
      cr_sum += parseFloat(this.value);
    }
  });
  //iterate through each textboxes and add the values
  $('.dr_amount').each(function () {
    //add only if the value is number
    if (!isNaN(this.value) && this.value.length != 0) {
      dr_sum += parseFloat(this.value);
    }
  });
  $('.amount').each(function () {
    //add only if the value is number
    if (!isNaN(this.value) && this.value.length != 0) {
      cr_sum += parseFloat(this.value);
    }
  });
  //.toFixed() method will roundoff the final sum to 2 decimal places
  $('#sub_total').val(cr_sum.toFixed(2));
  $('#total_cr').val(cr_sum.toFixed(2));
  $('#total_dr').val(dr_sum.toFixed(2));
}

function rider_price(g) {
  rider_id = $('#rider_id').val();
  item_id = $(g).val();
  $.ajax({
    url: $('#base_url').val() + '/search_item_price/' + rider_id + '/' + item_id,
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    type: 'GET',
    dataType: 'JSON',
    success: function (data) {
      if (data.price) {
        $(g).closest('.row').find('.rate').val(data.price);
      } else {
        $(g).closest('.row').find('.rate').val(data.pirce);
      }
      let qty = $(g).closest('.row').find('.qty').val();
      if (qty == '') {
        qty = 1;
        $(g).closest('.row').find('.qty').val(qty);
      }
      let rate = $(g).closest('.row').find('.rate').val();
      let discount = $(g).closest('.row').find('.discount').val();
      if (discount == '') {
        discount = 0;
        $(g).closest('.row').find('.discount').val(discount);
      }
      let tax = $(g).closest('.row').find('.tax').val();
      if (tax == '') {
        tax = 0;
        $(g).closest('.row').find('.tax').val(tax);
      }
      let amount = Number(qty) * Number(rate) - Number(discount) + Number(tax);

      $(g).closest('.row').find('.amount').val(amount);
      getTotal();
    }
  });
}

function calculate_price(g) {
  let qty = $(g).closest('.row').find('.qty').val();
  let rate = $(g).closest('.row').find('.rate').val();
  let discount = $(g).closest('.row').find('.discount').val();
  let tax = $(g).closest('.row').find('.tax').val();
  let amount = Number(qty) * Number(rate) - Number(discount) + Number(tax);

  $(g).closest('.row').find('.amount').val(amount);
  getTotal();
}
