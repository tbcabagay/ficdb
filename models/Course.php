<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%course}}".
 *
 * @property integer $id
 * @property integer $program_id
 * @property string $code
 * @property string $title
 *
 * @property Program $program
 * @property FacultyCourse[] $facultyCourses
 * @property Notice[] $notices
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%course}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['program_id', 'code', 'title'], 'required'],
            [['program_id'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 150],
            ['code', 'filter', 'filter' => 'strtoupper'],
            ['title', 'filter', 'filter' => 'ucwords'],
            [['program_id'], 'exist', 'skipOnError' => true, 'targetClass' => Program::className(), 'targetAttribute' => ['program_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'program_id' => Yii::t('app', 'Program ID'),
            'code' => Yii::t('app', 'Code'),
            'title' => Yii::t('app', 'Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgram()
    {
        return $this->hasOne(Program::className(), ['id' => 'program_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacultyCourses()
    {
        return $this->hasMany(FacultyCourse::className(), ['course_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotices()
    {
        return $this->hasMany(Notice::className(), ['course_id' => 'id']);
    }
}
