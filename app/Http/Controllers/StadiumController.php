<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\StadiumResource;
use App\Models\Stadium;
use App\Services\UploadService;
use App\Services\ValidationService;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;


class StadiumController extends Controller
{
    protected $validationService;
    protected $uploadServices;

    public function __construct(ValidationService $validationService, UploadService $uploadServices)
    {
        $this->validationService = $validationService;
        $this->uploadServices = $uploadServices;
    }

    public function index()
    {
        try {
            $stadiums = Stadium::paginate(10);
            return response()->json(['stadiums' => StadiumResource::collection($stadiums)], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }



}
