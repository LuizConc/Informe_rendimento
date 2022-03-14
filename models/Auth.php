<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property string $id
 * @property string $code
 * @property string $username
 * @property string $password_hash
 * @property string $auth_key
 * @property string $password_reset_token
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $id_store
 */
class Auth extends ActiveRecord implements IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SEG_USUARIO_HOLERITE';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CD_USUARIO' => 'ID',
            'DS_LOGIN' => 'Login',
            'NM_USUARIO' => 'Nome',
            'DS_EMAIL' => 'Email',
            'DS_SENHA' => 'Senha',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['CD_USUARIO' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $result = static::findOne([
            'DS_LOGIN' => $username,
        ]);
        unset($result->DS_SENHA);

        return static::findOne([
            'DS_LOGIN' => $username,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }


    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $password === $this->DS_SENHA;
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCollaborator()
    {
        return $this->hasOne(Collaborator::class, ['CD_COLABORADOR' => 'cd_colaborador']);
    }
}
