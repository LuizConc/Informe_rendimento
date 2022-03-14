<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Collaborator".
 *
 *
 * @property Vehicle[] $vehicles
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'SEG_USUARIO_HOLERITE';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CD_USUARIO', 'DS_LOGIN', 'NM_USUARIO', 'DS_SENHA'], 'required'],
            [['CD_USUARIO', 'IE_LIXEIRA', 'DS_LOGIN', 'CD_COLABORADOR', 'TP_COLABORADOR', 'CD_EMPRESA'], 'integer'],
            [['NM_USUARIO'], 'string'],
            [['DS_SENHA'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CD_USUARIO' => Yii::t('app', 'Código do Usuário'),
            'DS_LOGIN' => Yii::t('app', 'Numéro da Matrícula'),
            'NM_USUARIO' => Yii::t('app', 'Nome Completo'),
            'DS_SENHA' => Yii::t('app', 'Senha'),
            'IE_LIXEIRA' => Yii::t('app', 'IE Lixeira'),
            'CD_COLABORADOR' => Yii::t('app', 'Matrícula'),
            'TP_COLABORADOR' => Yii::t('app', 'Tipo Colaborador'),
            'CD_EMPRESA' => Yii::t('app', 'Código da Empresa'),
        ];
    }
}
