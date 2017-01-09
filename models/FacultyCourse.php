<?php

namespace app\models;

use Yii;

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
            [['faculty_id', 'course_id'], 'required'],
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
}
