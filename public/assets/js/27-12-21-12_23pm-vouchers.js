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
        totalDebit += +singleDebit.value;
    }
    let targetElem =  $(e).parent().parent().parent().parent().parent().parent().find('input[id="debit-amount"]');
    targetElem.val(totalDebit);
    return targetElem.val();
}


const totalCreditAmount=(e)=>{
    // Total Credit Amount
    let totalCredit = 0;
    let allCreditAmmount = document.getElementsByClassName('commonCredit')
    for(let singleCredit of allCreditAmmount){
        totalCredit += +singleCredit.value;
    }
    let targetElem = $(e).parent().parent().parent().parent().parent().parent().find('input[id="credit-amount"]');
    targetElem.val(totalCredit);
    return targetElem.val();
}

const totalShouldSame = (elem)=>{
    if($(elem).parent().parent().parent().parent().parent().parent().find('input[id="checkedEntery"]').is(":checked")){
        let totalDebit = getTotalOfTargetSide('commonDebit');
        let totalCredit = getTotalOfTargetSide('commonCredit');
        if((totalDebit-totalCredit)>0){
            let targetElem = $(elem).parent().parent().parent().parent().parent().parent().find('input[id="credit-amount"]');
            targetElem.val(parseInt(targetElem.val()) + (totalDebit-totalCredit));
        }
        else if((totalCredit-totalDebit)>0){
            let targetElem = $(elem).parent().parent().parent().parent().parent().parent().find('input[id="debit-amount"]');
            targetElem.val(parseInt(targetElem.val()) + (totalCredit-totalDebit));
        }
    }
}

const getTotalOfTargetSide=(targetClass)=>{
    let total = 0;
    let allAmount = document.getElementsByClassName(targetClass);
    for(let single of allAmount){
        console.log(single);
        total += +single.value;
    }
    return total;
}


const createAmount = (e, action, voucherType)=>{

    if (voucherType) {
        if (action) {
            if($(e).parent().parent().parent().next('div').children('div').children('div').children('input').val() >= 0){
                let elem = $(e).parent().parent().parent().next('div').children('div').children('div').children('input');
                let amount = elem.parent().parent().parent().next('div').children('div').children('div').children('input');
                if ( $(e).val() >=0 && elem.val() >=0 ) {
                    amount.val($(e).val() * elem.val());
                }
            }
        }else{
            if($(e).parent().parent().parent().prev('div').children('div').children('div').children('input').val() >= 0){
                let elem = $(e).parent().parent().parent().prev('div').children('div').children('div').children('input');
                let amount = $(e).parent().parent().parent().next('div').children('div').children('div').children('input');
                if ($(e).val() >=0 && elem.val()>=0) {
                    amount.val($(e).val() * elem.val());
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
    $(e).parent().parent().parent().parent().parent().parent().find('#suspense_entry').val(entryTxt);
    $(e).parent().parent().parent().parent().parent().parent().find('.differenceRow').removeClass('d-none');
    $(e).parent().parent().parent().parent().parent().parent().find('.differenceEntryCheck').removeClass('d-none');
    totalShouldSame(e);
    // console.log("createAmount");
    // commonCodeForSuspenseEntryDifference(e);

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

    $(e).parent().parent().parent().parent().parent().parent().find('.differenceLabel').html("<b>"+labelTxt+"</b> difference of "+"<b>"+differenceBetweenDebitCredit+"</b> do you want to adjust?");
    $(e).parent().parent().parent().parent().parent().parent().find('.differenceInput').val(differenceBetweenDebitCredit);
    $(e).parent().parent().parent().parent().parent().parent().find('#suspense_amount').val(differenceBetweenDebitCredit);
    $(e).parent().parent().parent().parent().parent().parent().find('#suspense_entry').val(entryTxt);
    $(e).parent().parent().parent().parent().parent().parent().find('.differenceRow').removeClass('d-none');
    $(e).parent().parent().parent().parent().parent().parent().find('.differenceEntryCheck').removeClass('d-none');
    totalShouldSame(e);
}

const commonCodeForSuspenseEntry = (elem,targetAction)=>{
    console.log("commonCodeForSuspenseEntry");
    let differenceBetweenDebitCredit = parseInt($(elem).parent().parent().parent().parent().parent().parent().find('input[id="differenceInput"]').val());
    let suspenseEntryType = $(elem).parent().parent().parent().parent().parent().parent().find('input[id="suspense_entry"]').val();
    let targetSide = suspenseEntryType=="debit"?'debit-amount':'credit-amount';
    let targetClassForTotal = suspenseEntryType=="debit"?'commonDebit':'commonCredit';
    let targetElem = $(elem).parent().parent().parent().parent().parent().parent().find(`input[id="${targetSide}"]`);
    let targetElemVal = parseInt(targetElem.val());
    targetAction=="add"? (targetElem.val(targetElemVal + differenceBetweenDebitCredit)) : (targetElem.val(targetElemVal - differenceBetweenDebitCredit));
    differenceInputRevertVal =  targetAction!="add"? parseInt($(elem).parent().parent().parent().parent().parent().parent().find('#suspense_amount').val()):0;
    if(targetAction!="add")
    {
        let targetRevertElem = suspenseEntryType=="debit"?'debit-amount':'credit-amount';
        $(elem).parent().parent().parent().parent().parent().parent().find(`input[id="${targetRevertElem}"]`).val(getTotalOfTargetSide(targetClassForTotal));
    }
    $(elem).parent().parent().parent().parent().parent().parent().find('.differenceInput').val(differenceInputRevertVal);
}

const suspenseAccountEntryVerification = (e)=>{$(e).is(":checked")? commonCodeForSuspenseEntry(e,'add') : commonCodeForSuspenseEntry(e,'minus'); }
