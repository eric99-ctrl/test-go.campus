<?php

namespace App\Http\Controllers\API;

use App\Models\Creator;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

class CreatorController extends BaseController
{
    public function all()
    {
        $creators = Creator::all();
        return $this->sendResponse($creators, 'Creator retrieved successfully.');
    }
}
