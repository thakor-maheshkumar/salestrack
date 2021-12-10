<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralLedger;
use App\Models\States;
use App\Models\City;

class GeneralController extends Controller
{
	public $gstRegType, $partyType, $assessable, $applicable, $other, $rules;

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
            'title' => 'General Ledger',
            'route_name' => 'general',
            'back_link' => route('masters.ledger'),
            'add_link' => route('general.create'),
            'add_link_route' => 'general.create',
            'store_link' => 'general.store',
            'edit_link' => 'general.edit',
            'update_link' => 'general.update',
            'delete_link' => 'general.destroy',
            'listing_link' => 'general.index',
            'delete_consignee_address_link' => 'general.delete_consignee_address'
        ];

        $this->rules = [
            'ledger_name' => 'required',
            'under' => 'required|exists:groups,id',
            'gst_reg_type' => 'required|in:0,1,2,3,4',
            'party_type' => 'required||in:0,1,2,3,4,5',
            /*'pan_it_no' => 'required|alpha_num|size:10',
            'uid_no' => 'required',*/
            'is_tds_deductable' => 'required|in:0,1',
            'include_assessable_value' => 'required|in:0,1',
            'applicable' => 'required|in:0,1,2',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required|numeric|digits_between:1,9',
            'location' => 'required',
            'mobile_no' => 'required|numeric|digits_between:10,12',
            'landline_no' => 'required|numeric|digits_between:10,12',
            'fax_no' => 'required|numeric',
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

        return view('admin.ledger.index', [
            'tableHeader' => $tableHeader,
            'tablerow' => GeneralLedger::get(),
            'partyType' => $this->partyType,
            'other' => $this->other,
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
        $city = City::pluck('city','city')->toArray();

        return view('admin.ledger.create', [
            'gstRegType' => $this->gstRegType,
            'partyType' => $this->partyType,
            'assessable' => $this->assessable,
            'applicable' => $this->applicable,
            'other' => $this->other,
            'groups' => $groups,
            'territories'=>$territories,
            'states' => $states,
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
        if ($request->gst_reg_type==1)
        {
            $this->rules['pan_it_no'] = 'required|alpha_num|size:10';
            $this->rules['uid_no'] = 'required';
           
        }

        if (($request->gst_reg_type < 3) && ($request->gst_reg_type != 0))
        {
            /*$this->rules['gstin_uin'] = 'required|alpha_num|size:15';
            $this->rules['gstin_applicable_date'] = 'required';*/
            [
                $this->rules['gstin_applicable_date'] = ['required'],
                $this->rules['gstin_uin'] = ['required', 'regex:/([0][1-9]|[1-2][0-9]|[3][0-5])([0-9 a-z A-Z]{13})+$/','min:15','max:15'],
            ];
        }

        $this->validate($request, $this->rules);

        $sales = GeneralLedger::create($request->all());

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
                        'state' => $request->consignee_state[$i],
                        'pincode' => $request->consignee_pincode[$i],
                        'mobile_no' => $request->consignee_mobile_no[$i],
                        'landline_no' => $request->consignee_landline_no[$i],
                        'fax_no' => $request->consignee_fax_no[$i],
                        'website' => $request->consignee_website[$i],
                        'ledger_id' => $sales->id,
                        'ledger_type'=> 3
                    ];

                    $ConsignAddress = \App\Models\ConsigneeAddress::create($consinee_address_data);
                }
            }
        }

        if ($sales)
            return redirect()->route('general.index')->with('message', __('messages.add', ['name' => 'General ledger']));

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
        $sales = \App\Models\GeneralLedger::find($id);
        $groups = \App\Models\Groups::where('under', '<>', 0)->where('group_type', '<>', 0)->pluck('group_name', 'id')->toArray();
        $territories_list = \App\Models\Terretory::pluck('terretory_name', 'id')->toArray();
        $territories = !empty($territories_list) ? $territories_list : array();
        $consignee_addresses = \App\Models\ConsigneeAddress::where('ledger_id', '=', $id)->where('ledger_type', '=', 3)->get();
        $states = States::where('active', 1)->pluck('state','state')->toArray();
        $city = City::pluck('city','city')->toArray();

        return view('admin.ledger.edit', [
            'ledger' => $sales,
            'gstRegType' => $this->gstRegType,
            'partyType' => $this->partyType,
            'assessable' => $this->assessable,
            'applicable' => $this->applicable,
            'other' => $this->other,
            'groups' => $groups,
            'territories'=>$territories,
            'consignee_addresses'=>$consignee_addresses,
            'states' => $states,
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
        if ($request->gst_reg_type==1)
        {
            $this->rules['pan_it_no'] = 'required|alpha_num|size:10';
            $this->rules['uid_no'] = 'required';
           
        }
        if (($request->gst_reg_type < 3) && ($request->gst_reg_type != 0))
        {
            /*$this->rules['gstin_uin'] = 'required|alpha_num|size:15';
            $this->rules['gstin_applicable_date'] = 'required';*/
            [
                $this->rules['gstin_applicable_date'] = ['required'],
                $this->rules['gstin_uin'] = ['required', 'regex:/([0][1-9]|[1-2][0-9]|[3][0-5])([0-9 a-z A-Z]{13})+$/','min:15','max:15'],
            ];
        }

        $this->validate($request, $this->rules);

        $sales = GeneralLedger::find($id);

        if ($sales && $sales->update($request->all()))
        {
            if(isset($request->consignee_addresses) && !empty($request->consignee_addresses))
            {
                for($i=0;$i<count($request->consignee_addresses);$i++)
                {
                    $consinee_address_data = [
                        'branch_name' => $request->branch_name[$i],
                        'address' => $request->consignee_addresses[$i],
                        'city' => $request->consignee_city[$i],
                        'location' => $request->consignee_location[$i],
                        'state' => $request->consignee_state[$i],
                        'pincode' => $request->consignee_pincode[$i],
                        'mobile_no' => $request->consignee_mobile_no[$i],
                        'landline_no' => $request->consignee_landline_no[$i],
                        'fax_no' => $request->consignee_fax_no[$i],
                        'website' => $request->consignee_website[$i],
                        'ledger_id' => $sales->id,
                        'ledger_type'=> 3
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
            return redirect()->route('general.index')->with('message', __('messages.update', ['name' => 'General ledger']));
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
        $sales = GeneralLedger::find($id);

        if ($sales)
        {
            $sales->delete();

            return redirect()->route('general.index')->with('message', __('messages.delete', ['name' => 'General Ledger']));
        }

        return redirect()->back()->with('error', 'Something goes to wrong.');
    }
    public function delete_consignee_address($address_id,$ledger_id)
    {
        $find = \App\Models\ConsigneeAddress::find($address_id);

        if ($find)
        {
            $find->delete();

            return redirect()->route('general.edit',$ledger_id)->with('message', __('messages.delete', ['name' => 'Consinee Address']));
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
                   $truncate=GeneralLedger::truncate();
            if(isset($truncate))
            {
            $grpup_name_title=GeneralLedger::pluck('ledger_name','id')->toArray();

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
                                    $under  = $line[1];
                                    $gst_reg_type  = $line[2];
                                    $gstin_uin  = $line[3];
                                    $gstin_applicable_date  = $line[4];
                                    $party_type  = $line[5];
                                    $pan_it_no  = $line[6];
                                    $uid_no  = $line[7];
                                    $is_tds_deductable  = $line[8];
                                    $include_assessable_value  = $line[9];
                                    $applicable  = $line[10];
                                    $address  = $line[11];
                                    $city  = $line[12];
                                    $state  = $line[13];
                                    $pincode  = $line[14];
                                    $location  = $line[15];
                                    $mobile_no  = $line[16];
                                    $landline_no  = $line[17];
                                    $fax_no  = $line[18];
                                    $website  = $line[19];
                                    $email  = $line[20];
                                    $cc_email  = $line[21];
                                    $consignee_address  = $line[22];
                                    $maintain_balance_bill_by_bill  = $line[23];
                                    $default_credit_period  = $line[24];
                                    $default_credit_amount  = $line[25];
                                    $credit_days_during_voucher_entry  = $line[26];
                                    $credit_amount_during_voucher_entry  = $line[27];
                                    $active_interest_calculation  = $line[28];

                                // Insert member data in the database
                                    if(!(in_array($ledger_name,$grpup_name_title)) && !in_array($ledger_name,$store))
                                    {
                                        $store[]=$ledger_name;
                                        GeneralLedger::create([
                                        'ledger_name' => $ledger_name,
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
                                        ]);    
                                    }
                                 }
            
                            // Close opened CSV file
                                fclose($csvFile);
                                return redirect()->route('general.index')->with('message', 'Imported Data successfully.');

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
                
            }else{
                
            }
                
    }
    elseif($request->import=='on')
    {


        $grpup_name_title=GeneralLedger::pluck('ledger_name','id')->toArray();
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
                                    $under  = $line[1];
                                    $gst_reg_type  = $line[2];
                                    $gstin_uin  = $line[3];
                                    $gstin_applicable_date  = $line[4];
                                    $party_type  = $line[5];
                                    $pan_it_no  = $line[6];
                                    $uid_no  = $line[7];
                                    $is_tds_deductable  = $line[8];
                                    $include_assessable_value  = $line[9];
                                    $applicable  = $line[10];
                                    $address  = $line[11];
                                    $city  = $line[12];
                                    $state  = $line[13];
                                    $pincode  = $line[14];
                                    $location  = $line[15];
                                    $mobile_no  = $line[16];
                                    $landline_no  = $line[17];
                                    $fax_no  = $line[18];
                                    $website  = $line[19];
                                    $email  = $line[20];
                                    $cc_email  = $line[21];
                                    $consignee_address  = $line[22];
                                    $maintain_balance_bill_by_bill  = $line[23];
                                    $default_credit_period  = $line[24];
                                    $default_credit_amount  = $line[25];
                                    $credit_days_during_voucher_entry  = $line[26];
                                    $credit_amount_during_voucher_entry  = $line[27];
                                    $active_interest_calculation  = $line[28];

              
                
                // Check whether member already exists in the database with the same email
                /*$prevQuery = "SELECT id FROM members WHERE email = '".$line[1]."'";
                $prevResult = query($prevQuery);*/
                
                /*if($prevResult->num_rows > 0){
                    // Update member data in the database
                    $db->query("UPDATE members SET name = '".$name."', phone = '".$phone."', status = '".$status."', modified = NOW() WHERE email = '".$email."'");
                }*/
                // Insert member data in the database
                                if(!(in_array($ledger_name,$grpup_name_title)) && !in_array($ledger_name,$store))
                                {
                                    $store[]=$ledger_name;
                                    GeneralLedger::create([
                                        'ledger_name' => $ledger_name,
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
                                    ]);    
                                }
                            
                
                        }
            
                            // Close opened CSV file
                            fclose($csvFile);
                                    return redirect()->route('general.index')->with('message', 'Imported Data successfully.');

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
}
