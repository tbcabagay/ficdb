<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * NoticeForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class NoticeForm extends Model
{
    public $course_id;
    public $template_id;
    public $reference_number;
    public $semester;
    public $academic_year;
    public $date_course_start;
    public $date_final_exam;
    public $date_submission;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['course_id', 'template_id', 'reference_number', 'semester', 'academic_year', 'date_course_start', 'date_final_exam', 'date_submission', 'created_at', 'updated_at'], 'required'],
            [['course_id', 'template_id'], 'integer'],
            [['date_course_start', 'date_final_exam', 'date_submission'], 'safe'],
            [['reference_number'], 'string', 'max' => 7],
            [['semester'], 'string', 'max' => 1],
            [['academic_year'], 'string', 'max' => 9],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'course_id' => Yii::t('app', 'Course'),
            'template_id' => Yii::t('app', 'Template'),
            'reference_number' => Yii::t('app', 'Reference Number'),
            'semester' => Yii::t('app', 'Semester'),
            'academic_year' => Yii::t('app', 'Academic Year'),
            'date_course_start' => Yii::t('app', 'Date Course Start'),
            'date_final_exam' => Yii::t('app', 'Date Final Exam'),
            'date_submission' => Yii::t('app', 'Date Submission'),
        ];
    }
}
