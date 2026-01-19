<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ErrorReport;
use Illuminate\Http\Request;

class ErrorController extends Controller {

    // GET /api/errors: Listar todos los errores
    public function index() {
        return response()->json(ErrorReport::all()); 
    }

    // GET /api/errors/{code}: Buscar por código
    public function show($code) {
        // Busca el error por el campo 'code'
        $error = ErrorReport::where('code', $code)->firstOrFail(); 
        return response()->json($error);
    }

    // POST /api/errors: Crear un nuevo error
    public function store(Request $request) {
        $data = $request->validate([
            'code' => 'required|integer',
            'description' => 'required|string',
            'date' => 'required|date'
        ]);

        $error = ErrorReport::create($data);
        return response()->json($error, 201);
    }
}