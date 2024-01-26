<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\StadiumResource;
use App\Models\Stadium;
use App\Services\UploadService;
use App\Services\ValidationService;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use Exception;


class StadiumController extends Controller
{
    protected $validationService;
    protected $uploadService;

    public function __construct(ValidationService $validationService, UploadService $uploadService)
    {
        $this->validationService = $validationService;
        $this->uploadService = $uploadService;
    }

    public function index()
    {
        try {
            $stadiums = Stadium::all();
            return response()->json(['stadiums' => StadiumResource::collection($stadiums)], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $stadium = Stadium::findOrFail($id);
            return response()->json(['stadium' => new StadiumResource($stadium)], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            $validator = Validator::make($request->all(), $this->validationService->getStadiumValidationRules($request));

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }
            // Create a new stadium
            $stadium = new Stadium($request->all());
            $stadium->save();

            $imagePath = $this->uploadService->uploadImage($request, 'stadium', $stadium->stadium_id);
            $stadium->image = $imagePath;
            $stadium->save();
            // Upload image
            return response()->json(['stadium' => new StadiumResource($stadium)], 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Kiểm tra dữ liệu vào
            $this->validate($request, [
                'name' => [
                    'string',
                    'max:100',
                    Rule::unique('stadiums', 'name')->ignore($id, 'stadium_id'),
                ],
                'address' => 'required|max:255',
                'image' => 'image|mimes:jpeg,png,jpg,webp,PNG,JPG|max:2048',
                'capacity' => 'integer|min:0'
            ]);


            $stadium = Stadium::where('stadium_id', $id)->first();

            if ($stadium) {
                // Kiểm tra và tải lên ảnh người dùng mới nếu có
                if ($request->hasFile('image')) {
                    $oldImage = $stadium->image;
                    if ($oldImage) {
                        $oldImagePath = str_replace('/storage/', 'public/', $oldImage);
                        // Kiểm tra xem ảnh cũ có tồn tại hay không
                        if (Storage::exists($oldImagePath)) {
                            Storage::delete($oldImagePath);
                        }
                    }

                    // Tải lên ảnh mới
                    $imagePath = $this->uploadService->uploadImage($request, 'stadium', $stadium->stadium_id);
                    $stadium->image = $imagePath;
                }
                $stadium->fill($request->only(['name', 'address', 'capacity']));
                $stadium->save();

                return response()->json(['message' => 'Stadium updated successfully', 'stadium' => new StadiumResource($stadium)], 200);
            } else {
                // Trả về thông báo nếu cầu thủ không tồn tại
                return response()->json(['message' => 'Stadium not found'], 404);
            }
        } catch (ValidationException $e) {
            // Trả về thông báo lỗi xác thực nếu có lỗi
            return response()->json(['errors' => $e->errors()], 400);
        } catch (Exception $e) {
            // Trả về thông báo lỗi nếu có lỗi khác
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            // Find the stadium by ID
            $stadium = Stadium::find($id);

            if (!$stadium) {
                return response()->json(['message' => 'Stadium not found'], 404);
            }

            $directoryToDelete = 'public/upload/stadiums/' . $stadium->stadium_id;

            // Check if the directory exists
            if (Storage::exists($directoryToDelete)) {
                // Delete the directory along with its contents
                Storage::deleteDirectory($directoryToDelete);
            }

            // Delete the stadium
            $stadium->delete();

            return response()->json(['message' => 'Stadium deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

}
