<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        return view('courses.index', [
            'courses' => Course::all()
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required'],
            'wanted_start_date' => ['required'],
            'payment_method' => ['required'],
        ]);

        $course = Course::create($data);

        return redirect()
            ->route('courses.index')
            ->with('message', 'course created');
    }

    public function show(Course $course)
    {
        //
    }

    public function edit(Course $course)
    {
        //
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => ['required'],
            'wanted_start_date' => ['required'],
            'payment_method' => ['required'],
        ]);

        $course->update($data);

        return redirect()
            ->route('courses.index')
            ->with('message', 'Course updated!');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()
            ->route('courses.index')
            ->with('message', 'Course deleted!');
    }
}
