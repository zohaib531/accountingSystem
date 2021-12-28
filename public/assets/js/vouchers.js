function removeParentElement(e){
    if($(e).parent().parent().find('input[name="debit_amounts[]"]').val()>= 0){
        let elem = $(e).parent().parent().parent().parent().find('input[id="debit-amount"]');
        elem.val(elem.val() - $(e).parent().parent().find('input[name="debit_amounts[]"]').val());
    }
    if($(e).parent().parent().find('input[name="credit_amounts[]"]').val()>= 0){
        let elem = $(e).parent().parent().parent().parent().find('input[id="credit-amount"]');
        elem.val(elem.val() - $(e).parent().parent().find('input[name="credit_amounts[]"]').val());
    }
    e.parentNode.parentNode.remove();
}




const totalDebitAmount=(e)=>{

    // Total Debit Amount
    let totalDebit = 0;
    let allDebitAmount = document.getElementsByClassName('commonDebit')
    for(let singleDebit of allDebitAmount){
        totalDebit += +singleDebit.getAttribute('data-val');
    }
    let targetElem =  $(e).parent().parent().parent().parent().parent().parent().find('input[id="debit-amount"]');
    targetElem.val(totalDebit.toFixed(2));
    targetElem.attr('data-val', totalDebit.toFixed(2));

    return targetElem.attr('data-val');

}


const totalCreditAmount=(e)=>{

    // Total Credit Amount
    let totalCredit = 0;
    let allCreditAmmount = document.getElementsByClassName('commonCredit')
    for(let singleCredit of allCreditAmmount){
        totalCredit += +singleCredit.getAttribute('data-val');
    }
    let targetElem = $(e).parent().parent().parent().parent().parent().parent().find('input[id="credit-amount"]');
    targetElem.val(totalCredit.toFixed(2));
    targetElem.attr('data-val', totalCredit.toFixed(2));
    return targetElem.attr('data-val');
}

const totalShouldSame = (elem)=>{
    if($(elem).parent().parent().parent().parent().parent().parent().find('input[id="checkedEntery"]').is(":checked")){
        let totalDebit = getTotalOfTargetSide('commonDebit');
        let totalCredit = getTotalOfTargetSide('commonCredit');
        if((totalDebit - totalCredit)>0){
            let targetElem = $(elem).parent().parent().parent().parent().parent().parent().find('input[id="credit-amount"]');
            targetElem.val((parseFloat(targetElem.val()) + (totalDebit-totalCredit)).toFixed(2));
        }
        else if((totalCredit-totalDebit)>0){
            let targetElem = $(elem).parent().parent().parent().parent().parent().parent().find('input[id="debit-amount"]');
            targetElem.val((parseFloat(targetElem.val()) + (totalCredit-totalDebit)).toFixed(2));
        }
    }
}

const getTotalOfTargetSide=(targetClass)=>{
    let total = 0;
    let allAmount = document.getElementsByClassName(targetClass);
    for(let single of allAmount){
        total += +single.getAttribute('data-val');
    }
    return total;
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
    }
    // $(e).attr('name').split('_')[0] =="debit"? totalDebitAmount(e) :totalCreditAmount(e);
    // totalDebitAmount(e);
    // totalCreditAmount(e);
    // let totalDebit = $(e).parent().parent().parent().parent().parent().parent().find('input[id="debit-amount"]').val();
    // let totalCredit = $(e).parent().parent().parent().parent().parent().parent().find('input[id="credit-amount"]').val();


    let totalDebit = totalDebitAmount(e);
    let totalCredit = totalCreditAmount(e);
    getValue(e);
    let differenceBetweenDebitCredit = 0;
    let labelTxt = "Difference";
    let entryTxt = "";
    if((totalDebit-totalCredit)>0){
        differenceBetweenDebitCredit = (totalDebit-totalCredit);
        labelTxt = "Credit";
        entryTxt ="credit";
    }
    else if((totalCredit-totalDebit)>0){
        differenceBetweenDebitCredit = (totalCredit-totalDebit);
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

    $(e).parent().parent().parent().parent().parent().parent().find('.differenceLabel').html("<b>"+labelTxt+"</b> difference of "+"<b>"+differenceBetweenDebitCredit+"</b> do you want to adjust?");
    $(e).parent().parent().parent().parent().parent().parent().find('.differenceInput').val(differenceBetweenDebitCredit);
    $(e).parent().parent().parent().parent().parent().parent().find('#suspense_amount').val(differenceBetweenDebitCredit);
    $(e).parent().parent().parent().parent().parent().parent().find('#suspense_amount').attr('data-val' , differenceBetweenDebitCredit);
    $(e).parent().parent().parent().parent().parent().parent().find('#suspense_entry').val(entryTxt);
    $(e).parent().parent().parent().parent().parent().parent().find('.differenceRow').removeClass('d-none');
    $(e).parent().parent().parent().parent().parent().parent().find('.differenceEntryCheck').removeClass('d-none');
    commonCodeForSuspenseEntryDifference(e);
    totalShouldSame(e);

}

const commonCodeForSuspenseEntryDifference = (e)=>{
    let totalDebit = totalDebitAmount(e);
    let totalCredit = totalCreditAmount(e);
    let differenceBetweenDebitCredit = 0;
    let labelTxt = "Difference";
    let entryTxt = "";
    if((totalDebit-totalCredit)>0){
        differenceBetweenDebitCredit = (totalDebit-totalCredit);
        labelTxt = "Credit";
        entryTxt ="credit";
    }
    else if((totalCredit-totalDebit)>0){
        differenceBetweenDebitCredit = (totalCredit-totalDebit);
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
    console.log(targetElem);
    if(targetAction=="add"){
        console.log(targetElem.attr('data-val'),);
        targetElem.val((+targetElemVal) + (+differenceBetweenDebitCredit));
        targetElem.attr('data-val' , (+targetElemVal) + (+differenceBetweenDebitCredit));
    }else{
        targetElem.val((targetElemVal) - (+differenceBetweenDebitCredit));
        targetElem.attr('data-val' , (+targetElemVal) - (+differenceBetweenDebitCredit))
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


