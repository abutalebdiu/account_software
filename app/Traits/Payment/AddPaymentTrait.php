<?php

    namespace App\Traits\Payment;

    /*     
        use Illuminate\Http\Request;
        use Illuminate\Support\Facades\DB;
        use Validator;
        use App\Model\Backend\Stock\Stock;
        use App\Model\Backend\Stock\MainStock;
        use App\Model\Backend\Stock\PrimaryStock;
        use App\Model\Backend\Stock\SecondaryStock;
        use App\Model\Backend\Unit\Unit;
        use App\Model\Backend\Product\ProductVariation;
        use App\Model\Backend\Purchase\PurchaseDetail;
    */
    use Illuminate\Support\Facades\Auth;
    use App\Model\Backend\Payment\AccountPaymentHistory;
    use App\Model\Backend\Payment\AccountPaymentHistoryDetail;
/**
 *
 */
trait AddPaymentTrait
{

    protected $module_id;
    protected $module_invoice_no;
    protected $module_invoice_id;
    protected $account_id;
    protected $payment_method_id;
    protected $cdf_type_id;
    protected $payment_type_id;
    protected $payment_amount;
    protected $client_supplier_id;
    protected $description;
    protected $payment_reference_no;


    protected $card_number;
    protected $card_holder_name;
    protected $card_transaction_no;
    protected $card_type;
    protected $expire_month;
    protected $expire_year;
    protected $card_security_code;
    protected $from_mobile_banking_account;
    protected $cheque_no;
    protected $transfer_bank_account_no;
    protected $transaction_no;
    protected $payment_note;
    protected $payment_date;

    private function purchase_date()
    {
        if($this->payment_date)
        {   
            //if date format is d/m / /y , separetor by /
            // $y = substr($this->payment_date,6);;
            // $d =  substr($this->payment_date,0,2);
            // $m = substr($this->payment_date,3,2);
            // $mdate = $y."-".$m."-".$d;
            // $this->payment_date =  date('Y-m-d',strtotime($mdate));
            $this->payment_date = date('Y-m-d h:i:s',strtotime($this->payment_date));
        }
        else{
            $this->payment_date =  date('Y-m-d h:i:s');
        }
        return $this->payment_date;
    }

    public function addPaymentWhenSale()
    {
        $data = new AccountPaymentHistory();
        $data->module_id            = $this->module_id;
        $data->module_invoice_no    = $this->module_invoice_no;
        $data->module_invoice_id    = $this->module_invoice_id;
        $data->account_id           = $this->account_id;
        $data->payment_method_id    = $this->payment_method_id;
        $data->cdf_type_id          = $this->cdf_type_id;
        $data->payment_type_id      = $this->payment_type_id;
        $data->payment_amount       = $this->payment_amount;
        $data->client_supplier_id   = $this->client_supplier_id;
        $data->description          = $this->description;
        $data->payment_date         = $this->purchase_date();
        $data->payment_by           = Auth::user()->id;
        $data->created_by           = Auth::user()->id;
        $data->save();
        $data->payment_invoice_no   = "00".$data->id;
        $data->payment_reference_no = $this->payment_reference_no ."/". "00".$data->id;
        $data->save();


        $detail = new AccountPaymentHistoryDetail();
        $detail->account_payment_history_id     =  $data->id;
        $detail->payment_invoice_no             =  $data->payment_invoice_no;
        $detail->payment_reference_no           =  $data->payment_reference_no;
        $detail->module_id                      =  $data->module_id;
        $detail->account_id                     =  $data->account_id;
        $detail->payment_method_id              =  $data->payment_method_id;

        $detail->card_number                    =  $this->card_number;
        $detail->card_holder_name               =  $this->card_holder_name;
        $detail->card_transaction_no            =  $this->card_transaction_no;
        $detail->card_type                      =  $this->card_type;
        $detail->expire_month                   =  $this->expire_month;
        $detail->expire_year                    =  $this->expire_year;
        $detail->card_security_code             =  $this->card_security_code;
        $detail->from_mobile_banking_account    =  $this->from_mobile_banking_account;
        $detail->cheque_no                      =  $this->cheque_no;
        $detail->transfer_bank_account_no       =  $this->transfer_bank_account_no;
        $detail->transaction_no                 =  $this->transaction_no;
        $detail->payment_note                   =  $this->payment_note;
        $detail->payment_date                   =  $this->purchase_date();
        //$detail->description                    =  $this->description;
        $detail->save();
        return $data;
    } 

    /**when purchase */
    public function addPaymentWhenPurchase()
    {
        $data = new AccountPaymentHistory();
        $data->module_id            = $this->module_id;
        $data->module_invoice_no    = $this->module_invoice_no;
        $data->module_invoice_id    = $this->module_invoice_id;
        $data->account_id           = $this->account_id;
        $data->payment_method_id    = $this->payment_method_id;
        $data->cdf_type_id          = $this->cdf_type_id;
        $data->payment_type_id      = $this->payment_type_id;
        $data->payment_amount       = $this->payment_amount;
        $data->client_supplier_id   = $this->client_supplier_id;
        $data->description          = $this->description;
        $data->payment_date         = $this->purchase_date();
        $data->payment_by           = Auth::user()->id;
        $data->created_by           = Auth::user()->id;
        $data->save();
        $data->payment_invoice_no   = "00".$data->id;
        $data->payment_reference_no = $this->payment_reference_no ."/". "00".$data->id;
        $data->save();


        $detail = new AccountPaymentHistoryDetail();
        $detail->account_payment_history_id     =  $data->id;
        $detail->payment_invoice_no             =  $data->payment_invoice_no;
        $detail->payment_reference_no           =  $data->payment_reference_no;
        $detail->module_id                      =  $data->module_id;
        $detail->account_id                     =  $data->account_id;
        $detail->payment_method_id              =  $data->payment_method_id;

        $detail->card_number                    =  $this->card_number;
        $detail->card_holder_name               =  $this->card_holder_name;
        $detail->card_transaction_no            =  $this->card_transaction_no;
        $detail->card_type                      =  $this->card_type;
        $detail->expire_month                   =  $this->expire_month;
        $detail->expire_year                    =  $this->expire_year;
        $detail->card_security_code             =  $this->card_security_code;
        $detail->from_mobile_banking_account    =  $this->from_mobile_banking_account;
        $detail->cheque_no                      =  $this->cheque_no;
        $detail->transfer_bank_account_no       =  $this->transfer_bank_account_no;
        $detail->transaction_no                 =  $this->transaction_no;
        $detail->payment_note                   =  $this->payment_note;
        $detail->payment_date                   =  $this->purchase_date();
        //$detail->description                    =  $this->description;
        $detail->save();
        return $data;
    } 

}