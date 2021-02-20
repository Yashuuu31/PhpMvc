
$(document).on('change', '#FormTable [name=name]', function(){
    let product_price = $(this).find(':selected').data('price');
    let product_rate = $(this).closest('tr.FormColumn').find('td [name=rate]');
    let product_total = $(this).closest('tr.FormColumn').find('td [name=total]');
    let product_qty = $(this).closest('tr.FormColumn').find('td [name=qty]');
    product_rate.val(product_price);
    if(product_price != null){
        product_total.val(product_qty.val() * product_price);;
        CheckGrandTotal();
        CheckVatTex();
    }else if(product_price == ''){
        product_total.val('');
        product_qty.val('');
    }
});

$(document).on('input','.FormColumn [name=qty]',function(){
    let product_qty = $(this).val();
    let product_total = $(this).closest('tr.FormColumn').find('td [name=total]');
    let product_rate = $(this).closest('tr.FormColumn').find('td [name=rate]').val();
    product_total.val(product_qty * product_rate);
    CheckGrandTotal();
});

function CheckSubTotal(){
    let sub_total = 0;
    let discount = parseInt($('#TotalForm [name=discount]').val());
    let garnd_total = sub_total - discount;
    let vat_tex = parseInt($('#TotalForm [name=vat_tex]').val());

    $('#FormTable [name=total]').each(function(index,element){
        if(! isNaN(parseInt($(element).val()))){
            sub_total += parseInt($(element).val());    
        }
    });

    !isNaN(vat_tex) ? garnd_total = (garnd_total / 100) * vat_tex : garnd_total = sub_total;
    !isNaN(discount) ? garnd_total = sub_total - discount : garnd_total = sub_total;

    $('#SubTotal').text(sub_total);
    $('#GrandTotal').text(garnd_total);
}


function CheckGrandTotal(){
    CheckSubTotal();
    CheckDiscount();
    CheckVatTex();

    console.log("!@#");
}

function CheckDiscount(){
    let sub_total =  parseInt($('#SubTotal').text());
    let discount = parseInt($('#TotalForm [name=discount]').val());
    let vat_tex = parseInt($('#TotalForm [name=vat_tex]').val());
    if(! isNaN(discount)){
        $('#GrandTotal').text(sub_total - discount);
    }else{
        $('#GrandTotal').text(sub_total);
    }

    $('#TotalForm [name=discount]').on('input', function(){
        discount = parseInt($(this).val());
        sub_total =  $('#SubTotal').text();
        if(! isNaN(discount)){
            $('#GrandTotal').text(sub_total - discount);
        }else{
            $('#GrandTotal').text(sub_total);
        }
        // CheckGrandTotal();
        CheckSubTotal();
        CheckVatTex();
    });
}


function CheckVatTex(){
    let sub_total =  parseInt($('#SubTotal').text());
    let discount = $('#TotalForm [name=discount]').val();
    let vat_tex = $('#TotalForm [name=vat_tex]').val();
    let grand_total = sub_total - discount;


    $('#TotalForm [name=vat_tex]').on('input', function(){
        CheckSubTotal();
        CheckDiscount();
        vat_tex = parseInt($(this).val());
        sub_total =  parseInt($('#SubTotal').text());
        discount = $('#TotalForm [name=discount]').val();
        grand_total = sub_total - discount;
        if(!isNaN(vat_tex)){
            vat_tex = (grand_total / 100) * vat_tex;
            $('#GrandTotal').text(grand_total + vat_tex);
        }else{
            grand_total = sub_total - discount;
            $('#GrandTotal').text(grand_total);
        }
        !isNaN(vat_tex) ? $('#vat_per').text(vat_tex) : $('#vat_per').text('0');    
    })

    if(!isNaN(vat_tex)){
        vat_tex = (grand_total / 100) * vat_tex;
        !isNaN(vat_tex) ? $('#vat_per').text(vat_tex) : $('#vat_per').text('0');
        $('#GrandTotal').text(grand_total + vat_tex);
    }else{
        grand_total = sub_total - discount;
        $('#GrandTotal').text(grand_total);
    }
}
