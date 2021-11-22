
 // setting current date code Start
$(document).ready(function() {
    var today = new Date().toISOString().split('T')[0];
    $('#val-date').val(today);
})

// setting current date code end



 /*=====================================================
    when input number in debit section credit is disabled
    =====================================================*/

    const disableCreditInput = (e) =>{
        let creditInput = e.parentNode.parentNode.parentNode.nextElementSibling.children[0].children[1].children[0];
        if (e.value != '' && e.value > 0) {
            creditInput.setAttribute('readonly','true');
            creditInput.value = 0;

        }else{
            creditInput.removeAttribute('readonly');
        }

        // Total Debit Amount
        let totalDebit = 0;
        let allDebitAmmount = document.getElementsByClassName('commonDebit')
        for(let singleDebit of allDebitAmmount){
            totalDebit += +singleDebit.value;
        }
        $('#debit-amount').val(totalDebit);
        // Total Debit Amount



    }

    /*=====================================================
    when input number in debit section credit is disabled
    =====================================================*/


    /*=====================================================
    when input number in credit section debit is disabled
    =====================================================*/


    const disableDebitInput = (e) =>{
        let debitInput = e.parentNode.parentNode.parentNode.previousElementSibling.children[0].children[1].children[0];
        if (e.value != '' && e.value > 0) {
            debitInput.setAttribute('readonly','true');
            debitInput.value = 0;
        }else{
            debitInput.removeAttribute('readonly');
        }


        // Total Credit Amount
        let totalCredit = 0;
        let allCreditAmmount = document.getElementsByClassName('commonCredit')
        for(let singleCredit of allCreditAmmount){
            totalCredit += +singleCredit.value;
        }
        $('#credit-amount').val(totalCredit);
        // Total Credit Amount

    }


    /*=====================================================
    when input number in credit section debit is disabled
    =====================================================*/






    const removeParentElement = (e)=>{
        e.parentNode.parentNode.remove()
    }
