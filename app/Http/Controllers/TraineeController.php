<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trainee;
class TraineeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trainees = Trainee::all();
        return response()->json($trainees);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:trainees,email',
            'phone_number' => 'required|string|max:20',
            'birth_date' => 'required|date',
        ]);


        $trainee = Trainee::create($validatedData);

        return response()->json($trainee, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $trainee = Trainee::find($id);

        if (!$trainee) {
            return response()->json(['message' => 'Trainee not found'], 404);
        }

        return response()->json($trainee);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $trainee = Trainee::find($id);

        if (!$trainee) {
            return response()->json(['message' => 'Trainee not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:trainees,email,' . $id,
            'phone_number' => 'sometimes|required|string|max:20',
            'birth_date' => 'sometimes|required|date',
        ]);

        $trainee->update($validatedData);

        return response()->json($trainee);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $trainee = Trainee::find($id);

        if (!$trainee) {
            return response()->json(['message' => 'Trainee not found'], 404);
        }

        $trainee->delete();

        return response()->json(['message' => 'Trainee deleted successfully']);
    }

    public function search($name)
    {
        // البحث عن المتدربين الذين يحتوي اسمهم على الجزء المدخل
        $trainees = Trainee::where('name', 'like', '%' . $name . '%')->get();

        // إرجاع البيانات بشكل JSON
        if ($trainees->isEmpty()) {
            return response()->json(['message' => 'No trainees found.'], 404);
        }

        return response()->json($trainees);
    }

}