<?php

namespace App\Traits;

trait UserBalanceInfo
{
    public static function bootUserBalanceInfo()
    {
        static::saved(function ($model) {
            switch (static::class) {
                case 'App\Models\SalesLedger':

                    $is_addition=0;
                    //echo '<pre>';print_r($model);exit;
                    if(isset($model->opening_balance) && $model->opening_balance == 'debit') {
                        $balance_amount = '-'.number_format($model->opening_balance_amount, 3);
                    }
                    else if(isset($model->opening_balance) && $model->opening_balance == 'credit') {
                        $balance_amount = number_format($model->opening_balance_amount, 3);
                    }
                   $model_id = $model->id;
                    // $opening_balance_amount = number_format($model->opening_balance_amount, 3);
                    // $opening_balance_amount = (float)$model->opening_balance_amount;
                    // $customer_balance =\App\Models\UserBalanceInfo::where('user_id',$model->id)->first();
                    // if($customer_balance)
                    // {
                    //     $balance_data = [
                    //         'total_balance'=>$customer_balance->total_balance + $opening_balance_amount
                    //     ];
                    //     $balance = \App\Models\UserBalanceInfo::find($model->id);
                    //     $balance->update($balance_data);
                    // }else{
                    //     $balance_data = [
                    //         'user_id'=>$model->id,
                    //         'total_balance'=> $opening_balance_amount
                    //     ];

                    //     $balance_id = \App\Models\UserBalanceInfo::create($balance_data);
                    // }
                break;
                default:
                    $balance_amount='';
                    $model_id='';
                    $is_addition=1;
                break;
            }

            if(!empty($model_id) && !empty($balance_amount))
            {
                $customer_balance =\App\Models\UserBalanceInfo::where('user_id',$model_id)->first();
               
                if($customer_balance)
                {
                    $total_balance = (float)$customer_balance->total_balance;
                    $update_blance = (float)$total_balance + (float)$balance_amount;
                    $balance_data = [
                        'total_balance'=>$update_blance
                    ];
                    
                    \App\Models\UserBalanceInfo::where('user_id',$model_id)->update($balance_data);
                }else{
                    $balance_data = [
                        'user_id'=>$model->id,
                        'total_balance'=> $balance_amount
                    ];
    
                    $balance_id = \App\Models\UserBalanceInfo::create($balance_data);
                }
            }
            
        });
    }
}