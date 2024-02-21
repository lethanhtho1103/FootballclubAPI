<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContractResource;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

use App\Models\Contract;
use App\Services\ValidationService;
use App\Services\UploadService;

use Exception;

class ContractController extends Controller
{
    private $validationService;
    private $uploadService;

    public function __construct(ValidationService $validationService, UploadService $uploadService)
    {
        $this->validationService = $validationService;
        $this->uploadService = $uploadService;
    }

    public function index()
    {
        try {
            $contracts = Contract::all();
            return response()->json(['contracts' => ContractResource::collection($contracts)], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $contract = Contract::findOrFail($id);
            return response()->json(['contract' => new ContractResource($contract)], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function getByType($type)
    {
        try {
            $contracts = Contract::where('type', $type)->get();
            return response()->json(['contracts' => ContractResource::collection($contracts)], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $this->validationService->getContractValidationRules($request);
            $this->validate($request, $validatedData);

            // Store the PDF file
            $pdfPath = $this->uploadService->uploadPDF($request, 'contract', '');

            // Create a new contract instance
            $contract = new Contract([
                'user_id' => $request->user_id,
                'date_created' => $request->date_created,
                'expiration_date' => $request->expiration_date,
                'salary' => $request->salary,
                'pdf' => $pdfPath,
                'type' => $request->type,
            ]);

            // Save the contract to the database
            $contract->save();

            // Load the user associated with the contract
            $contract->load('user');

            return response()->json(['message' => 'Contract created successfully', 'contract' => new ContractResource($contract)], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 400);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // Other controller methods (update, delete, etc.) can be added here

    public function update(Request $request, $id)
    {
        try {
            // Find the contract by ID
            $contract = Contract::findOrFail($id);

            // Validate the incoming request data
            $validatedData = $this->validationService->getContractValidationRules($request);
            $this->validate($request, $validatedData);

            // Update the contract fields
            $contract->user_id = $request->user_id;
            $contract->date_created = $request->date_created;
            $contract->expiration_date = $request->expiration_date;
            $contract->salary = $request->salary;
            $contract->type = $request->type;

            // If a new PDF is provided, upload and update the PDF path
            if ($request->hasFile('pdf')) {
                $oldPdfPath = str_replace('/storage/', 'public/', $contract->pdf);

                // Kiểm tra xem ảnh cũ có tồn tại hay không
                if (Storage::exists($oldPdfPath)) {
                    Storage::delete($oldPdfPath);
                }
                $pdfPath = $this->uploadService->uploadPDF($request, 'contract', $id);
                $contract->pdf = $pdfPath;
            }


            // Save the updated contract to the database
            $contract->save();

            // Load the user associated with the contract
            $contract->load('user');

            return response()->json(['message' => 'Contract updated successfully', 'contract' => new ContractResource($contract)], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 400);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            // Find the contract by ID
            $contract = Contract::findOrFail($id);

            // Delete the PDF file
            Storage::delete($contract->pdf);

            // Delete the contract
            $contract->delete();

            return response()->json(['message' => 'Contract deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

}
