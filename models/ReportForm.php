<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ReportForm extends Model
{
    public $year;
    public $validity;
    public $type;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // year are required
            [['year', 'type'], 'required'],
            [['validity'], 'required']           
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'year' => 'Selecione o ano:',
            'validity' => 'Vigência',
            'type' => 'Tipo de Cálculo',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setReplyTo([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();

            return true;
        }
        return false;
    }
}
