<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        try {
            return Role::all();
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des roles',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
