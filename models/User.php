<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $auth_key
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $last_login
 *
 * @property Auth[] $auths
 * @property Notice[] $notices
 * @property Template[] $templates
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const STATUS_NEW = 5;
    const STATUS_ACTIVE = 10;

    public $role;

    private static $_roles = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auth_key', 'email', 'last_login', 'role'], 'required'],
            [['status', 'created_at', 'updated_at', 'last_login'], 'integer'],
            [['auth_key', 'email'], 'string', 'max' => 255],
            ['email', 'email'],
            ['email', 'unique'],
            ['email', 'validateDomain'],
            ['status', 'default', 'value' => self::STATUS_NEW],
            ['role', 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'last_login' => Yii::t('app', 'Last Login'),
            'role' => Yii::t('app', 'Role'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuths()
    {
        return $this->hasMany(Auth::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotices()
    {
        return $this->hasMany(Notice::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplates()
    {
        return $this->hasMany(Template::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne([
            'access_token' => $token,
            'status' => self::STATUS_NEW,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function generateAuthKey()
    {
        $this->setAttribute('auth_key', \Yii::$app->security->generateRandomString());
    }

    public function generateLastLogin($insert = false)
    {
        if ($insert) {
            $this->setAttribute('last_login', 0);
        } else {
            $this->setAttribute('last_login', time());
        }
    }

    public function setStatus($status)
    {
        $this->setAttribute('status', $status);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
            ],
        ];
    }

    public function afterFind()
    {
        $roleByUser = Yii::$app->authManager->getRolesByUser($this->getId());
        $this->role = key($roleByUser);
    }

    public function signup()
    {
        $this->generateAuthKey();
        $this->generateLastLogin(true);

        if ($this->save()) {
            $this->refresh();

            $auth = Yii::$app->authManager;
            $role = $auth->getRole($this->role);
            $auth->assign($role, $this->getId());

            return true;
        }
        return false;
    }

    public function updateProfile()
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($this->role);
        $auth->assign($role, $this->getId());

        return $this->save();
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

    public function getStatusValue($status)
    {
        if ($status === self::STATUS_NEW) {
            return 'STATUS_NEW';
        } else if ($status === self::STATUS_ACTIVE) {
            return 'STATUS_ACTIVE';
        }
    }

    public static function getRoleList()
    {
        static::$_roles = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name');
        return static::$_roles;
    }
}
