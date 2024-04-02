<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return Submission::latest()->get();
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // Validate the incoming request
    $validatedData = $request->validate([
      'text' => 'required|max:100',
      'radio' => 'required',
      'checkbox' => 'required|array',
      'checkbox.*' => 'required|string', // if checkboxes are sent as an array
      'image' => 'required|image|max:2048', // max 2MB image
    ]);

    // Handle file upload
    if ($request->hasFile('image')) {
      $path = $request->file('image')->store('public/images');
    }

    // Create and store the submission
    $submission = Submission::create([
      'text' => $validatedData['text'],
      'radio' => $validatedData['radio'],
      'checkbox' => implode(',', $validatedData['checkbox']), // Save checkboxes as a comma-separated string
      'image' => $path ?? '', // Store the path of the image
    ]);

    return response()->json($submission, 201);
  }

  /**
   * Display the specified resource.
   */
  public function show(Submission $submission)
  {
    return response()->json([
      'submission' => $submission
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Submission $submission)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Submission $submission)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Submission $submission)
  {
    //
  }
}
