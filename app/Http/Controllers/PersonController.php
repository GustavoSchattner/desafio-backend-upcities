<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Models\Person;
use App\Services\IbgeService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PersonController extends Controller
{
    public function __construct(
        protected IbgeService $ibgeService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $people = Person::latest()->paginate(10);

        return view('people.index', compact('people'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $states = $this->ibgeService->getStates();

        return view('people.create', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonRequest $request): RedirectResponse
    {
        Person::create($request->validated());

        return redirect()->route('people.index')->with('success', 'Person created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Person $person): View
    {
        return view('people.show', compact('person'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Person $person): View
    {
        $states = $this->ibgeService->getStates();

        $cities = $person->uf_id
            ? $this->ibgeService->getCitiesByState($person->uf_id)
            : [];

        return view('people.edit', compact('person', 'states', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonRequest $request, Person $person): RedirectResponse
    {
        $person->update($request->validated());

        return redirect()->route('people.index')->with('success', 'Person updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Person $person): RedirectResponse
    {
        $person->delete();

        return redirect()->route('people.index')->with('success', 'Person deleted successfully.');
    }

    /**
     * Return cities from JSON to consume AJAX in frontend.
     */
    public function getCities(string $ufId): \Illuminate\Http\JsonResponse
    {
        $cities = $this->ibgeService->getCitiesByState($ufId);

        return response()->json($cities);
    }
}
