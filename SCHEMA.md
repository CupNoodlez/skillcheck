# SkillCheck Database ERD

This document outlines the entity-relationship diagram (ERD) and detailed table definitions for the SkillCheck exam platform database schema.

```mermaid
erDiagram
    Users ||--o{ Exams : "creates"
    Users ||--o{ Exam_Attempts : "attempts"
    Exams ||--o{ Questions : "contains"
    Exams ||--o{ Exam_Attempts : "has"
    Questions ||--o{ Options : "has"
    Questions ||--o{ Student_Answers : "answered_in"
    Exam_Attempts ||--o{ Student_Answers : "records"
    Options ||--o{ Student_Answers : "selected_in"

    Users {
        uuid user_id PK
        string username
        string first_name
        string last_name
        string middle_name
        string email UK
        string password_hash
        string role "admin/instructor/student"
        string profile_picture
        boolean is_suspended
        timestamp created_at
    }

    Exams {
        uuid exam_id PK
        uuid instructor_id FK
        string title
        text description
        datetime start_time
        datetime end_time
        string timer_type "whole_exam/per_question"
        integer duration_m
        boolean randomize_questions
        boolean viewable_responses
        timestamp created_at
    }

    Questions {
        uuid question_id PK
        uuid exam_id FK
        integer order_index
        text question_text
        string image_url
        string type "multiple_choice/question_answer/essay"
        integer time_limit_s
        decimal marks
        boolean is_locked
        timestamp created_at
    }

    Options {
        uuid option_id PK
        uuid question_id FK
        integer order_index
        text option_text
        boolean is_correct
        timestamp created_at
    }

    Exam_Attempts {
        uuid attempt_id PK
        uuid exam_id FK
        uuid student_id FK
        timestamp start_time
        timestamp end_time
        string status "in_progress/submitted/graded"
        json question_order
        timestamp created_at
    }

    Student_Answers {
        uuid answer_id PK
        uuid attempt_id FK
        uuid question_id FK
        uuid selected_option FK
        text text_answer
        decimal marks_awarded
        timestamp created_at
    }
```

---

## Detailed Table Schemas

### 1. `Users`
Stores authentication credentials, user profiles, and roles within the application.
- **`user_id`**: Primary Key (UUID).
- **`username`**: Unique handle for authentication.
- **`first_name`**, **`last_name`**, **`middle_name`**: User's parsed name fields.
- **`email`**: User's unique email.
- **`role`**: Users are restricted to `'admin'`, `'instructor'`, or `'student'`.
- **`is_suspended`**: Tracks suspension status.

### 2. `Exams`
Stores assessment details configured by instructors.
- **`exam_id`**: Primary Key (UUID).
- **`instructor_id`**: Foreign Key linking to the `Users` table (the creator).
- **`timer_type`**: Designates whether the exam timer is `'whole_exam'` or `'per_question'`.
- **`duration_m`**: The total exam limit in minutes. Null for per-question timed exams.
- **`randomize_questions`**: Flag to shuffle question delivery order for students.
- **`viewable_responses`**: Flag to allow students to review details after grading.

### 3. `Questions`
Individual questions associated with an exam.
- **`question_id`**: Primary Key (UUID).
- **`exam_id`**: Foreign Key linking to the `Exams` table.
- **`type`**: Supports `'multiple_choice'`, `'question_answer'` (short answer), or `'essay'`.
- **`time_limit_s`**: The time limit in seconds for the question. Required if `timer_type` is `'per_question'`.
- **`marks`**: Point value of the question.

### 4. `Options`
Predefined options for multiple-choice questions or correct answer strings for short-answer questions.
- **`option_id`**: Primary Key (UUID).
- **`question_id`**: Foreign Key linking to the `Questions` table.
- **`is_correct`**: Flag designating whether this option is a correct answer.

### 5. `Exam_Attempts`
A student's session taking a specific exam.
- **`attempt_id`**: Primary Key (UUID).
- **`exam_id`**: Foreign Key linking to the `Exams` table.
- **`student_id`**: Foreign Key linking to the `Users` table (the examinee).
- **`status`**: Current status: `'in_progress'`, `'submitted'`, or `'graded'`.
- **`question_order`**: JSON list tracking the exact random/sequential order of questions served to the student.

### 6. `Student_Answers`
Individual question responses recorded under a specific attempt.
- **`answer_id`**: Primary Key (UUID).
- **`attempt_id`**: Foreign Key linking to the `Exam_Attempts` table.
- **`question_id`**: Foreign Key linking to the `Questions` table.
- **`selected_option`**: Foreign Key linking to the `Options` table (for multiple choice).
- **`text_answer`**: Text response (for essays or short answers).
- **`marks_awarded`**: Score given for the answer (auto-graded for MCQs/QAs, manually graded for essays).
