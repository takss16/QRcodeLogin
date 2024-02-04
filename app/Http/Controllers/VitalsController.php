<?php

namespace App\Http\Controllers;

use App\Models\Vitals;
use App\Models\Employees;
use Illuminate\Http\Request;
use App\Http\Requests\StoreVitalsRequest;
use App\Http\Requests\UpdateVitalsRequest;
use Illuminate\Routing\Controller;


class VitalsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function store($employee_id, Request $request)
    {
        $authenticatedEmployee = Employees::where('employee_id', $employee_id)->first();

        if (!$authenticatedEmployee) {
            return redirect()->route('index')->with('error', 'Invalid Employee ID');
        }

        $existingVitals = $authenticatedEmployee->vitals()
            ->where('month', now()->format('F'))
            ->where('year', now()->year)
            ->exists();

        if ($existingVitals) {
            return redirect()->back()->with('error', 'Vitals already recorded for this month.');
        }

        $validatedData = $request->validate([
            'pulse_rate' => 'required|numeric',
            'body_temperature' => 'required|numeric',
            'respiratory_rate' => 'required|numeric',
            'bp' => 'required|string',
            'bmi' => 'required|numeric',
        ]);


        $authenticatedEmployee->vitals()->create([
            'month' => now()->format('F'),
            'year' => now()->year,
            'pulse_rate' => $validatedData['pulse_rate'],
            'body_temperature' => $validatedData['body_temperature'],
            'respiratory_rate' => $validatedData['respiratory_rate'],
            'bp' => $validatedData['bp'],
            'bmi' => $validatedData['bmi'],
        ]);

        return redirect()->back()->with('success', 'Vitals recorded successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Vitals $vitals)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vitals $vitals)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVitalsRequest $request, Vitals $vitals)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vitals $vitals)
    {
        //
    }
}
