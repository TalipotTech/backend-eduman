<?php

namespace App\Enums;

enum QuizCategoryEnum: string
{
    case FINAL_EXAM = 'Final Exam';
    case CLASS_TEST = 'Class Test';
    case MOCK_TEST = 'Mock Test';
}