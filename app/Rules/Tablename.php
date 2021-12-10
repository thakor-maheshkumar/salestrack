<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Schema;

class Tablename implements Rule
{
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
    public function __construct($action = 'not_exists')
    {
        $this->action = $action;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if($this->action == 'exists')
        {
            if (Schema::hasTable($value))
            {
                return true;
            }

            return false;
        }
        else
        {
            if (Schema::hasTable($value))
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
            return 'The :attribute not exists.';
        }
        else
        {
            return 'The :attribute name already exists.';
        }
    }
}
