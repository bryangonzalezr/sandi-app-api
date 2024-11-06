<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExperienceRequest;
use App\Http\Requests\UpdateExperienceRequest;
use App\Http\Resources\ExperienceResource;
use App\Models\Experience;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Experience::where('nutritionist_id', Auth::id())->orderBy('created_at','desc');

        $experiences = $request->boolean('paginate')
            ? $query->paginate(4)
            : $query->get();

        return ExperienceResource::collection($experiences);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExperienceRequest $request)
    {
        $experience = Experience::create(
            [
                "nutritionist_id" => Auth::id(),
                "type" => $request->type,
                "title" => $request->title,
                "institution" => $request->institution,
                "description" => $request->description,
                "start_date" => Carbon::createFromFormat('d/m/Y' ,$request->start_date)->toDateString(),
                "end_date" => $request->end_date ? Carbon::createFromFormat('d/m/Y' ,$request->end_date)->toDateString() : null,
            ]
        );

        return new ExperienceResource($experience);
    }

    /**
     * Display the specified resource.
     */
    public function show(Experience $experience)
    {
        return new ExperienceResource($experience);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExperienceRequest $request, Experience $experience)
    {
        $experience->update(
            [
                "nutritionist_id" => Auth::id(),
                "type" => $request->type,
                "title" => $request->title,
                "institution" => $request->institution,
                "description" => $request->description,
                "start_date" => Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'),
                "end_date" => $request->end_date ? Carbon::createFromFormat('d/m/Y' ,$request->end_date)->toDateString() : null,
            ]
        );

        return new ExperienceResource($experience);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Experience $experience)
    {
        $experience->delete();
        return response()->json([
            "message" => "Experiencia eliminada satisfactoriamente"
        ]);
    }
}
