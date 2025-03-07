<?php

require_once "repositories/StudentRepository.php";
require_once "config/Database.php";

class StudentController {

    private StudentRepository $studentRepository;
    private $databaseConnection;

    public function __construct() {

        $this->databaseConnection = Database::getInstance()->getConnection();
        $this->studentRepository = new StudentRepository($this->databaseConnection, "students");
    }

    public function getAllStudents(): void {
        echo json_encode($this->studentRepository->GetAllList());
    }

    public function getStudentById(int $id): void {
        echo json_encode($this->studentRepository->GetById($id));
    }

    public function addStudent($studentData): void {

    if (is_array($studentData)) {
        $studentData = (object) $studentData;
    }

    $studentData->final_grade = (0.4 * $studentData->midterm_score) + (0.6 * $studentData->final_score);
    $studentData->status = $studentData->final_grade >= 75 ? 'Pass' : 'Fail';

    $this->studentRepository->Add($studentData);
    echo json_encode(["message" => "Student Added Successfully"]);
}

    public function updateStudent($student): void {
        $student->final_grade = (0.4 * $student->midterm_score) + (0.6 * $student->final_score);
        $student->status = $student->final_grade >= 75 ? 'Pass' : 'Fail';
        $this->studentRepository->Update($student);
        echo "Student Updated Successfully";
    }

    public function deleteStudent(int $id): void {
        $this->studentRepository->Delete($id);
        echo "Student Deleted Successfully";
    }
}

?>
