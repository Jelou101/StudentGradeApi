<?php

class Student {
    public $id;
    public $name;
    public $midterm_score;
    public $final_score;
    public $final_grade;
    public $status;

    public function __construct($id, $name, $midterm_score, $final_score, $final_grade, $status) {
        $this->id = $id;
        $this->name = $name;
        $this->midterm_score = $midterm_score;
        $this->final_score = $final_score;
        $this->final_grade = $final_grade;
        $this->status = $status;
    }
}
?>
