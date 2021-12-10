<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Schema;

class ColumnName implements Rule
{
    /**
     * The database table name.
     *
     * @var \App\Source
     */
    public $table;

    /**
     * To check for column exists or not exists in table.
     *
     * @var \App\Source
     */
    public $action;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table, $action)
    {
        $this->table = $table;
        $this->action = $action;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value = 'not_exists')
    {
        if($this->action == 'exists')
        {
            if (Schema::hasColumn($this->table, $value))
            {
                return true;
            }

            return false;
        }
        else
        {
            if (Schema::hasColumn($this->table, $value))
            {
                return false;
            }

            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if($this->action == 'exists')
        {
            return 'The column name exists in the table.';
        }
        else
        {
            return 'The column name not exists in the table.';
        }
    }
}
