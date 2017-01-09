<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%faculty}}".
 *
 * @property integer $id
 * @property integer $designation_id
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $email
 * @property string $birthday
 * @property string $tin_number
 * @property string $nationality
 * @property integer $status
 * @property integer $created_at
 *
 * @property Designation $designation
 * @property FacultyCourse[] $facultyCourses
 * @property FacultyEducation[] $facultyEducations
 * @property Notice[] $notices
 */
class Faculty extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%faculty}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['designation_id', 'first_name', 'last_name', 'middle_name', 'email', 'birthday', 'tin_number', 'nationality'], 'required'],
            [['designation_id', 'status', 'created_at'], 'integer'],
            [['birthday'], 'safe'],
            [['first_name', 'last_name', 'middle_name', 'tin_number'], 'string', 'max' => 50],
            [['email', 'nationality'], 'string', 'max' => 150],
            ['email', 'email'],
            ['email', 'unique'],
            ['email', 'validateDomain'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['first_name', 'last_name', 'middle_name', 'nationality'], 'filter', 'filter' => 'strtolower'],
            [['first_name', 'last_name', 'middle_name', 'nationality'], 'filter', 'filter' => 'ucwords'],
            ['birthday', 'date', 'format' => 'php:Y-m-d'],
            [['designation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Designation::className(), 'targetAttribute' => ['designation_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'designation_id' => Yii::t('app', 'Designation ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'email' => Yii::t('app', 'Email'),
            'birthday' => Yii::t('app', 'Birthday'),
            'tin_number' => Yii::t('app', 'Tin Number'),
            'nationality' => Yii::t('app', 'Nationality'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDesignation()
    {
        return $this->hasOne(Designation::className(), ['id' => 'designation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacultyCourses()
    {
        return $this->hasMany(FacultyCourse::className(), ['faculty_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacultyEducations()
    {
        return $this->hasMany(FacultyEducation::className(), ['faculty_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotices()
    {
        return $this->hasMany(Notice::className(), ['faculty_id' => 'id']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    public function setStatus($status)
    {
        $this->setAttribute('status', $status);
    }

    public function signup()
    {
        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();

        try {
            $user = new User();
            $user->email = $this->email;
            $user->role = 'staff';

            if ($this->save() && $user->signup()) {
                $transaction->commit();
                return true;
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
    }

    public function validateDomain($attribute, $params)
    {
        $email = $this->$attribute;
        list($userName, $userDomain) = explode('@', $email);

        $validDomains = Yii::$app->params['validDomains'];

        if (!in_array($userDomain, $validDomains)) {
            $this->addError($attribute, 'Email domain is not valid.');
        }
    }
}
