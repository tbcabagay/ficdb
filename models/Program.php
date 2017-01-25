<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%program}}".
 *
 * @property integer $id
 * @property integer $office_id
 * @property string $code
 * @property string $name
 *
 * @property Course[] $courses
 * @property Office $office
 */
class Program extends \yii\db\ActiveRecord
{
    private static $_programs = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%program}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['office_id', 'code', 'name'], 'required'],
            [['office_id'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 150],
            [['code', 'name'], 'trim'],
            ['code', 'filter', 'filter' => 'strtoupper'],
            ['name', 'filter', 'filter' => 'ucwords'],
            ['code', 'unique'],
            [['office_id'], 'exist', 'skipOnError' => true, 'targetClass' => Office::className(), 'targetAttribute' => ['office_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'office_id' => Yii::t('app', 'Office ID'),
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasMany(Course::className(), ['program_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOffice()
    {
        return $this->hasOne(Office::className(), ['id' => 'office_id']);
    }

    public static function getProgramList()
    {
        static::$_programs = ArrayHelper::map(static::find()->asArray()->all(), 'id', 'name');
        return static::$_programs;
    }
}
