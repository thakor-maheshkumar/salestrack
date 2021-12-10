<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesLedger;
use App\Models\States;
use App\Models\CustomerSeries;
use App\Models\City;
class SalesController extends Controller
{
    public $gstRegType, $partyType, $assessable, $applicable, $other, $rules, $ledgerNameTitle, $opening_balances;

    public function __construct()
    {
        $this->gstRegType = [
            0 => 'Not Applicable',
            1 => 'Regular',
            2 => 'Consumer',
            3 => 'Unregistered',
            4 => 'composition',
        ];

        $this->partyType = [
            0 => 'Not Applicable',
            1 => 'deemed',
            2 => 'export',
            3 => 'embassy',
            4 => 'government entity',
            5 => 'SEZ',
        ];

        $this->assessable = [
            'Not applicable',
            'GST',
        ];

        $this->applicable = [
            'Both',
            'Goods',
            'service',
        ];

        $this->other = (Object) [
            'title' => 'Customer Master List',
            'route_name' => 'sales',
            'back_link' => route('masters.ledger'),
            'add_link' => route('sales.create'),
            'add_link_route' => 'sales.create',
            'store_link' => 'sales.store',
            'edit_link' => 'sales.edit',
            'update_link' => 'sales.update',
            'delete_link' => 'sales.destroy',
            'listing_link' => 'sales.index',
            'delete_consignee_address_link' => 'sales.delete_consignee_address',
            'order_type' => 21,
        ];

        $this->rules = [
            'ledger_name' => 'required',
            'under' => 'required|exists:groups,id',
            'gst_reg_type' => 'required|in:0,1,2,3,4',
            'party_type' => 'required||in:0,1,2,3,4,5',
            //'pan_it_no' => 'required',
            //'uid_no' => 'required',
            /*'is_tds_deductable' => 'required|in:0,1',
            'include_assessable_value' => 'required|in:0,1',
            'applicable' => 'required|in:0,1,2',*/
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required|numeric|digits_between:4,6',
            'location' => 'required',
            'mobile_no' => 'required|numeric|digits_between:10,12',
            'landline_no' => 'required|numeric',
            'fax_no' => 'required',
            'website' => 'required',
            'email' => 'required|email',
            'cc_email' => 'required|email',
            'consignee_address' => 'required|in:0,1',
            'maintain_balance_bill_by_bill' => 'required|in:0,1',
            'default_credit_period' => 'required_if:under,13|required_if:under,14',
            'default_credit_amount' => 'required_if:under,13|required_if:under,14|nullable|numeric',
            'credit_days_during_voucher_entry' => 'required|in:0,1',
            'credit_amount_during_voucher_entry' => 'required|in:0,1',
            'active_interest_calculation' => 'required|in:0,1',
        ];

        $this->ledgerNameTitle = 'Customer Name';

        $this->selected_group = 14;

        $this->opening_balances = [
            '' => 'Select Opening Balance',
            'credit' => 'Credit',
            'debit' => 'Debit'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tableHeader = [
            'Ledger Name',
            'Under',
            'GSTIN/UIN',
            'Party Type',
            'Edit',
            'Delete'
        ];

        $salesLedgers = SalesLedger::with('customergroups')->orderByDesc('id')->get();

        return view('admin.ledger.sales.index', [
            'tableHeader' => $tableHeader,
            'tablerow' => $salesLedgers,
            'partyType' => $this->partyType,
            'other' => $this->other,
            'opening_balances' => $this->opening_balances
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = \App\Models\Groups::where('under', '<>', 0)->where('group_type', '<>', 0)->pluck('group_name', 'id')->toArray();
        $territories_list = \App\Models\Terretory::pluck('terretory_name', 'id')->toArray();
        $territories = !empty($territories_list) ? $territories_list : array();
        $states = States::where('active', 1)->pluck('state','state')->toArray();
        $customerseries=CustomerSeries::where('status','true')->get();
        $customerGroup = \App\Models\CustomerGroup::pluck('group_name', 'id')->toArray();
        $city = City::pluck('city','city')->toArray();
        return view('admin.ledger.sales.create', [
            'gstRegType' => $this->gstRegType,
            'partyType' => $this->partyType,
            'assessable' => $this->assessable,
            'applicable' => $this->applicable,
            'other' => $this->other,
            'groups' => $groups,
            'territories'=>$territories,
            'ledgerNameTitle' => $this->ledgerNameTitle,
            'customerGroup' => $customerGroup,
            'states' => $states,
            'selected_group' => $this->selected_group,
            'opening_balances' => $this->opening_balances,
            'customerseries'=>$customerseries,
            'city'=>$city,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->gst_reg_type < 3)
        {
            /*$this->rules['gstin_uin'] = 'required|regex:/(^[0-3]{1}[0-9]{1}[a-z A-Z 0-9]{13}$)/';
            $this->rules['gstin_applicable_date'] = 'required';*/
            [
                $this->rules['gstin_applicable_date'] = ['required'],
                $this->rules['gstin_uin'] = ['required', 'regex:/([0][1-9]|[1-2][0-9]|[3][0-5])([0-9 a-z A-Z]{13})+$/','min:15','max:15'],
            ];
        }
        if ($request->gst_reg_type == 1)
        {
            $this->rules['pan_it_no'] = 'required';
            $this->rules['uid_no'] = 'required';
        }
   
        

        $this->validate($request, $this->rules);

        /*$salesLedger = new SalesLedger();
        $salesLedger->fill($request->all());
        $sales = $salesLedger->save();*/
        $this->validate($request,[
            'customer_number'=>'required|unique:sales_ledgers,customer_number'
        ]);
        $sales = SalesLedger::create($request->all());

        
        if (!empty($sales)) {
            if(isset($request->consignee_addresses) && !empty($request->consignee_addresses))
            {
                for($i=0;$i<count($request->consignee_addresses);$i++)
                {
                    if(!empty($request->consignee_addresses[$i]))
                    {
                        $consinee_address_data = [
                            'branch_name' => $request->branch_name[$i],
                            'address' => $request->consignee_addresses[$i],
                            'city' => $request->consignee_city[$i],
                            'location' => $request->consignee_location[$i],
                            'state' => isset($request->state) ? $request->state : $request->consignee_state[$i],
                            'pincode' => $request->consignee_pincode[$i],
                            'mobile_no' => $request->consignee_mobile_no[$i],
                            'landline_no' => $request->consignee_landline_no[$i],
                            'fax_no' => $request->consignee_fax_no[$i],
                            'website' => $request->consignee_website[$i],
                            'ledger_id' => $sales->id,
                            'ledger_type'=> 1
                        ];

                        $ConsignAddress = \App\Models\ConsigneeAddress::create($consinee_address_data);
                    }
                }
            }
            $customerSeries=\App\Models\CustomerSeries::where('status','true')->first();
           // dd($customerSeries);
            if($customerSeries)
                {
                $number = (int)$customerSeries->series_current_digit + 1;
                $customerSeries=\App\Models\CustomerSeries::find($customerSeries->id);
                $customerSeries->series_current_digit=$number;
                $customerSeries->save();
            }   
            if(!empty($request->opening_balance_amount))
            {
                if($request->opening_balance=='credit')
                {
                    $opening_balance_amount = (float)$request->opening_balance_amount;
                }else{
                    $opening_balance_amount = '-'.(float)$request->opening_balance_amount;
                }
                
                $customer_balance =\App\Models\UserBalanceInfo::where('user_id',$sales->id)->where('ledger_type','customer')->first();
                if($customer_balance)
                {
                    $total_balance = $customer_balance->total_balance ;
                    $update_blance = (float)$total_balance + (float)$opening_balance_amount;                   
                     $balance_data = [
                        'total_balance'=>$update_blance
                    ];
                    \App\Models\UserBalanceInfo::where('user_id',$sales->id)->update($balance_data);
                }else{
                    $balance_data = [
                        'user_id'=>$sales->id,
                        'ledger_type'=>'customer',
                        'total_balance'=> $opening_balance_amount
                    ];
                    $balance_id = \App\Models\UserBalanceInfo::create($balance_data);
                }

                // $customer_balance =\App\Models\UserBalanceInfo::where('user_id',$sales->id)->first();
                // $payment_record_data = [
                //     'posting_date'=>date('Y-m-d H:i:s'),
                //     'account'=>0.00,
                //     'debit'=>0.00,
                //     'credit'=>$opening_balance_amount,
                //     'balance'=> $customer_balance->total_balance,
                //     'recordable_type'=>'App\Models\SalesLedger',
                //     'recordable_id'=> $sales->id,
                //     'voucher_type'=>'Sales Ledger',
                //     'party_type'=>'Customer',
                //     'party'=> $request->ledger_name,
                // ];
                // $payment_record_id = \App\Models\PaymentRecord::create($payment_record_data);
            }

            return redirect()->route('sales.index')->with('message', __('messages.add', ['name' => 'Sales ledger']));
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $sales = \App\Models\SalesLedger::find($id);
        $groups = \App\Models\Groups::where('under', '<>', 0)->where('group_type', '<>', 0)->pluck('group_name', 'id')->toArray();
        $territories_list = \App\Models\Terretory::pluck('terretory_name', 'id')->toArray();
        $territories = !empty($territories_list) ? $territories_list : array();
        $consignee_addresses = \App\Models\ConsigneeAddress::where('ledger_id', '=', $id)->where('ledger_type', '=', 1)->get();

        $customerGroup = \App\Models\CustomerGroup::pluck('group_name', 'id')->toArray();
        $states = States::where('active', 1)->pluck('state','state')->toArray();
        $customerseries=CustomerSeries::where('status','true')->get();
        $city = City::pluck('city','city')->toArray();
        return view('admin.ledger.sales.edit', [
            'ledger' => $sales,
            'gstRegType' => $this->gstRegType,
            'partyType' => $this->partyType,
            'assessable' => $this->assessable,
            'applicable' => $this->applicable,
            'other' => $this->other,
            'groups' => $groups,
            'territories'=>$territories,
            'consignee_addresses'=>$consignee_addresses,
            'ledgerNameTitle' => $this->ledgerNameTitle,
            'customerGroup' => $customerGroup,
            'states' => $states,
            'selected_group' => $this->selected_group,
            'opening_balances' => $this->opening_balances,
            'customerseries'=>$customerseries,
            'city'=>$city
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->gst_reg_type < 3)
        {
            /*$this->rules['gstin_uin'] = 'required|regex:/(^[0-3]{1}[0-9]{1}[a-z A-Z 0-9]{13}$)/';
            $this->rules['gstin_applicable_date'] = 'required';*/
            [
                $this->rules['gstin_applicable_date'] = ['required'],
                $this->rules['gstin_uin'] = ['required', 'regex:/([0][1-9]|[1-2][0-9]|[3][0-5])([0-9 a-z A-Z]{13})+$/','min:15','max:15'],
            ];
        }
        if ($request->gst_reg_type == 1)
        {
            $this->rules['pan_it_no'] = 'required';
            $this->rules['uid_no'] = 'required';
        }
        $this->validate($request, $this->rules);
        $sales_details =  SalesLedger::find($id);  
        $sales = SalesLedger::find($id);

        if ($sales && $sales->update($request->all()))
        {
          
            //echo 'D :'.$request->opening_balance_amount;exit;
            if(!empty($request->opening_balance_amount) && ($sales_details->opening_balance_amount!=$request->opening_balance_amount))
            {
                $opening_balance_amount = (float)$request->opening_balance_amount;
                $customer_balance =\App\Models\UserBalanceInfo::where('user_id',$sales->id)->first();
                if($customer_balance)
                {
                    $total_balance = $customer_balance->total_balance ;

                    if($request->opening_balance=='credit')
                    {
                        $update_blance = (float)$total_balance + (float)$opening_balance_amount;
                    }else{
                        $update_blance = (float)$total_balance - (float)$opening_balance_amount;
                    }
              
                     $balance_data = [
                        'total_balance'=>$update_blance
                    ];
                    $balance = \App\Models\UserBalanceInfo::where('user_id',$sales->id)->update($balance_data);
                }else{
                    $balance_data = [
                        'user_id'=>$sales->id,
                        'total_balance'=> $opening_balance_amount
                    ];
                    $balance_id = \App\Models\UserBalanceInfo::create($balance_data);
                }
            }
            if(isset($request->consignee_addresses) && !empty($request->consignee_addresses))
            {
                for($i=0;$i<count($request->consignee_addresses);$i++)
                {
                    $consinee_address_data = [
                        'branch_name' => $request->branch_name[$i],
                        'address' => $request->consignee_addresses[$i],
                        'city' => $request->consignee_city[$i],
                        'location' => $request->consignee_location[$i],
                        'state' => isset($request->state) ? $request->state : $request->consignee_state[$i],
                        'pincode' => $request->consignee_pincode[$i],
                        'mobile_no' => $request->consignee_mobile_no[$i],
                        'landline_no' => $request->consignee_landline_no[$i],
                        'fax_no' => $request->consignee_fax_no[$i],
                        'website' => $request->consignee_website[$i],
                        'ledger_id' => $sales->id,
                        'ledger_type'=> 1
                    ];

                    if(!empty($request->consignee_addresses[$i]))
                    {
                        if(isset($request->consignee_address_id[$i]))
                        {
                            $ConsignAddress = \App\Models\ConsigneeAddress::where('id', $request->consignee_address_id[$i])->update($consinee_address_data);
                        }else{
                            $ConsignAddress = \App\Models\ConsigneeAddress::create($consinee_address_data);
                        }
                    }
                }
            }

            return redirect()->route('sales.index')->with('message', __('messages.update', ['name' => 'Sales ledger']));
        }
        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sales = SalesLedger::find($id);

        if ($sales)
        {
            $sales->delete();

            return redirect()->route('sales.index')->with('message', __('messages.delete', ['name' => 'SalesLedger']));
        }

        return redirect()->back()->with('error', 'Something goes to wrong.');
    }

    public function delete_consignee_address($address_id,$ledger_id)
    {
        $find = \App\Models\ConsigneeAddress::find($address_id);

        if ($find)
        {
            $find->delete();

            return redirect()->route('sales.edit',$ledger_id)->with('message', __('messages.delete', ['name' => 'Consinee Address']));
        }

        return redirect()->back()->with('error', 'Something goes to wrong.');
    }
    public function import(Request $request)
    {
        if($request->import=='override'){
            $validated=$request->validate([
                'file'=>'required|mimes:csv,txt',
            ]);
            if($validated){
                   $truncate=SalesLedger::truncate();
            if(isset($truncate))
            {
            $grpup_name_title=SalesLedger::pluck('ledger_name','id')->toArray();

               if(isset($_POST['importSubmit']))
               {
    
                 // Allowed mime types
                 $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    
                        // Validate whether selected file is a CSV file
                     if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes))
                     {
        
                        // If the file is uploaded
                         if(is_uploaded_file($_FILES['file']['tmp_name']))
                         {
            
                        // Open uploaded CSV file with read-only mode
                          $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
                        
                            fgetcsv($csvFile);
                        // Skip the first line
                            // Parse data from CSV file line by line
                            $store=[];
                            while(($line = fgetcsv($csvFile)) !== FALSE)
                                {
                             // Get row data
                                   
                                    $ledger_name   = $line[0];
                                    $customer_group  = $line[1];
                                    $under  = $line[2];
                                    $gst_reg_type  = $line[3];
                                    $gstin_uin  = $line[4];
                                    $gstin_applicable_date  = $line[5];
                                    $party_type  = $line[6];
                                    $pan_it_no  = $line[7];
                                    $uid_no  = $line[8];
                                    $is_tds_deductable  = $line[9];
                                    $include_assessable_value  = $line[10];
                                    $applicable  = $line[11];
                                    $address  = $line[12];
                                    $city  = $line[13];
                                    $state  = $line[14];
                                    $pincode  = $line[15];
                                    $location  = $line[16];
                                    $mobile_no  = $line[17];
                                    $landline_no  = $line[18];
                                    $fax_no  = $line[19];
                                    $website  = $line[20];
                                    $email  = $line[21];
                                    $cc_email  = $line[22];
                                    $consignee_address  = $line[23];
                                    $maintain_balance_bill_by_bill  = $line[24];
                                    $default_credit_period  = $line[25];
                                    $default_credit_amount  = $line[26];
                                    $credit_days_during_voucher_entry  = $line[27];
                                    $credit_amount_during_voucher_entry  = $line[28];
                                    $active_interest_calculation  = $line[29];
                                    $opening_balance  = $line[30];
                                    $opening_balance_amount  = $line[31];
                                    $customer_number  = $line[32];
                                    $active=$line[33];

                                // Insert member data in the database
                                    if(!(in_array($ledger_name,$grpup_name_title)) && !in_array($ledger_name,$store))
                                    {
                                        $store[]=$ledger_name;
                                        SalesLedger::create([
                                        'ledger_name' => $ledger_name,
                                        'customer_group'=>$customer_group,
                                        'under'=>$under,
                                        'gst_reg_type'=>$gst_reg_type,
                                        'gstin_uin'=>$gstin_uin,
                                        'gstin_applicable_date'=>$gstin_applicable_date,
                                        'party_type'=>$party_type,
                                        'pan_it_no'=>$pan_it_no,
                                        'uid_no'=>$uid_no,
                                        'is_tds_deductable'=>$is_tds_deductable,
                                        'include_assessable_value'=>$include_assessable_value,
                                        'applicable'=>$applicable,
                                        'address'=>$address,
                                        'city'=>$city,
                                        'state'=>$state,
                                        'pincode'=>$pincode,
                                        'location'=>$location,
                                        'mobile_no'=>$mobile_no,
                                        'landline_no'=>$landline_no,
                                        'fax_no'=>$fax_no,
                                        'website'=>$website,
                                        'email'=>$email,
                                        'cc_email'=>$cc_email,
                                        'consignee_address'=>$consignee_address,
                                        'maintain_balance_bill_by_bill'=>$maintain_balance_bill_by_bill,
                                        'default_credit_period'=>$default_credit_period,
                                        'default_credit_amount'=>$default_credit_amount,
                                        'credit_days_during_voucher_entry'=>$credit_days_during_voucher_entry,
                                        'credit_amount_during_voucher_entry'=>$credit_amount_during_voucher_entry,
                                        'active_interest_calculation'=>$active_interest_calculation,
                                        'opening_balance'=>$opening_balance,
                                        'opening_balance_amount'=>$opening_balance_amount,
                                        'customer_number'=>$customer_number,
                                        'active'=>$active,
                                        ]);    
                                    }
                                   
                                 }
            
                            // Close opened CSV file
                                fclose($csvFile);
                                return redirect()->route('sales.index')->with('message', 'Imported Data successfully.');

                            }
                            else
                            {
                                return redirect()->back()->with('error', 'Something goes to wrong.');
                            }
                      }
                    else
                    {
                        return redirect()->back()->with('error', 'Only CSV file accepted.');
                    }
                }

        }

    }
        else
        {
            return redirect()->back()->with('error', 'Only CSV file accepted.');
        }
                
    }
    elseif($request->import=='on')
    {


        $grpup_name_title=SalesLedger::pluck('ledger_name','id')->toArray();
        //dd($grpup_name_title);
        if(isset($_POST['importSubmit']))
        {
    
    // Allowed mime types
        $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    
    // Validate whether selected file is a CSV file
           if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes))
            {
        
                // If the file is uploaded
                if(is_uploaded_file($_FILES['file']['tmp_name']))
                    {
            
                    // Open uploaded CSV file with read-only mode
                    $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            
            // Skip the first line
                fgetcsv($csvFile);
            
            // Parse data from CSV file line by line

                        $store=[];
                        while(($line = fgetcsv($csvFile)) !== FALSE)
                        {
                // Get row data
                          
                                    $ledger_name   = $line[0];
                                    $customer_group  = $line[1];
                                    $under  = $line[2];
                                    $gst_reg_type  = $line[3];
                                    $gstin_uin  = $line[4];
                                    $gstin_applicable_date  = $line[5];
                                    $party_type  = $line[6];
                                    $pan_it_no  = $line[7];
                                    $uid_no  = $line[8];
                                    $is_tds_deductable  = $line[9];
                                    $include_assessable_value  = $line[10];
                                    $applicable  = $line[11];
                                    $address  = $line[12];
                                    $city  = $line[13];
                                    $state  = $line[14];
                                    $pincode  = $line[15];
                                    $location  = $line[16];
                                    $mobile_no  = $line[17];
                                    $landline_no  = $line[18];
                                    $fax_no  = $line[19];
                                    $website  = $line[20];
                                    $email  = $line[21];
                                    $cc_email  = $line[22];
                                    $consignee_address  = $line[23];
                                    $maintain_balance_bill_by_bill  = $line[24];
                                    $default_credit_period  = $line[25];
                                    $default_credit_amount  = $line[26];
                                    $credit_days_during_voucher_entry  = $line[27];
                                    $credit_amount_during_voucher_entry  = $line[28];
                                    $active_interest_calculation  = $line[29];
                                    $opening_balance  = $line[30];
                                    $opening_balance_amount  = $line[31];
                                    $customer_number  = $line[32];
                                    $active=$line[33];
                                if(!(in_array($ledger_name,$grpup_name_title)) && !in_array($ledger_name,$store))
                                {
                                    $store[]=$ledger_name;
                                    SalesLedger::create([
                                 
                                        'ledger_name' => $ledger_name,
                                        'customer_group'=>$customer_group,
                                        'under'=>$under,
                                        'gst_reg_type'=>$gst_reg_type,
                                        'gstin_uin'=>$gstin_uin,
                                        'gstin_applicable_date'=>$gstin_applicable_date,
                                        'party_type'=>$party_type,
                                        'pan_it_no'=>$pan_it_no,
                                        'uid_no'=>$uid_no,
                                        'is_tds_deductable'=>$is_tds_deductable,
                                        'include_assessable_value'=>$include_assessable_value,
                                        'applicable'=>$applicable,
                                        'address'=>$address,
                                        'city'=>$city,
                                        'state'=>$state,
                                        'pincode'=>$pincode,
                                        'location'=>$location,
                                        'mobile_no'=>$mobile_no,
                                        'landline_no'=>$landline_no,
                                        'fax_no'=>$fax_no,
                                        'website'=>$website,
                                        'email'=>$email,
                                        'cc_email'=>$cc_email,
                                        'consignee_address'=>$consignee_address,
                                        'maintain_balance_bill_by_bill'=>$maintain_balance_bill_by_bill,
                                        'default_credit_period'=>$default_credit_period,
                                        'default_credit_amount'=>$default_credit_amount,
                                        'credit_days_during_voucher_entry'=>$credit_days_during_voucher_entry,
                                        'credit_amount_during_voucher_entry'=>$credit_amount_during_voucher_entry,
                                        'active_interest_calculation'=>$active_interest_calculation,
                                        'opening_balance'=>$opening_balance,
                                        'opening_balance_amount'=>$opening_balance_amount,
                                        'customer_number'=>$customer_number,
                                        'active'=>$active,
                                    ]);    
                                }
                               
                
                        }
            
                            // Close opened CSV file
                            fclose($csvFile);
                                    return redirect()->route('sales.index')->with('message', 'Imported Data successfully.');

                    }
                    else
                    {
                        return redirect()->back()->with('error', 'Something goes to wrong.');
                    }
                }
                else
                {
                    return redirect()->back()->with('error', 'Only CSV file accepted.');
                }
            }

        }
    }
    public function fetchcity(Request $request)
    {
        $data['cities']=City::where('state',$request->state)->get();
        //dd($data);
        return response()->json($data);
    }
}
