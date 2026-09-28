<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = [[
            'name' => 'Andhika',
            'major' => 'SIKC',
            'age' => 20,
            'courses' => ['Pemrograman Web', 'Pemrograman Mobile', 'Pemrograman Desktop'],
        ], [
            'name' => 'Budi',
            'major' => 'SI',
            'age' => 19,
            'courses' => ['Pemrograman Web', 'Pemrograman Mobile'],
        ]];
        return view('students.index', compact('students'));
    }
}
