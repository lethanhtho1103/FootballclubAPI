<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Stadium;
use App\Services\UploadService;
use App\Services\ValidationService;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class StadiumController extends Controller
{
    protected $validationService;
    protected $uploadServices;

    public function __construct(ValidationService $validationService, UploadService $uploadServices){
        $this->validationService = $validationService;
        $this->uploadServices = $uploadServices;
    }
}
