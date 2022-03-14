<?php

namespace app\controllers;

use app\models\Auth;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use yii\bootstrap4\ActiveForm;
use app\models\LoginForm;
use app\models\PasswordForm;
use app\models\UserPasswordResetRequestForm;
use app\models\UserResetPasswordForm;
use app\models\Users;
use app\widgets\Alert;
use yii\base\InvalidParamException;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;

class AuthController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['logout', 'password', 'profile'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['request-password-reset', 'reset-password', 'register'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionIndex()
    {
        $this->layout = 'auth';

        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/informe-rendimento']);
        }

        $model = new LoginForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/informe-rendimento']);
        }

        $model->password = '';
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Sair
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->redirect(['/auth/index']);
    }

    /**
     * Solicitar nova senha
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $this->layout = 'auth';
        $model = new UserPasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->document) {
                $result = Yii::$app->webservice->getWebservice('collaborator', ['numCpf' => $model->document]);

                if (isset($result->TMCSColaboradores)) {
                    if (is_array($result->TMCSColaboradores)){
                        foreach ($result->TMCSColaboradores as $colaborador) {
                            if ($colaborador->sitAfa == 1) {
                                if ($colaborador->datNas == $model->birthDate && 
                                $colaborador->numCad == $model->codUser) {
                                    $user = Auth::findOne(['CD_COLABORADOR' => $model->codUser]);

                                    if ($user) {
                                        $user->DS_SENHA = $model->password;
                                        $user->save();
                                        Yii::$app->session->setFlash('success', 'Senha atualizada com sucesso. Você já pode autenticar com a nova senha!');
                                        return $this->redirect(['/auth']);
                                    } else {
                                        Yii::$app->session->setFlash('warning', 'Colaborador não encontrado no sistema da Intranet');
                                    }
                                } else {
                                    Yii::$app->session->setFlash('error', 'Não foi possível atualizar a sua senha, verifique seus dados e tente novamente!');
                                }
                            }
                        }
                    } elseif ($result->TMCSColaboradores->datNas == $model->birthDate && 
                    $result->TMCSColaboradores->numCad == $model->codUser) {

                        $user = Auth::findOne(['CD_COLABORADOR' => $model->codUser]);

                        if ($user) {
                            $user->DS_SENHA = $model->password;
                            $user->save();
                            Yii::$app->session->setFlash('success', 'Senha atualizada com sucesso. Você já pode autenticar com a nova senha!');
                            return $this->redirect(['/auth']);
                        } else {
                            Yii::$app->session->setFlash('warning', 'Colaborador não encontrado no sistema da Intranet');
                        }                    
                    } else {
                        Yii::$app->session->setFlash('error', 'Não foi possível atualizar a sua senha, verifique seus dados e tente novamente!');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Não foi possível atualizar a sua senha, verifique seus dados e tente novamente!');
                }
            }
        }

        return $this->render('requestPasswordResetToken', ['model' => $model]);
    }

    public function actionRegister()
    {
        $model = new Users();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }    
        
        if ($model->load(Yii::$app->request->post())) {
            $result = Users::find()->select('MAX(CD_USUARIO) AS CD_USUARIO')->one();

            $model->CD_USUARIO = $result->CD_USUARIO + 1;            
            $model->IE_LIXEIRA = 0;
            $model->TP_COLABORADOR = 1;
            $model->CD_EMPRESA = 1;
            $model->CD_COLABORADOR = $model->DS_LOGIN;
            $model->validate();
             
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', '<strong>Seu cadastro foi realizado com sucesso.</strong>'); 
                return $this->redirect(['auth/index']);
            }
        } else {
            return $this->render('register', [
                'model' => $model,
            ]);
        }
    }
}
