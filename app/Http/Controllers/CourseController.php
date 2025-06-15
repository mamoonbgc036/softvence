<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Repositories\Contracts\CourseRepositoryInterface;

class CourseController extends Controller
{
    protected $courseRepo;

    public function __construct(CourseRepositoryInterface $courseRepo)
    {
        $this->courseRepo = $courseRepo;
    }

    public function index()
    {
        return view('course.index');
    }

    public function store(StoreCourseRequest $request)
    {
        $validated = $request->validated();

        foreach ($validated['courses'] as $courseData) {
            $this->courseRepo->createCourseWithModules($courseData);
        }

        return redirect()->back()->with('success', 'Courses and blogs saved successfully!');
    }
}
