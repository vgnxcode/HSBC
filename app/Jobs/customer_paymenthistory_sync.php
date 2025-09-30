<?php

namespace vgn\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use vgn\Http\Traits\customertrait;


class customer_paymenthistory_sync implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, customertrait;
    protected $custid;
    protected $status;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($custid,$sapstatus)
    {
        $this->custid = $custid;
        $this->status = $sapstatus;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        if ($this->status == "presentindb") {
            Log::info('Customer Payment History processed '.$this->custid);
            $sapdata = $this->customer_paymenthistory_job($this->custid);

                  $sap_paym = array();
                  if (array_key_exists('Payment_History', $sapdata)) {
                  $sappayments = $sapdata['Payment_History'];
                  if (array_key_exists('0', $sappayments)) {
                      $sap_paym = $sappayments;
                  }
                  else
                  {
                      $sap_paym[0] = $sappayments;
                  }
                  
                   $getpayments = DB::connection('mysql3')->table('payments')->where('cust_id', '=', $this->custid)->get();
                   
                   if(count($getpayments) > 0)
                   {
                       DB::connection('mysql3')->table('payments')->where('cust_id', '=', $this->custid)->delete();
                       if (count($sap_paym) > 0) {
                       
                      foreach ($sap_paym as $sappaymkey => $sappaymvalue) {
                            DB::connection('mysql3')->table('payments')->insert(['cust_id' => $this->custid,
                              'posteddate' => substr($sappaymvalue['Posting_Date'],0,4)."-".substr($sappaymvalue['Posting_Date'],4,2)."-".substr($sappaymvalue['Posting_Date'],6,2),
                              'doc_no' => $sappaymvalue['Document_Number'],
                              'inv_amt' => str_replace('-','',$sappaymvalue['Invoice_Amount']),
                              'pay_type' => $sappaymvalue['Payment_Amount'],
                              'created' => Carbon::now(),
                              'updated' => Carbon::now()
                              ]);
                          
                      }

                      }
                   }
                   else{
                       if (count($sap_paym) > 0) {
                           foreach ($sap_paym as $sappaymkey => $sappaymvalue) {
                            DB::connection('mysql3')->table('payments')->insert(['cust_id' => $this->custid,
                              'posteddate' => substr($sappaymvalue['Posting_Date'],0,4)."-".substr($sappaymvalue['Posting_Date'],4,2)."-".substr($sappaymvalue['Posting_Date'],6,2),
                              'doc_no' => $sappaymvalue['Document_Number'],
                              'inv_amt' => str_replace('-','',$sappaymvalue['Invoice_Amount']),
                              'pay_type' => $sappaymvalue['Payment_Amount'],
                              'created' => Carbon::now(),
                              'updated' => Carbon::now()
                              ]);
                          
                      }
                       }

                   }
               
}
        }
    

if ($this->status == "notpresentindb") {
    Log::info('Customer Payment History processed '.$this->custid);
            $sapdata = $this->customer_paymenthistory_job($this->custid);
                
                
                 $nowdate = Carbon::now();
            

                    $sap_paym = array();
                    if (array_key_exists('Payment_History', $sapdata)) {
                    $sappayments = $sapdata['Payment_History'];
                    if (array_key_exists('0', $sappayments)) {
                        $sap_paym = $sappayments;
                    }
                    else
                    {
                        $sap_paym[0] = $sappayments;
                    }
                    
                     $getpayments = DB::connection('mysql3')->table('payments')->where('cust_id', '=', $this->custid)->get();
                     
                     if(count($getpayments) > 0)
                     {
                         DB::connection('mysql3')->table('payments')->where('cust_id', '=', $this->custid)->delete();
                         if (count($sap_paym) > 0) {
                         
                        foreach ($sap_paym as $sappaymkey => $sappaymvalue) {
                              DB::connection('mysql3')->table('payments')->insert(['cust_id' => $this->custid,
                                'posteddate' => substr($sappaymvalue['Posting_Date'],0,4)."-".substr($sappaymvalue['Posting_Date'],4,2)."-".substr($sappaymvalue['Posting_Date'],6,2),
                                'doc_no' => $sappaymvalue['Document_Number'],
                                'inv_amt' => str_replace('-','',$sappaymvalue['Invoice_Amount']),
                                'pay_type' => $sappaymvalue['Payment_Amount'],
                                'created' => Carbon::now(),
                                'updated' => Carbon::now()
                                ]);
                            
                        }

                        }
                     }
                     else{
                         if (count($sap_paym) > 0) {
                             foreach ($sap_paym as $sappaymkey => $sappaymvalue) {
                              DB::connection('mysql3')->table('payments')->insert(['cust_id' => $this->custid,
                                'posteddate' => substr($sappaymvalue['Posting_Date'],0,4)."-".substr($sappaymvalue['Posting_Date'],4,2)."-".substr($sappaymvalue['Posting_Date'],6,2),
                                'doc_no' => $sappaymvalue['Document_Number'],
                                'inv_amt' => str_replace('-','',$sappaymvalue['Invoice_Amount']),
                                'pay_type' => $sappaymvalue['Payment_Amount'],
                                'created' => Carbon::now(),
                                'updated' => Carbon::now()
                                ]);
                            
                        }
                         }

                     }
                 }
            }


    }
}
