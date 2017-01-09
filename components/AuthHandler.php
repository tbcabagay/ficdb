<?php
namespace app\components;

use app\models\Auth;
use app\models\User;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;

class AuthHandler
{
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        $attributes = $this->client->getUserAttributes();

        $email = ArrayHelper::getValue(ArrayHelper::getValue(ArrayHelper::getValue($attributes, 'emails'), 0), 'value');
        $id = ArrayHelper::getValue($attributes, 'id');

        if (Yii::$app->user->isGuest) {
            $user = User::find()->where(['email' => $email])->one();
            if (!is_null($user)) {
                $auth = Auth::find()->where([
                    'source' => $this->client->getId(),
                    'source_id' => $id,
                ])->exists();

                if (!$auth) {
                    $auth = new Auth([
                        'user_id' => $user->id,
                        'source' => $this->client->getId(),
                        'source_id' => (string)$id,
                    ]);
                    $auth->save();
                }

                $user->setStatus(User::STATUS_ACTIVE);
                $user->generateLastLogin();
                $user->save();

                Yii::$app->user->login($user);
            } else {
                Yii::$app->getSession()->setFlash('error', 'Email does not exist.');
            }
        }
    }

}