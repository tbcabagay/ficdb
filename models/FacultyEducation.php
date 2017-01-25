<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%faculty_education}}".
 *
 * @property integer $id
 * @property integer $faculty_id
 * @property string $degree
 * @property string $school
 * @property string $date_graduate
 *
 * @property Faculty $faculty
 */
class FacultyEducation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%faculty_education}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['degree', 'school', 'date_graduate'], 'required'],
            [['faculty_id'], 'integer'],
            [['degree'], 'string', 'max' => 100],
            [['school'], 'string', 'max' => 150],
            [['date_graduate'], 'string', 'max' => 20],
            [['degree', 'school'], 'filter', 'filter' => 'ucwords'],
            ['date_graduate', 'number', 'min' => 1920, 'max' => date('Y'), 'message' => 'Invalid date of graduate.'],
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
            'degree' => Yii::t('app', 'Degree'),
            'school' => Yii::t('app', 'School'),
            'date_graduate' => Yii::t('app', 'Date Graduate'),
        ];
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
}
