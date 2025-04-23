<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    protected $student;
    public function __construct(){
        $this->student = new Student();
        
    }
    public function index()
    {
        try {
            return response()->json($this->student->all(), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
     
    }
    
    public function store(Request $request)
    {  
        try {
            $student = $this->student->create($request->all());
            return response()->json($student, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }
  
    public function show(string $id)
    {
        try {
            $student = $this->student->find($id);
            if (!$student) {
                return response()->json(['error' => 'student not found'], 404);
            }
            return response()->json($student, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
    public function update(Request $request, string $id)
    {
        try {
            $student = $this->student->find($id);
            if (!$student) {
                return response()->json(['error' => 'student not found'], 404);
            }
            $student->update($request->all());
            return response()->json($student, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
    public function destroy(string $id)
    {
        try {
            $student = $this->student->find($id);
            if (!$student) {
                return response()->json(['error' => 'student not found'], 404);
            }
            $student->delete();
            return response()->json(['message' => 'student deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
