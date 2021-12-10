<fieldset class="hidden-block scheduler-border">
    <legend class="scheduler-border">Account Details</legend>
    <div class="form-group">
        <div class="form-row">
            <div class="col-md-12"> 
                {!! Form::label('debit_to', 'Debit To') !!}
                {!! Form::number('debit_to', old('debit_to', isset($order->debit_to) ? $order->debit_to : ''), ['class' => 'form-control','placeholder' => 'Debit To']) !!}
            </div>
            <div class="col-md-12">
                {!! Form::label('income_account', 'Income Account') !!}
                {!! Form::number('income_account', old('income_account', isset($order->income_account) ? $order->income_account : ''), ['class' => 'form-control','placeholder' => 'Income Account']) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="form-row">
            <div class="col-md-12"> 
                {!! Form::label('expense_account', 'Expense Account') !!}
                {!! Form::number('expense_account', old('expense_account', isset($order->expense_account) ? $order->expense_account : ''), ['class' => 'form-control','placeholder' => 'Expense Account']) !!}
            </div>
            <div class="col-md-12">
                {!! Form::label('asset', 'Asset') !!}
                {!! Form::number('asset', old('asset', isset($order->asset) ? $order->asset : ''), ['class' => 'form-control','placeholder' => 'Asset']) !!}
            </div>
        </div>
    </div>
</fieldset>