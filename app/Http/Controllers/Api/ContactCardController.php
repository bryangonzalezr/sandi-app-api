<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactCardRequest;
use App\Http\Requests\UpdateContactCardRequest;
use App\Models\ContactCard;
use Illuminate\Http\Request;

class ContactCardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:contact_card.view'])->only(['index','show']);
        $this->middleware(['can:contact_card.create'])->only('store');
        $this->middleware(['can:contact_card.update'])->only('update');
        $this->middleware(['can:contact_card.delete'])->only('delete');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactCardRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactCard $contactCard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactCardRequest $request, ContactCard $contactCard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactCard $contactCard)
    {
        //
    }
}
