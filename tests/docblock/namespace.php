<?php

declare(strict_types=1);

namespace Entities {

    class Student {}

    class Subject {}

    class Teacher {}
}

namespace Code {

    use Entities\Student;

    class Room {}

    /** @var array<int,Room> */
    $rooms = [];  // OK - class is defined in same namespace

    /** @var array<int,Student> */
    $students = [];  // OK - included via use statement

    /** @var array<int,\Entities\Subject> */
    $subjects = []; // OK - FQCN is used

    /** @var array<int,Teacher> */
    $teachers = []; // ERROR: Unknown class
}
