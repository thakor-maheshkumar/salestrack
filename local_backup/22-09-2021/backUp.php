$stockItem=$request->stock_item_id;
    
        $startdate=\Carbon\Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
        $enddate=\Carbon\Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d');
        $price=$request->price;
        if($price =="price")
        {

            $salesOrder=SalesOrdersItems::where('stock_item_id',$stockItem)->whereBetween('created_at',[$startdate,$enddate
        ])->sum('sales_order_items.net_amount');
             return view('admin.dashboard.chart',[
            'salesOrder'=>$salesOrder
        ]);
        }
         
        $salesOrder=SalesOrdersItems::where('stock_item_id',$stockItem)->whereBetween('created_at',[$startdate,$enddate
        ])->sum('sales_order_items.quantity');

        return view('admin.dashboard.chart',[
            'salesOrder'=>$salesOrder
        ]);

        
    }