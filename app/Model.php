<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{

    /**
     * This model is responsible to enable mass assignable for the children classes.
     */

    /**
     * The following attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

}