<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use App\Http\ModelTransformer;
use App\Http\ApiResponse;
use App\Models\Traits\Sortable;
use App\Models\Traits\Filterable;
use App\Models\Traits\Searchable;
use App\Models\Traits\Row;

class Controller extends BaseController
{
    use ModelTransformer, ApiResponse, Sortable, Filterable, Searchable, Row;
}
