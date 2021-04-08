<?php

namespace App\Http\Controllers\Api;

use App\Model\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->perPage ?: 1;

        $data = Employee::paginate($perPage);

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required||max:255',
            'email' => 'required|unique:employees|max:255',
            'phone' => 'required|unique:employees|max:25',
            'join_at' => 'required',
            'salary' => 'max:25',
            'address' => 'max:255',
            'photo' => '',
        ]);
        $result = ['status' => false, 'data' => ['errors' => []]];

        if ($request->photo) {
            $position = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $position);
            $extension = explode('/', $sub)[1];
            $imageName = time() . '.' . $extension;
            $basePath = config('filesystems.disks.public_uploads.root');
            $uploadPath = '/employees';
            if (!is_dir($basePath . $uploadPath)) {
                mkdir($basePath . $uploadPath, 0777, true);
            }
            $imageUrl = $basePath . $uploadPath . '/' . $imageName;
            $image = Image::make($request->photo)->resize(160, 160);
            $imageStatus = $image->save($imageUrl);

            if ($imageStatus) {
                $validateData['photo'] = $uploadPath . '/' . $imageName;
            }
        }

        $employee = Employee::create($validateData);
        if ($employee) {
            $result['status'] = true;
        }

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Employee::all();

        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
