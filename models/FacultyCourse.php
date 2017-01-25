<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%faculty_course}}".
 *
 * @property integer $id
 * @property integer $faculty_id
 * @property integer $course_id
 *
 * @property Course $course
 * @property Faculty $faculty
 */
class FacultyCourse extends \yii\db\ActiveRecord
{
    private static $_facultyCourses = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%faculty_course}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id'], 'required'],
            [['faculty_id', 'course_id'], 'integer'],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
            [['faculty_id'], 'exist', 'skipOnError' => true, 'targetClass' => Faculty::className(), 'targetAttribute' => ['faculty_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'faculty_id' => Yii::t('app', 'Faculty ID'),
            'course_id' => Yii::t('app', 'Course ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFaculty()
    {
        return $this->hasOne(Faculty::className(), ['id' => 'faculty_id']);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->setAttribute('faculty_id', Yii::$app->request->get('faculty_id'));
        }
        return parent::beforeSave($insert);
    }

    public static function getFacultyCourseList($faculty_id)
    {
        static::$_facultyCourses = ArrayHelper::map(
            static::find()
                ->where(['faculty_id' => $faculty_id])
                ->all(),
            function($model, $defaultValue) {
                return $model->course->id;
            },
            function($model, $defaultValue) {
                return $model->course->title;
            }
        );
        return static::$_facultyCourses;
    }
}
