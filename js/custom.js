

$('#addBtn').on('click', function () {
    let inp_name = $('#addForm [name=name]').val();
    let inp_placeholder = $('#addForm [name=placeholder]').val();
    let inp_type = $('#addForm [name=data_type]').val();


    let html = ``;

    if (inp_type == 'radio' || inp_type == 'checkbox') {
        html = `<div class="row" id="inp_${inp_name}">
                    <div class="col-md-6">
                    <div class="form-check">
                        <input type="${inp_type}" name="${inp_name}" placeholder="${inp_placeholder}" class="form-check-input">
                        <label class="form-check-label">${inp_placeholder}</label>
                    </div>
                    </div>
                    <div class="col-1">
                        <span data-name="${inp_name}" class="btn btn-danger BtnDestroy">DEL</span>
                    </div>
                </div>`;
    } else {
        html = `<div class="row" id="inp_${inp_name}">
                    <div class="col-md-6">
                        <div class="mb-4 col-md-8 mx-2">
                            <input type="${inp_type}" name="${inp_name}" placeholder="${inp_placeholder}" class="form-control">
                        </div>
                    </div>
                    <div class="col-1">
                        <span data-name="${inp_name}" class="btn btn-danger BtnDestroy">DEL</span>
                    </div>
                </div>`;
    }
    $('#formDiv').append(html);
    $('#addForm [name=name]').val('');
    $('#addForm [name=placeholder]').val('');
    $('#addForm [name=data_type]').val('');
});

$(document).on('click', '.BtnDestroy', function () {
    let data_name = $(this).attr('data-name');
    $(`#inp_${data_name}`).remove();
    console.log(data_name);
});


// -----------------------
$(document).on('click', '.BtnAdd', function () {
    let addEvent = $('.FormColumn:last').clone();

    $('input', addEvent).val('');
    $('select option',addEvent).removeAttr('selected');
    addEvent.find('.error').remove('label.error');
    addEvent.find('.error').removeClass('error');
    addEvent.appendTo('#FormTable');

    $('td.SrNo').each(function (index, element) {
        $(element).text(index + 1);
    });

    $('.product_id').each(function(index){
        $(this).attr('name', `product_id[${index}]`);
    });

    $('.form_name').each((function(index){
        $(this).attr('name', `name[${index}]`);
        $(this).rules('remove', 'required');
        $(this).rules('add', {required:true});
        // $(this).removeClass('error');
    }))


    $('.form_qty').each(function(index){
        $(this).attr('name', `qty[${index}]`);
        $(this).rules('remove', 'required');
        $(this).rules('add', {required:true});
        // $(this).siblings('.error').remove();
    })

    
});


$(document).on('click', '.BtnSub', function () {
    if ($('#FormTable tr').length != 1) {
        let val = $(this).closest('.SrNo').text();
        console.log(val);
        setTimeout(() => {
            $('td.SrNo').each(function (index, element) {
                $(element).text(index + 1);
            });
        }, 0.01);
        $(this).parents('.FormColumn').remove();
        Total();
    }
});

$(document).on('change', '.FormColumn .form_name', function () {
    let product_price = $(this).find(':selected').data('price');
    let product_rate = $(this).closest('tr.FormColumn').find('.form_rate');
    let product_total = $(this).closest('tr.FormColumn').find('.form_total');
    let product_qty = $(this).closest('tr.FormColumn').find('.form_qty');
    product_rate.val(parseFloat(product_price).toFixed(2));

    console.log(product_price);
    if (product_price != null) {
        product_total.val((product_qty.val() * product_price).toFixed(2));
    } else if (product_price == '') {
        product_total.val('');
        product_qty.val('');
    }
});

$(document).on('input', '.FormColumn .form_qty', function () {
    let product_qty = $(this).val();
    let product_total = $(this).closest('tr.FormColumn').find('.form_total');
    let product_rate = $(this).closest('tr.FormColumn').find('.form_rate').val();
    product_total.val((product_qty * product_rate).toFixed(2));
});

$(document).on('input', 'input', function () {
    Total();
});

$(document).on('change', 'select', function () {

    Total();
});

Total();

function Total() {
    // $.ajax({
    //     type: "GET",
    //     url: "../php/Product.php",
    //     data: "data",
    //     dataType: "json",
    //     success: function (response) {
    //         // console.log(response);
    //         let res = JSON.parse(response);
    //         console.log(res);
    //     }
    // });

    let sub_total = 0;
    let discount = parseFloat($('#TotalForm [name=discount]').val());
    let vat_tex = parseFloat($('#TotalForm [name=vat_tex]').val());
    let grand_total = 0;

    $('.FormColumn .form_total').each(function (index, element) {
        if (!isNaN(parseFloat($(element).val()))) {
            sub_total += parseFloat($(element).val());
        }
    });

    grand_total = sub_total;
    !isNaN(discount) ? grand_total = sub_total - discount : grand_total = sub_total;
    !isNaN(vat_tex) ? vat_tex = (grand_total / 100) * vat_tex : 0;
    $('#SubTotal').text(sub_total);

    if (!isNaN(vat_tex)) {
        $('#GrandTotal').text((grand_total + vat_tex).toFixed(2));
        $('#vat_per').text(vat_tex.toFixed(2));
    } else {
        $('#GrandTotal').text(grand_total.toFixed(2));
        $('#vat_per').text(0);
    }
    
}


// Jquery Validate
$('#FormAdd').validate({
    rules: {
        'name[0]': {
            required: true
        },
        'qty[0]': {
            required: true
        }
    },
});

