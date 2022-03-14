<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Password reset request form
 */
class UserPasswordResetRequestForm extends Model
{

    public $codUser;
    public $birthDate;
    public $document;
    public $password;
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [            
            [['codUser', 'birthDate', 'document', 'password', 'password_repeat'], 'filter', 'filter' => 'trim'],
            [['codUser', 'birthDate', 'document', 'password', 'password_repeat'], 'required'],
            [['codUser', 'birthDate', 'document'], 'string'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false, 'message' => "Senha não confere!"]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'codUser' => 'Matrícula',
            'birthDate' => 'Data de Nascimento',
            'document' => 'CPF',
            'password' => 'Nova Senha',
            'password_repeat' => 'Repita Nova Senha'
        ];
    }

    public function validateData() {
        $user = Collaborator::findOne(['CD_USUARIO' => $this->codUser, '']);

        

    }
}
