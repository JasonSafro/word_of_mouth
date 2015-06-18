<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use PayPal\Api\Address;
use PayPal\Api\Amount;
use PayPal\Api\CreditCard;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Transaction;

//for direct paypal (all above plus bellow)
use PayPal\Api\RedirectUrls; 

//when direct paypal redirect requires following files 
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;

//to make payment using saved creadit card
use PayPal\Api\CreditCardToken;
use PayPal\Auth\OAuthTokenCredential;

session_start();

class Test_paypal extends CI_Controller {
	
    function __construct() {
        parent::__construct();   
        $this->load->model('mdgeneraldml');      
        $this->load->library('form_validation');       
        $this->form_validation->set_error_delimiters('<span class="red">', '</span>');		
    }
    
    function index()
    {
        $infoArray=array('address1'=>'3909 Witmer Road','address2'=>'Niagara Falls','city'=>'Niagara Falls','state'=>'NY','zip'=>'14305','phone'=>'716-298-1822',
            'cardType'=>'visa','creditCardNumber'=>'4417119669820331','expDateMonth'=>'11','expDateYear'=>'2019','cvv2Number'=>'012','firstName'=>'Joe','lastName'=>'Shopper','amount'=>'1.00');
       $responce= $this->__doCreditCardPayment($infoArray);
       echo '<pre>'; print_r($responce);
    }
    
     function __doCreditCardPayment($infoArray)
    {
        require APPPATH.'third_party/paypal/bootstrap.php';        

        // ### Address
        // Base Address object used as shipping or billing
        // address in a payment. [Optional]
        $addr = new Address();
        $addr->setLine1($infoArray['address1']);
        
        if($infoArray['address2']!="")
            $addr->setLine2($infoArray['address2']);
        
        $addr->setCity($infoArray['city']);
        $addr->setState($infoArray['state']);
        $addr->setPostal_code($infoArray['zip']);
        //$addr->setCountry_code($infoArray['country']);
        $addr->setCountry_code('US');
        
         if($infoArray['phone']!="")
            $addr->setPhone($infoArray['phone']);

        // ### CreditCard
        // A resource representing a credit card that can be
        // used to fund a payment.
        $card = new CreditCard();
        $card->setType($infoArray['cardType']);
        $card->setNumber($infoArray['creditCardNumber']);
        $card->setExpire_month($infoArray['expDateMonth']);
        $card->setExpire_year($infoArray['expDateYear']);
        $card->setCvv2($infoArray['cvv2Number']);
        $card->setFirst_name($infoArray['firstName']);
        
        if($infoArray['lastName']!="")
            $card->setLast_name($infoArray['lastName']);
        
        $card->setBilling_address($addr);

        // ### FundingInstrument
        // A resource representing a Payer's funding instrument.
        // Use a Payer ID (A unique identifier of the payer generated
        // and provided by the facilitator. This is required when
        // creating or using a tokenized funding instrument)
        // and the `CreditCardDetails`
        $fi = new FundingInstrument();
        $fi->setCredit_card($card);

        // ### Payer
        // A resource representing a Payer that funds a payment
        // Use the List of `FundingInstrument` and the Payment Method
        // as 'credit_card'
        $payer = new Payer();
        $payer->setPayment_method("credit_card");
        $payer->setFunding_instruments(array($fi));

        // ### Amount
        // Let's you specify a payment amount.
        $amount = new Amount();
        $amount->setCurrency("USD");
        $amount->setTotal($infoArray['amount']);

        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it. Transaction is created with
        // a `Payee` and `Amount` types
        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription("This is the payment description.");

        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent as 'sale'
        $payment = new Payment();
        $payment->setIntent("sale");
        $payment->setPayer($payer);
        $payment->setTransactions(array($transaction));



        // ### Create Payment
        // Create a payment by posting to the APIService
        // using a valid ApiContext (See bootstrap.php for more on `ApiContext`)
        // The return object contains the status;
        
        $returnInfo=array('status'=>'','successData'=>'','payPalTransactionId'=>'','errorData'=>'','errorExceptionMessage'=>'');
        try {
                $payment->create($apiContext);
        } catch (PayPal\Exception\PPConnectionException $ex) {
                $returnInfo['status']='fail';
                $returnInfo['errorData']=$ex->getData();
                $returnInfo['errorExceptionMessage']=$ex->getMessage().PHP_EOL;
                
                //echo "Exception: " . $ex->getMessage().PHP_EOL;
                //echo '<pre>'; print_r($ex->getData());
                return $returnInfo;
                exit(1);
        }
        
        $returnInfo['status']='success';
        $returnInfo['payPalTransactionId']=$payment->getId();
        $returnInfo['successData']=$payment->toArray();
         return $returnInfo;
        //echo $payment->getId();
        //echo '<pre>'; print_r($payment->toArray());
    }
    
}
