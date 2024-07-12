<?php

namespace App\Http\Controllers;

use App\Filament\Resources\PatientResource\Pages\ListPatients;
use App\Filament\Pages\Settings;
use App\Models\Owner;
use App\Models\Patient;
use App\Models\Treatment;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Nome da sua teste Laravel + Filament",
 *     version="1.0.0",
 *     description="laravellllllllllllll",
 *     @OA\Contact(
 *         email="contato@example.com",
 *         name="Nome do contato"
 *     ),
 *     @OA\License(
 *         name="MIT License",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 */


class ShowAll extends Controller
{
    


        /**
*  @OA\GET(
*      path="/api/index",
*      summary="Get all users",
*      description="Get all users",
*      tags={"Test"},
*      @OA\Parameter(
*         name="name",
*         in="query",
*         description="name",
*         required=false,
*      ),
*      @OA\Response(
*          response=200,
*          description="OK",
*          @OA\MediaType(
*              mediaType="application/json",
*          )
*      ),
*
*  )
*/
    public function index()
    {
        $patients = Patient::all();
        $owners = Owner::all();
        $treatments = Treatment::all();

        return response()->json([
           "Patient" => $patients,
           "Owners" => $owners,
           "Treatments" => $treatments
        ]);
    }


    public static function show()
    {
        
        $patients = Patient::all();
        $owners = Owner::all();
        $treatments = Treatment::all();


        return view('mostrar.index')
            ->with('patients', $patients)
            ->with('owners', $owners)
            ->with('treatments', $treatments);
    }
    
    
}
