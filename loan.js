document.querySelector('#loan-form').addEventListener('submit', delayResults);

const loadingImg = document.querySelector('#loading');
const resultSection = document.querySelector('#results');

function delayResults(e){
    resultSection.style.display = "none";

    loadingImg.style.display = "block";

    setTimeout(calculateResults, 2000);
    e.preventDefault();
}


function calculateResults(){
    
    const inputAmount = document.querySelector('#amount');
    const inputInterest = document.querySelector('#interest');
    const inputYears = document.querySelector('#years');

 
    const outputMonthlyPayment = document.querySelector('#monthly-payment');
    const outputTotalPayment = document.querySelector('#total-payment');
    const outputTotalInterest = document.querySelector('#total-interest');

    const principal = parseFloat(inputAmount.value);
    const claculatedInterest = parseFloat(inputInterest.value) / 100/ 12;
    const calculatedPayments = parseFloat(inputYears.value) * 12;

   
    const computeMonthlyPayment = Math.pow(1 + claculatedInterest, calculatedPayments);
    const monthly = (principal * computeMonthlyPayment * claculatedInterest) / (computeMonthlyPayment -1);

    if(isFinite(monthly)) {
        outputMonthlyPayment.value = monthly.toFixed(2);
        outputTotalPayment.value = (monthly * calculatedPayments).toFixed(2);
        outputTotalInterest.value = ((monthly * calculatedPayments)-principal).toFixed(2);

       
        resultSection.style.display = 'block';

       
        loadingImg.style.display = 'none';

    }else{
        showError('Please Check Your Numbers');

      
        resultSection.style.display = 'none';

       
        loadingImg.style.display = 'none';
    }
}


function showError(error){

    const errorDiv = document.createElement('div');


    const card = document.querySelector('.card');
    const heading = document.querySelector('.heading')

   
    errorDiv.className = 'alert alert-danger';

    errorDiv.appendChild(document.createTextNode(error));

  
    card.insertBefore(errorDiv, heading);

   
    setTimeout(clearError, 3000);
}


function clearError(){
    document.querySelector('.alert').remove();
}
