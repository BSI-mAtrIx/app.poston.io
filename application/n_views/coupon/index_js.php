<script>
    $(document).on('click', '.generate-coupon-btn', function () {
        var couponsCount = +$('#count_of_coupons').val();
        var packageId = $('#packageList').val();
        var hidden_id = $('#hidden_id').val();
        var coupon_url = "<?php echo $generate_coupons_url; ?>";


        $.ajax({
            type: 'POST',
            url: coupon_url,
            data: {couponsCount: couponsCount, hidden_id: hidden_id, packageId: packageId},
            dataType: 'JSON',
            success: function (response) {
                $('.responseInfo').remove();
                if (response.type == 'ERROR') {
                    $('.generate_coupons').prepend(`<div class="responseInfo alert alert-danger">${response.msg}</div>`)
                } else {
                    $('.generate_coupons').prepend(`<div class="responseInfo alert alert-success">${response.msg}</div>`)
                    var coupons = response.data;
                    var coupons_id = [];
                    $([document.documentElement, document.body]).animate({
                        scrollTop: +$("#packagesList").height() + +$("#packagesList").offset().top
                    }, 2000);
                    coupons.forEach((elem, index) => {
                        var element = `<tr data-coupon-id="${elem.id}">
									<td> ${elem.package_name} </td>
									<td> ${elem.code} </td>
									<td> ${elem.created_on} </td>
									<td> ${elem.status} </td>
								</tr>`
                        $('#packagesList').append(element);
                        coupons_id.push(elem.id)

                    })
                    $('#last_generated_value').val(coupons_id);
                    $('.export_button_block').show();


                }
            }
        });
    })

</script>