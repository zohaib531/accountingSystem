function removeParentElement(e){
    if($(e).parent().parent().find('input[name="debit_amounts[]"]').val()>= 0){
        let elem = $(e).parent().parent().parent().parent().find('input[id="debit-amount"]');
        elem.val(parseFloat(elem.val().replace(',','')) - parseFloat($(e).parent().parent().find('input[name="debit_amounts[]"]').val().replace(',','')));
    }
    if($(e).parent().parent().find('input[name="credit_amounts[]"]').val()>= 0){
        let elem = $(e).parent().parent().parent().parent().find('input[id="credit-amount"]');
        elem.val(parseFloat(elem.val().replace(',','')) - parseFloat($(e).parent().parent().find('input[name="credit_amounts[]"]').val().replace(',','')));
    }
    $(e).parent().parent().remove();

    let totalDebit = getTotalOfTargetSide('commonDebit');
    let totalCredit = getTotalOfTargetSide('commonCredit');
    let differenceBetweenDebitCredit = 0;
    let labelTxt = "Difference";
    let entryTxt = "";
    if((totalDebit-totalCredit)>0){
        differenceBetweenDebitCredit = parseFloat(totalDebit-totalCredit).toFixed(2);
        labelTxt = "Credit";
        entryTxt ="credit";
    }
    else if((totalCredit-totalDebit)>0){
        differenceBetweenDebitCredit = parseFloat(totalCredit-totalDebit).toFixed(2);
        labelTxt = "Debit";
        entryTxt ="debit";
    }else if((totalCredit-totalDebit)==0){
        $('.differenceLabel').text(labelTxt);
        $('.differenceInput').val(0);
        $('.differenceRow').addClass('d-none');
        $('.differenceEntryCheck').addClass('d-none');
        return false;
    }
    $('.differenceLabel').html("<b>"+labelTxt+"</b> difference of "+"<b>"+differenceBetweenDebitCredit+"</b> do you want to adjust?");
    $('.differenceInput').val(differenceBetweenDebitCredit);
    $('#suspense_amount').val(differenceBetweenDebitCredit);
    $('#suspense_amount').attr('data-val' , differenceBetweenDebitCredit);
    $('#suspense_entry').val(entryTxt);
    $('.differenceRow').removeClass('d-none');
    $('.differenceEntryCheck').removeClass('d-none');
    let debitElem = $('input[id="debit-amount"]');
    debitElem.val(totalDebit);
    debitElem.attr('data-val',totalDebit);
    let creditElem = $('input[id="credit-amount"]');
    creditElem.val(totalCredit);
    creditElem.attr('data-val',totalCredit);
}




const totalDebitAmount=(e)=>{

    // Total Debit Amount
    let totalDebit = 0.00;
    let allDebitAmount = document.getElementsByClassName('commonDebit')
    for(let singleDebit of allDebitAmount){
        totalDebit += parseFloat(singleDebit.getAttribute('data-val').replace(',',''));
    }
    let targetElem =  $(e).parent().parent().parent().parent().parent().parent().find('input[id="debit-amount"]');
    targetElem.val(totalDebit.toFixed(2));
    targetElem.attr('data-val', totalDebit.toFixed(2));
    return totalDebit.toFixed(2);

}


const totalCreditAmount=(e)=>{

    // Total Credit Amount
    let totalCredit = 0.00;
    let allCreditAmmount = document.getElementsByClassName('commonCredit')
    for(let singleCredit of allCreditAmmount){
        totalCredit += parseFloat(singleCredit.getAttribute('data-val').replace(',',''));
    }
    let targetElem = $(e).parent().parent().parent().parent().parent().parent().find('input[id="credit-amount"]');
    targetElem.val(totalCredit.toFixed(2));
    targetElem.attr('data-val', totalCredit.toFixed(2));
    return totalCredit.toFixed(2);
}

const totalShouldSame = (elem)=>{
    if($(elem).parent().parent().parent().parent().parent().parent().find('input[id="checkedEntery"]').is(":checked")){
        let totalDebit = getTotalOfTargetSide('commonDebit');
        let totalCredit = getTotalOfTargetSide('commonCredit');
        if(parseFloat(totalDebit - totalCredit)>0){
            let targetElem = $(elem).parent().parent().parent().parent().parent().parent().find('input[id="credit-amount"]');
            targetElem.val((parseFloat(totalCredit) + parseFloat(totalDebit-totalCredit)).toFixed(2));
        }
        else if(parseFloat(totalCredit-totalDebit)>0){
            let targetElem = $(elem).parent().parent().parent().parent().parent().parent().find('input[id="debit-amount"]');
            targetElem.val((parseFloat(totalDebit) + parseFloat(totalCredit-totalDebit)).toFixed(2));
        }
    }
}

