<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loans</title>
    <link rel="stylesheet" href="bootstrap/bootstrap-5.1.3-dist/css/bootstrap.css" >
    <link rel = "stylesheet" href = "loan.css">
   </head> 
   <body>
  <div class = "container">
        <div class = "header"> 

          <ul class="nav nav-tabs">
            <img id="logo" src="https://www.pngitem.com/pimgs/m/153-1531279_bank-building-icon-generic-monochrome-free-bank-logo.png">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Loans</a>
            </li>
            <li class="nav-item">
              <a id= "home" class="nav-link" href="AfterLandingPage.php">Home</a>
            </li>
        </ul>
     
<div class="main">

 <div class = "first">
    
    <div class="card loans">
       
       <div class="image">
          <img src="housing.jpg">
         </div>
         <div class="title">
            <h1>
               Housing Loans</h1>
            </div>
            <div class="des">
               <div class="description">
                  
                  <p>Pride Housing Loan For Government Employees
                     <br>
                     Housing Loan for Public<br>
      Housing Loan for Public – Pradhan Mantri Awas Yojana – Housing for All</p>
   </div>
</div>
</div>

<div class="card loans">
   
   <div class="image">
      <img src="vehicle.jpg">
   </div>
   <div class="title">
      <h1>
         Vehicle Loans</h1>
      </div>
      <div class="des">
         <p>Pride Car Loan For Government Employees <br>
            Car Loan For Public<br>
            Power ride` scheme for financing two wheelers to women</p>

         </div>
      </div>

 
      
      <div class="card loans">
         
         <div class="image">
            <img src="education.png">
         </div>
         <div class="title">
            <h1>
               Education Loans</h1>
            </div>
            <div class="des">
               <p>Education loan for girl child<br>
                  Education loan for single girl child<br>
                  Education loan for all</p>
                
               </div>
            </div>
            
            
            <div class="card loans">
               
               <div class="image">
                  <img src="gold.jpg">
               </div>
               <div class="title">
                  <h1>
                     Gold Loans</h1>
                  </div>
                  <div class="des">
                     <p>Personal Gold Loan <br> Realty Gold Loan</p>
                  </div>
               </div>
            </div>
               
               <div class="second">
                  
                  <div class="card loans">
                     
                     <div class="image">
                        <img src="credit.jpg">
                     </div>
                     <div class="title">
                        <h1>
     Credit Card Loans</h1>
   </div>
   <div class="des">
      <p>Credit Card Loans for personal use<br> Credit Card Loans for business purpose</p>
   </div>
</div>

<div class="card loans">
   
   <div class="image">
      <img src="agri.png">
   </div>
   <div class="title">
      <h1>
         Agriculture Loans</h1>
      </div>
      <div class="des">
         <p>Agriculture Loans for Short term credit<br> Agriculture Loans for Long term credit</p>
      </div>
   </div>
   
   <div class="card loans">
      
      <div class="image">
         <img src="personal.jpg">
      </div>
      <div class="title">
         <h1>
            Personal Loans</h1>
         </div>
         <div class="des">
            <p>Personal Loan Scheme For Public<br>
               Personal Loan Scheme for Pensioners<br>
               Advance Against Gold and Jewellery</p>
               
            </div>
         </div>
         
         
         <div class="card loans">
            
            <div class="image">
               <img src="asset.webp">
            </div>
            <div class="title">
               <h1>
                  Loan against Asset</h1>
               </div>
               <div class="des">
                  <p>Loans Against Property<br>Loans Against Jewellery<br>Loans against securities</p>
               </div>
            </div>
         </div>
            
         <div class="loan-calculator">
          <div class="row">
              <div class="col-md-6 mx-auto">
                  <div class="card card-body text-center mt-5">
                      <h1 class="heading display-5 pb-3"> Loan Calculator</h1>
                      <form id="loan-form">
                          <div class="form-group">
                              <div class="input-group">
                                  <span class="input-group-text">₹</span>
                                  <input type="number" class="form-control" id="amount" placeholder="Loan Amount">
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="input-group">
                                  <span class="input-group-text">%</span>
                                  <input type="number" class="form-control" id="interest" placeholder="Interest">
                              </div>
                          </div>
                          <div class="form-group">
                              <input type="number" class="form-control" id="years" placeholder="Years To Repay">
                          </div>
                          <div class="form-group">
                              <input type="submit" value="Calculate" class="btn btn-dark btn-block">
                          </div>
                      </form>
                      <!-- loader here -->
                      <div id="loading">
                          <img src="https://www.icegif.com/wp-content/uploads/loading-icegif-1.gif" alt="Loading">
                          <h3 class="calculating-heading">Calculating Please Wait.</h3>
                      </div>
                      <!-- Results -->
                      <div id="results" class="pt-4">
                          <h5>Results</h5>
                          <div class="form-group">
                              <div class="input-group">
                                  <span class="input-group-text">Monthly Payment</span>
                                  <input type="number" class="form-control" id="monthly-payment" disabled>
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="input-group">
                                  <span class="input-group-text">Total Payment</span>
                                  <input type="number" class="form-control" id="total-payment" disabled>
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="input-group">
                                  <span class="input-group-text">Total Interest</span>
                                  <input type="number" class="form-control" id="total-interest" disabled>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>    
         </div>
         </div>
         <!-- <div class = "loan-calculator">
            <div class = "top">
               <h2>Loan Calculator</h2>
               <form action = "#">
         <div class = "group">
            <div class="title">Amount</div>
            <input type="text" value = "30000" class="loan-amount"/>
         </div>
         
         <div class = "group">
           <div class="title">Interest Rate</div>
           <input type="text" value = "8.5" class="interest-rate"/>
        </div>

        <div class = "group">
           <div class="title">Tenure(in months)</div>
           <input type="text" value = "240" class="loan-tenure"/>
        </div>
      </form>
   </div>

   <div class="result">
      <div class="left">
         <div class = "loan-emi">
            <h3>Loan EMI</h3>
            <div class = "value">123</div>
         </div>

         <div class = "total-interest">
            <h3>Interest Payable</h3>
           <div class = "value">1234</div>
        </div>

        
        <div class = "total-amount">
           <h3>Total Amount </h3>
           <div class = "value">12345</div>
        </div>

        <button class="calculate-btn">Calculate</button>
      </div>
      <div class="right">
         Chart
      </div>
 </div>
 </div> -->
        <!-- <script>
          const loanAmountInput=document.querySelector(".loan-amount");
          const interestRateInput=document.querySelector(".interest-rate");
          const loanTenureInput=document.querySelector(".loan-tenure");
          const loanEMIValue= document.querySelector(".loan-emi .value");
          const totalInterestValue = document.querySelector(".total-interest .value");
          const totalAmountValue = document.querySelector("total-amount .value");
          
          const calculateBtn = document.querySelector("calculate-btn");

          let loanAmount = parseFloat(loanAmountInput.value);
          let interestRate = parseFloat(interestRateInput.value);
          let loanTenure = parseFloat(loanTenureInput.value);

          let interest = interestRate/12/100;

          const calculateEMI = ()=>{
             let emi = loanAmount*interest*(Math.pow(1+interest, loanTenure)/(Math.pow(1+interest, loanTenure)-1));

             return emi;
          };
          const updateData = (emi)=>{
             loanEMIValue.innerHTML= Math.round(emi);

             let totalAmount  = Math.round(loanTenure*emi);

             totalAmountValue.innerHTML = totalAmount;

             let totalInterestPayable = Math.round(totalAmount-loanAmount);

             totalInterestValue.innerHTML = totalInterestPayable;
          };

          const init  = () => {
             let emi = calculateEMI();
             updateData(emi);
          };

          init();
        </script> -->

        <script src="loan.js"></script>
</body>
</html>