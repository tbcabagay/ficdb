<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%office}}".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 *
 * @property Program[] $programs
 * @property User[] $users
 */
class Office extends \yii\db\ActiveRecord
{
    private static $_offices = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%office}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['code'], 'string', 'max' => 15],
            [['name'], 'string', 'max' => 200],
            [['code', 'name'], 'trim'],
            ['code', 'filter', 'filter' => 'strtoupper'],
            ['name', 'filter', 'filter' => 'strtolower'],
            ['name', 'filter', 'filter' => 'ucwords'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrograms()
    {
        return $this->hasMany(Program::className(), ['office_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['office_id' => 'id']);
    }

    public static function getOfficeList()
    {
        static::$_offices = ArrayHelper::map(static::find()->asArray()->all(), 'id', 'name');
        return static::$_offices;
    }
}
