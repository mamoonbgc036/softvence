<?php

namespace App\Repositories;

use App\Models\Course;
use App\Repositories\Contracts\CourseRepositoryInterface;


class CourseRepository implements CourseRepositoryInterface
{
    public function createCourseWithModules(array $courseData): Course
    {
        $course = Course::create([
            'courses_title' => $courseData['courses_title'],
        ]);

        foreach ($courseData['modules'] as $module) {
            $course->modules()->create([
                'title' => $module['title'],
                'body' => $module['body'],
            ]);
        }

        return $course;
    }
}