const getTotalOfTargetSide=(targetClass)=>{
    let total = 0.00;
    let allAmount = document.getElementsByClassName(targetClass);
    for(let single of allAmount){
        total += parseFloat(single.getAttribute('data-val').replace(',',''));
    }
    return (total).toFixed(2);
}


const createAmount = (e, action, voucherType)=>{
    if (voucherType) {
        if (action) {
            if($(e).parent().parent().parent().next('div').children('div').children('div').children('input').attr('data-val') >= 0){
                let elem = $(e).parent().parent().parent().next('div').children('div').children('div').children('input');
                let amount = elem.parent().parent().parent().next('div').children('div').children('div').children('input');

                if ( $(e).attr('data-val') >=0 && elem.attr('data-val') >=0 ) {
                    getValue(e)
                    getValue(elem[0])
                    amount.val(($(e).attr('data-val') * elem.attr('data-val')).toFixed(2));
                    amount.attr('data-val', ($(e).attr('data-val') * elem.attr('data-val')).toFixed(2));
                }

            }
        }else{
            if($(e).parent().parent().parent().prev('div').children('div').children('div').children('input').attr('data-val') >= 0){
                let elem = $(e).parent().parent().parent().prev('div').children('div').children('div').children('input');
                let amount = $(e).parent().parent().parent().next('div').children('div').children('div').children('input');

                if ($(e).attr('data-val') >=0 && elem.attr('data-val') >=0 ) {
                    getValue(e)
                    getValue(elem[0])
                    amount.val(($(e).attr('data-val') * elem.attr('data-val')).toFixed(2));
                    amount.attr('data-val', ($(e).attr('data-val') * elem.attr('data-val')).toFixed(2));
                }

            }

        }

        







    }else{
        if(parseFloat($(e).val()) >= 0){
            $(e).attr('data-val',$(e).val());
        }
    }

    let differenceBetweenDebitCredit = 0;
    let labelTxt = "Difference";
    let entryTxt = "";
    if(!voucherType){
        getValue(e)
        let totalDebit = totalDebitAmount(e);
        let totalCredit = totalCreditAmount(e);
        if((totalDebit-totalCredit)>0){
            differenceBetweenDebitCredit = parseFloat(totalDebit-totalCredit);
            labelTxt = "Credit";
            entryTxt ="credit";
        }
        else if((totalCredit-totalDebit)>0){
            differenceBetweenDebitCredit = parseFloat(totalCredit-totalDebit);
            labelTxt = "Debit";
            entryTxt ="debit";
        }else if((totalCredit-totalDebit)==0){
            $(e).parent().parent().parent().parent().parent().parent().find('.differenceLabel').text(labelTxt);
            $(e).parent().parent().parent().parent().parent().parent().find('.differenceInput').val(0);
            $(e).parent().parent().parent().parent().parent().parent().find('.differenceRow').addClass('d-none');
            $(e).parent().parent().parent().parent().parent().parent().find('.differenceEntryCheck').addClass('d-none');
            commonCodeForSuspenseEntryDifference(e);
            return false;
        }
    }


    $(e).parent().parent().parent().parent().parent().parent().find('.differenceLabel').html("<b>"+labelTxt+"</b> difference of "+"<b>"+differenceBetweenDebitCredit+"</b> do you want to adjust?");
    $(e).parent().parent().parent().parent().parent().parent().find('.differenceInput').val(differenceBetweenDebitCredit);
    $(e).parent().parent().parent().parent().parent().parent().find('#suspense_amount').val(differenceBetweenDebitCredit);
    $(e).parent().parent().parent().parent().parent().parent().find('#suspense_amount').attr('data-val' , differenceBetweenDebitCredit);
    $(e).parent().parent().parent().parent().parent().parent().find('#suspense_entry').val(entryTxt);
    $(e).parent().parent().parent().parent().parent().parent().find('.differenceRow').removeClass('d-none');
    $(e).parent().parent().parent().parent().parent().parent().find('.differenceEntryCheck').removeClass('d-none');
    commonCodeForSuspenseEntryDifference(e);
    // getValue(e)

}

