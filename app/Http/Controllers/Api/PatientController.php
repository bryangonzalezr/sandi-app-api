<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Http\Resources\PatientResource;
use App\Http\Resources\UserResource;
use App\Models\ChatMessage;
use App\Models\NutritionalPlan;
use App\Models\NutritionalProfile;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:users.view_patient_users'])->only(['index','show']);
        $this->middleware(['can:users.create_patient_users'])->only('store');
        $this->middleware(['can:delete_patient_users'])->only('delete');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate(['archivados' => 'nullable|boolean']);

        $patients = Patient::where('nutritionist_id', Auth::id())
        ->when($request->filled('archivados'), function ($query) use ($request){
            if ($request->boolean('archivados')){
                $query->onlyTrashed();
            }
        })
        ->get();
        $patient_users = User::whereIn('id', $patients->pluck('patient_id'))->orderBy('created_at','desc');

        $patient_users = $request->boolean('paginate')
        ? $patient_users->paginate(15)
        : $patient_users->get();
        return UserResource::collection($patient_users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {
        $patient_user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'sex' => $request->sex,
            'birthdate' => $request->birthdate,
            'age' => Carbon::parse($request->birthdate)->age,
            'phone_number' => $request->phone_number,
            'civil_status' => $request->civil_status,
            'description' => $request->description,
            'objectives' => $request->objectives,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $patient_user->assignRole('paciente');
        $nutritional_profile = NutritionalProfile::create([
            'patient_id' => $patient_user->id,
            'nutritional_state' => "",
            'description' => "",
            'height' => 0,
            'weight' => 0,
            'physical_comentario' => "",
            'physical_status' => "",
            'habits' => "",
            'allergies' => "",
            'morbid_antecedents' => "",
            'patient_type' => "",
            'family_antecedents' => "",
            'digestion' => "",
            'subjective_assessment' => "",
            'nutritional_anamnesis' => "",
        ]);

        $patient = Patient::create([
            'nutritionist_id' => Auth::id(),
            'patient_id' => $patient_user->id
        ]);

        return new UserResource($patient_user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $patient)
    {
        $patient_user = User::with('nutritionalProfile')->find($patient->id);
        return new PatientResource($patient_user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $patient)
    {
        $patient->removeRole('paciente');
        $patient->assignRole('usuario_basico');

        $plan = NutritionalPlan::where('patient_id', $patient->id)->delete();

        $messages = ChatMessage::query()
        ->with(['sender', 'receiver'])
        ->where(function($query) use ($patient){
            $query->where('sender_id', Auth::id())
                ->where('receiver_id', $patient->id);
        })
        ->orWhere(function($query) use ($patient){
            $query->where('sender_id', $patient->id)
                ->where('receiver_id', Auth::id());
        })
        ->delete();

        $patient_user = Patient::where('patient_id', $patient->id)->delete();

        return response()->json([
            'message' => 'Paciente desvinculado satisfactoriamente'
        ]);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(User $patient)
    {
        $patient_user = Patient::withTrashed()->where('patient_id', $patient->id)->first();
        $patient_user->restore();
        $patient->removeRole('usuario_basico');
        $patient->assignRole('paciente');
        $nutritionalPlan = $patient->nutritionalPlan()->withTrashed()->first();
        if($nutritionalPlan){
            $nutritionalPlan->restore();
        }

        $messages = ChatMessage::onlyTrashed()
        ->with(['sender', 'receiver'])
        ->where(function($query) use ($patient){
            $query->where('sender_id', Auth::id())
                ->where('receiver_id', $patient->id);
        })
        ->orWhere(function($query) use ($patient){
            $query->where('sender_id', $patient->id)
                ->where('receiver_id', Auth::id());
        })
        ->restore();

        return response()->json([
            'message' => 'Paciente restaurado satisfactoriamente'
        ]);
    }
}
