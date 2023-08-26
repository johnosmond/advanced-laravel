<?php

namespace App\Http\Controllers;

use App\Events\ClassCancelled;
use App\Models\ClassType;
use App\Models\ScheduledClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduledClassContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scheduledClasses = auth()->user()->scheduledClasses()->upcoming()->oldest('date_time')->get();
        return view('instructor.upcoming')->with('scheduledClasses', $scheduledClasses);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classTypes = ClassType::all();
        return view('instructor.schedule')->with('classTypes', $classTypes);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Define validation rules and messages
        $validationRules = [
            'class_type_id' => 'required',
            'date' => 'required',
            'time' => 'required',
            'date_time' => 'unique:scheduled_classes,date_time|after:now'
        ];

        $customMessages = [
            'class_type_id.required' => 'A class type is required.',
            'date.required' => 'A date is required.',
            'time.required' => 'A time is required.',
            'date_time.unique' => 'That time slot is already taken.',
            'date_time.after' => 'The date and time must be in the future.'
        ];

        // Validate each field separately
        $classValidator = Validator::make($request->only('class_type_id'), [
            'class_type_id' => 'required'
        ], $customMessages);

        $dateValidator = Validator::make($request->only('date'), [
            'date' => 'required'
        ], $customMessages);

        $timeValidator = Validator::make($request->only('time'), [
            'time' => 'required'
        ], $customMessages);

        // Check if any validation fails and redirect back with errors
        if ($classValidator->fails()) {
            return redirect()->back()->withErrors($classValidator)->withInput();
        }

        if ($dateValidator->fails()) {
            return redirect()->back()->withErrors($dateValidator)->withInput();
        }

        if ($timeValidator->fails()) {
            return redirect()->back()->withErrors($timeValidator)->withInput();
        }

        // If both date and time are provided, merge them into 'date_time'
        $date_time = $request->input('date') . " " . $request->input('time');

        $request->merge([
            'date_time' => $date_time,
            'instructor_id' => auth()->id()
        ]);

        // Validate date_time
        $dateTimeValidator = Validator::make($request->only('date_time'), [
            'date_time' => 'unique:scheduled_classes,date_time|after:now'
        ], $customMessages);

        if ($dateTimeValidator->fails()) {
            return redirect()->back()->withErrors($dateTimeValidator)->withInput();
        }

        $validated = $request->except(['date', 'time']);

        ScheduledClass::create($validated);

        // Redirect or do whatever you need after successful creation
        return redirect()->route('schedule.index')->with('success', 'Scheduled class created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ScheduledClass $schedule)
    {
        if (auth()->user()->cannot('delete', $schedule)) {
            abort(403);
        }

        ClassCancelled::dispatch($schedule);

        $schedule->members()->detach();
        $schedule->delete();

        return redirect()->route('schedule.index')->with('success', 'Scheduled class deleted successfully.');
    }
}