const commonCodeForSuspenseEntryDifference = (e)=>{
    let totalDebit = totalDebitAmount(e);
    let totalCredit = totalCreditAmount(e);
    let differenceBetweenDebitCredit = 0;
    let labelTxt = "Difference";
    let entryTxt = "";
    if((totalDebit-totalCredit)>0){
        differenceBetweenDebitCredit = parseFloat(totalDebit-totalCredit);
        labelTxt = "Credit";
        entryTxt ="credit";
    }
    else if((totalCredit-totalDebit)>0){
        differenceBetweenDebitCredit = parseFloat(totalCredit-totalDebit);
        labelTxt = "Debit";
        entryTxt ="debit";
    }else if((totalCredit-totalDebit)==0){
        $(e).parent().parent().parent().parent().parent().parent().find('.differenceLabel').text(labelTxt);
        $(e).parent().parent().parent().parent().parent().parent().find('.differenceInput').val(0);
        $(e).parent().parent().parent().parent().parent().parent().find('.differenceRow').addClass('d-none');
        $(e).parent().parent().parent().parent().parent().parent().find('.differenceEntryCheck').addClass('d-none');
        totalShouldSame(e);
        return false;
    }

    differenceBetweenDebitCredit= differenceBetweenDebitCredit.toFixed(2);

    $(e).parent().parent().parent().parent().parent().parent().find('.differenceLabel').html("<b>"+labelTxt+"</b> difference of "+"<b>"+differenceBetweenDebitCredit+"</b> do you want to adjust?");
    $(e).parent().parent().parent().parent().parent().parent().find('.differenceInput').val(differenceBetweenDebitCredit);
    $(e).parent().parent().parent().parent().parent().parent().find('#suspense_amount').val(differenceBetweenDebitCredit);
    $(e).parent().parent().parent().parent().parent().parent().find('#suspense_amount').attr('data-val' , differenceBetweenDebitCredit);
    $(e).parent().parent().parent().parent().parent().parent().find('#suspense_entry').val(entryTxt);
    $(e).parent().parent().parent().parent().parent().parent().find('.differenceRow').removeClass('d-none');
    $(e).parent().parent().parent().parent().parent().parent().find('.differenceEntryCheck').removeClass('d-none');
    totalShouldSame(e);
}

const commonCodeForSuspenseEntry = (elem,targetAction)=>{
    let differenceBetweenDebitCredit = $(elem).parent().parent().parent().parent().parent().parent().find('input[id="differenceInput"]').val();
    let suspenseEntryType = $(elem).parent().parent().parent().parent().parent().parent().find('input[id="suspense_entry"]').val();
    let targetSide = suspenseEntryType=="debit"?'debit-amount':'credit-amount';
    let targetClassForTotal = suspenseEntryType=="debit"?'commonDebit':'commonCredit';
    let targetElem = $(elem).parent().parent().parent().parent().parent().parent().find(`input[id="${targetSide}"]`);
    let targetElemVal = targetElem.attr('data-val');
    let targetTotalAmount = parseFloat(targetSide == "debit-amount"? totalDebitAmount(elem): totalCreditAmount(elem));
    if(targetAction=="add"){
        targetTotalAmount = targetTotalAmount + parseFloat(differenceBetweenDebitCredit);
        targetElem.val(targetTotalAmount);
        targetElem.attr('data-val' ,targetTotalAmount);
    }else{
        targetTotalAmount = targetTotalAmount - parseFloat(differenceBetweenDebitCredit);
        targetElem.val(targetTotalAmount);
        targetElem.attr('data-val' , targetTotalAmount);
    }

    let differenceInputRevertVal = 0;
    if(targetAction!="add"){
        differenceInputRevertVal = $(elem).parent().parent().parent().parent().parent().parent().find('#suspense_amount').attr('data-val');
        targetElem.attr('data-val', targetElem.val() - (+differenceInputRevertVal))
    }else{
        differenceInputRevertVal = 0;
    }
    differenceInputRevertVal =  targetAction!="add" ? $(elem).parent().parent().parent().parent().parent().parent().find('#suspense_amount').attr('data-val') : 0;


    if(targetAction!="add")
    {
        let targetRevertElem = suspenseEntryType=="debit"?'debit-amount':'credit-amount';
        $(elem).parent().parent().parent().parent().parent().parent().find(`input[id="${targetRevertElem}"]`).val(getTotalOfTargetSide(targetClassForTotal));
    }
    $(elem).parent().parent().parent().parent().parent().parent().find('.differenceInput').val(differenceInputRevertVal);
}

const suspenseAccountEntryVerification = (e)=>{$(e).is(":checked")? commonCodeForSuspenseEntry(e,'add') : commonCodeForSuspenseEntry(e,'minus'); }

function getValue(e) {
    let inputValue = e.value;
    let withoutComa = inputValue.toLocaleString().replace(/\D/g,'');
    e.setAttribute('value', withoutComa/100);
    e.setAttribute('data-val', withoutComa/100);
}


