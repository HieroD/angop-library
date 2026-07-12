<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AuthorBook extends Pivot
{
    public $incrementing = false;

    public $timestamps = false;
}
