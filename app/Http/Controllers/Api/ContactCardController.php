<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactCardRequest;
use App\Http\Requests\UpdateContactCardRequest;
use App\Http\Resources\ContactCardResource;
use App\Models\ContactCard;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactCardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:contact_cards.view'])->only(['index','show']);
        $this->middleware(['can:contact_cards.create'])->only('store');
        $this->middleware(['can:contact_cards.update'])->only('update');
        $this->middleware(['can:contact_cards.delete'])->only('delete');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = ContactCard::with(['nutritionist', 'commune','nutritionist.experiences','commune.provinces.regions'])
        ->when($request->filled('commune'), function ($query) use ($request) {
            $query->where('commune_id', $request->integer('commune'));
        });

        $contact_cards = $request->boolean('paginate')
            ? $query->paginate(5)
            : $query->get();

        return ContactCardResource::collection($contact_cards);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactCardRequest $request)
    {
        $contact_card = ContactCard::with(['nutritionist', 'commune', 'nutritionist.experiences', 'commune.provinces.regions'])
        ->firstOrCreate([
            'nutritionist_id' => Auth::id()
        ],[
            'commune_id' => $request->input('commune_id'),
            'address' => $request->input('address'),
            'slogan' => $request->input('slogan'),
            'specialties' => $request->input('specialties'),
            'description' => $request->input('description'),
        ]);

        return new ContactCardResource($contact_card);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $contactCard = ContactCard::with(['nutritionist', 'commune','nutritionist.experiences', 'commune.provinces.regions'])
        ->where('nutritionist_id', $user->id)->first();
        return new ContactCardResource($contactCard);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactCardRequest $request, ContactCard $contactCard)
    {

        $contactCard->update($request->validated());

        return new ContactCardResource($contactCard);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactCard $contactCard)
    {
        $contactCard->delete();
        return response()->json([
            'message' => 'Tarjeta de contacto desactivada exitosamente'
        ]);
    }
}
