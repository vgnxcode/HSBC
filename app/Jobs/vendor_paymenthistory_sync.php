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
use vgn\Http\Traits\vendortrait;

class vendor_paymenthistory_sync implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, vendortrait;
    protected $vendid;
    protected $status;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($vendid,$sapstatus)
    {
        $this->vendid = $vendid;
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
            Log::info('Vendor Payment History processed '.$this->vendid);
            $sapdata = $this->vendor_paymenthistory_job($this->vendid);
            $sap_paym = array();
                    if (array_key_exists('PAYMENT_HISTORY', $sapdata)) {
                    $sappayments = $sapdata['PAYMENT_HISTORY'];
                    if (array_key_exists('0', $sappayments)) {
                        $sap_paym = $sappayments;
                    }
                    else
                    {
                        $sap_paym[0] = $sappayments;
                    }
                    //dd($sap_paym);
                     $getpayments = DB::connection('mysql5')->table('payments')->where('vend_id', '=', $this->vendid)->get();
                     
                     if(count($getpayments) > 0)
                     {
                         DB::connection('mysql5')->table('payments')->where('vend_id', '=', $this->vendid)->delete();
                         if (count($sap_paym) > 0) {
                         
                        foreach ($sap_paym as $sappaymkey => $sappaymvalue) {
                            
                            
                              DB::connection('mysql5')->table('payments')->insert(['vend_id' => $this->vendid,
                                'posteddate' => substr($sappaymvalue['Posting_Date'],0,4)."-".substr($sappaymvalue['Posting_Date'],4,2)."-".substr($sappaymvalue['Posting_Date'],6,2),
                                'doc_no' => $sappaymvalue['Document_Number'],
                                'ref_no' => $sappaymvalue['Reference_Number'],
                                'inv_amt' => str_replace('-','',$sappaymvalue['Payment_Amount']),
                                'pay_type' => $sappaymvalue['Payment_type'],
                                'created' => Carbon::now(),
                                'updated' => Carbon::now()
                                ]);
                            
                        }

                        }
                     }
                     else{
                         if (count($sap_paym) > 0) {
                             foreach ($sap_paym as $sappaymkey => $sappaymvalue) {
                              DB::connection('mysql5')->table('payments')->insert(['vend_id' => $this->vendid,
                                'posteddate' => substr($sappaymvalue['Posting_Date'],0,4)."-".substr($sappaymvalue['Posting_Date'],4,2)."-".substr($sappaymvalue['Posting_Date'],6,2),
                                'doc_no' => $sappaymvalue['Document_Number'],
                                'ref_no' => $sappaymvalue['Reference_Number'],
                                'inv_amt' => str_replace('-','',$sappaymvalue['Payment_Amount']),
                                'pay_type' => $sappaymvalue['Payment_type'],
                                'created' => Carbon::now(),
                                'updated' => Carbon::now()
                                ]);
                            
                        }
                         }

                     }
                 }
                
        }
    

if ($this->status == "notpresentindb") {
    Log::info('Vendor Payment History processed '.$this->vendid);
            $sapdata = $this->vendor_paymenthistory_job($this->vendid);
                
                
                  $sap_paym = array();
                    if (array_key_exists('PAYMENT_HISTORY', $sapdata)) {
                    $sappayments = $sapdata['PAYMENT_HISTORY'];
                    if (array_key_exists('0', $sappayments)) {
                        $sap_paym = $sappayments;
                    }
                    else
                    {
                        $sap_paym[0] = $sappayments;
                    }
                    //dd($sap_compl);
                        
                     $getpayments = DB::connection('mysql5')->table('payments')->where('vend_id', '=', $this->vendid)->get();
                     
                     if(count($getpayments) > 0)
                     {
                         DB::connection('mysql5')->table('payments')->where('vend_id', '=', $this->vendid)->delete();
                         if (count($sap_paym) > 0) {
                         
                        foreach ($sap_paym as $sappaymkey => $sappaymvalue) {
                              DB::connection('mysql5')->table('payments')->insert(['vend_id' => $this->vendid,
                                'posteddate' => substr($sappaymvalue['Posting_Date'],0,4)."-".substr($sappaymvalue['Posting_Date'],4,2)."-".substr($sappaymvalue['Posting_Date'],6,2),
                                'doc_no' => $sappaymvalue['Document_Number'],
                                'ref_no' => $sappaymvalue['Reference_Number'],
                                'inv_amt' => str_replace('-','',$sappaymvalue['Payment_Amount']),
                                'pay_type' => $sappaymvalue['Payment_type'],
                                'created' => Carbon::now(),
                                'updated' => Carbon::now()
                                ]);
                            
                        }

                        }
                     }
                     else{
                         if (count($sap_paym) > 0) {
                             
                             foreach ($sap_paym as $sappaymkey => $sappaymvalue) {
                              DB::connection('mysql5')->table('payments')->insert(['vend_id' => $this->vendid,
                                'posteddate' => substr($sappaymvalue['Posting_Date'],0,4)."-".substr($sappaymvalue['Posting_Date'],4,2)."-".substr($sappaymvalue['Posting_Date'],6,2),
                                'doc_no' => $sappaymvalue['Document_Number'],
                                'ref_no' => $sappaymvalue['Reference_Number'],
                                'inv_amt' => str_replace('-','',$sappaymvalue['Payment_Amount']),
                                'pay_type' => $sappaymvalue['Payment_type'],
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
