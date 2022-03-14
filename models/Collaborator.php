<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Collaborator".
 *
 *
 * @property Vehicle[] $vehicles
 */
class Collaborator extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'VW_RHC_COLABORADOR';
    }
}
