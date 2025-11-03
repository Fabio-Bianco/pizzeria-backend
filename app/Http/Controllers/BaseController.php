<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\HasCrud;

abstract class BaseController extends Controller
{
    use HasCrud;
}