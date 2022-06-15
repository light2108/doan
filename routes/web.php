<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//backend

Route::prefix('admin')->namespace('Admin')->group(function(){
    Route::match(['get', 'post'], '/', 'AdminController@Login');
    Route::match(['get', 'post'], '/forgot-password', 'AdminController@forgotPassword');
    Route::match(['get', 'post'], '/reset-password/{email}/{code}', 'AdminController@resetPassword');
    Route::group(['middleware'=>'admin'], function(){
        Route::get('/dashboard', 'AdminController@Index');
        Route::get('/logout', 'AdminController@Logout');
        //Admins
        Route::match(['get', 'post'], '/change-detail', 'AdminController@changeDetail');
        Route::match(['get', 'post'], '/change-password', 'AdminController@changePassword');
        Route::post('check-update-pwd', 'AdminController@checkUpdatePassword');
        //Exams
        Route::get('/exams', 'ExamController@Index');
        Route::match(['get', 'post'], '/add-exam', 'ExamController@addExam');
        Route::match(['get', 'post'], '/edit-exam/{id}', 'ExamController@editExam');
        Route::get('/delete-exam/{id}', 'ExamController@deleteExam');
        Route::post('/status/exam', 'ExamController@StatusExam');
        Route::get('/delete-all/exams', 'ExamController@DeleteAll');
        Route::match(['get', 'post'], '/append/class/exam', 'ExamController@appendClassExam');
        //Questions Exam
        Route::get('questions/grade/{grade_id}/exam/{id}', ['as'=>'admin.question.grade.exam', 'uses'=>'QuestionExamController@Index']);
        Route::get('/delete-all/questions-exam', 'QuestionExamController@DeleteAll');
        Route::post('/status/questions-exam', 'QuestionExamController@StatusQuestion');
        Route::post('/update-question', 'QuestionExamController@updateQuestion');
        Route::match(['get', 'post'], 'add-question/grade/{grade_id}/exam/{id}', ['as'=>'admin.add-question.grade.exam', 'uses'=>'QuestionExamController@addQuestion']);
        Route::match(['get', 'post'], 'edit-question/{question_id}/grade/{grade_id}/exam/{id}',['as'=>'admin.edit-question.grade.exam', 'uses'=>'QuestionExamController@editQuestion']);
        //Random QuestionsAnswers
        Route::post('/random-question', 'QuestionExamController@randomQuestion');

        //Answer Exam
        Route::get('question/{question_id}/exam/{exam_id}/answer', ['as'=>'admin.question.exam.answer', 'uses'=>'AnswerExamController@Index']);
        Route::match(['get', 'post'], 'add-answer/question/{question_id}/exam/{exam_id}', ['as'=>'admin.add-answer.question.exam', 'uses'=>'AnswerExamController@addAnswer']);
        Route::match(['get', 'post'], 'edit-answer/{answer_id}/question/{question_id}/exam/{exam_id}', ['as'=>'admin.edit-answer.question.exam', 'uses'=>'AnswerExamController@editAnswer']);
        Route::match(['get', 'post'], 'delete-answer/{answer_id}', ['as'=>'admin.delete-question.exam.answer', 'uses'=>'AnswerExamController@deleteAnswer']);
        Route::post('/status/answer', 'AnswerExamController@statusAnswer');
        Route::get('/delete-all/answer', 'AnswerExamController@DeleteAll');
        //Teachers
        Route::get('/teachers', 'TeacherController@index');
        Route::match(['get', 'post'], '/add-teacher', 'TeacherController@addTeacher');
        Route::match(['get', 'post'], '/edit-teacher/{id}', 'TeacherController@editTeacher');
        Route::get('/delete-all/teachers', 'TeacherController@DeleteAll');
        Route::get('/delete-teacher/{id}', 'TeacherController@deleteTeacher');
        Route::post('/status/teacher', 'TeacherController@StatusTeacher');
        Route::match(['get', 'post'], '/import-file-teacher', 'TeacherController@ImportFileTeacher');
        Route::get('/export-file-teacher', 'TeacherController@ExportFileTeacher');
        //subjects
        Route::get('/subjects', 'SubjectController@Index');
        Route::post('/add-subject', 'SubjectController@Add');
        Route::post('/edit-subject/{id}', 'SubjectController@Edit');
        Route::get('/delete-all/subjects', 'SubjectController@DeleteAll');
        Route::post('/status/subject', 'SubjectController@StatusSubject');
        Route::get('/delete-subject/{id}', 'SubjectController@Delete');

        //students
        Route::get('/students', 'StudentController@Index');
        Route::match(['get', 'post'], '/add-student', 'StudentController@addStudent');
        Route::match(['get', 'post'], '/edit-student/{id}', 'StudentController@editStudent');
        Route::get('/delete-student/{id}', 'StudentController@deleteStudent');
        Route::get('/delete-all/students', 'StudentController@DeleteAll');
        Route::post('/status/student', 'StudentController@StatusStudent');
        Route::match(['get', 'post'], '/append/class', 'StudentController@AppendClass');
        Route::match(['get', 'post'], '/import-file-student', 'StudentController@ImportFileStudent');
        Route::get('/export-file-student', 'StudentController@ExportFileStudent');
        //Classes
        Route::get('/classes', 'ClassController@Index');
        Route::post('/add-class', 'ClassController@AddClass');
        Route::post('edit-class/{id}', 'ClassController@EditClass');
        Route::get('/delete-class/{id}', 'ClassController@DeleteClass');
        Route::get('/delete-all/classes', 'ClassController@DeleteAll');
        Route::post('/status/class', 'ClassController@StatusClass');
        //Grades
        Route::get('/grades', 'GradeController@Index');
        Route::post('/add-grade', 'GradeController@AddGrade');
        Route::post('edit-grade/{id}', 'GradeController@EditGrade');
        Route::get('/delete-grade/{id}', 'GradeController@DeleteGrade');
        Route::get('/delete-all/grades', 'GradeController@DeleteAll');
        Route::post('/status/grade', 'GradeController@StatusGrade');
        //Units
        Route::get('/units/subject/{subject_id}/grade/{grade_id}', 'UnitController@UnitSubjectGrade');
        Route::post('/add-unit/subject/{subject_id}/grade/{grade_id}', 'UnitController@AddUnitSubjectGrade');
        Route::post('/edit-unit/{unit_id}/subject/{subject_id}/grade/{grade_id}', 'UnitController@EditUnitSubjectGrade');
        Route::get('/delete-unit/{unit_id}/subject/{subject_id}/grade/{grade_id}', 'UnitController@DeleteUnitSubjectGrade');
        Route::get('/delete-all/units', 'UnitController@DeleteAll');
        Route::post('/status/unit', 'UnitController@StatusUnit');
        //Questions
        Route::get('/questions/subject/{subject_id}/grade/{grade_id}/unit/{unit_id}', ['as'=>'admin.questions.subject.grade.unit','uses'=>'QuestionController@Index']);
        Route::match(['get', 'post'], '/add-question/subject/{subject_id}/grade/{grade_id}/unit/{unit_id}', ['as'=>'admin.add-question.subject.grade.unit', 'uses'=>'QuestionController@addQuestion']);
        Route::match(['get', 'post'], '/edit-question/{question_id}/subject/{subject_id}/grade/{grade_id}/unit/{unit_id}',['as'=>'admin.edit-question.subject.grade.unit', 'uses'=>'QuestionController@editQuestion']);
        Route::get('/delete-all/questions', 'QuestionController@DeleteAll');
        Route::post('/status/question', 'QuestionController@StatusQuestion');
        Route::match(['get', 'post'], '/import-file-question/subject/{subject_id}/grade/{grade_id}/unit/{unit_id}', 'QuestionController@ImportFileQuestion');
        Route::get('/export-file-question/subject/{subject_id}/grade/{grade_id}/unit/{unit_id}', 'QuestionController@getQuestions');
        Route::get('/export-file-question/subject/{subject_id}/grade/{grade_id}/unit/{unit_id}', 'QuestionController@ExportFileQuestion');
        //Choose Question Exam
        Route::get('/questions/subject/{subject_id}/grade/{grade_id}/unit/{unit_id}/exam/{exam_id}', 'ChooseQuestionExamController@Index');
        Route::get('/units/subject/{subject_id}/grade/{grade_id}/exam/{exam_id}', 'ChooseQuestionExamController@UnitSubjectGradeExam');
        Route::get('/edit-question/{question_id}/subject/{subject_id}/grade/{grade_id}/unit/{unit_id}/exam/{exam_id}', 'ChooseQuestionExamController@editQuestion');
        //Choose Question
        Route::post('/choose-question','ChooseQuestionExamController@chooseQuestion');
        //Answers
        Route::get('view-answer/question/{question_id}', 'AnswerController@viewAnswer');
        Route::post('add-answer/question/{question_id}', 'AnswerController@addAnswer');
        Route::post('edit-answer/{answer_id}/question/{question_id}', ['as'=>'admin.edit-answer.question', 'uses'=>'AnswerController@editAnswer']);
        // Route::post('/upload-image-ckeditor', 'CkeditorController@uploadImage');
        //Result
        Route::get('/result/exam/class', 'ResultController@Index');
        Route::get('/result/student/exam/{exam_id}/class/{class_id}', 'ResultController@ResultStudentExam');
        Route::get('/result/exam/class/{class_id}', 'ResultController@ResultExamClass');
        Route::get('/see/student/exam/{exam_id}/class/{class_id}', 'ResultController@SeeStudentExam');
        Route::get('/export-file-result-briefly', 'ResultController@ExportFileResultBriefly');
        Route::get('/export-file-result-full', 'ResultController@ExportFileResultFull');
    });
});
Route::namespace('Frontend')->group(function(){
    Route::match(['get', 'post'], '/', 'StudentController@Login');

    Route::group(['middleware'=>'student'], function(){
        Route::match(['get', 'post'], '/dashboard', 'StudentController@Index');
        Route::get('/logout', 'StudentController@Logout');
        Route::match(['get', 'post'], '/change-detail', 'StudentController@ChangeDetail');
        //Exam
        Route::match(['get', 'post'], 'exam/subject/{subject_id}/grade/{grade_id}',['as'=>'exam.subject.grade', 'uses'=>'SubjectController@Index']);
        Route::post('/check-password-exam', 'SubjectController@checkPasswordExam');
        //Question
            Route::match(['get', 'post'],'exam/{exam_id}/subject/{subject_id}/grade/{grade_id}/{code}', ['as'=>'pratice-exam.subject.grade', 'uses'=>'QuestionController@Index']);
            // Route::post('/check/exam/{exam_id}', 'QuestionController@CheckExam');
            Route::post('/check-result-answer', 'QuestionController@CheckResultAnswer');
            Route::match(['get', 'post'], '/result/exam/{exam_id}/subject/{subject_id}', 'QuestionController@ResultExam');
            // Route::get('/visit-to-question', 'QuestionController@VisitToQuestion');
            // Route::post('/visit-to-exam', 'QuestionController@VisitExam');
            Route::get('/exam-list-question/{exam_id}/subject/{subject_id}/grade/{grade_id}/{code}', 'QuestionController@ExamListQuestion');

        // Route::get('/result/exam/{exam_id}', 'ResultController@Index');
    });
});

