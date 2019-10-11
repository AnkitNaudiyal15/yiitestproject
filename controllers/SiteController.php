<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Department;
use app\models\Status;
use app\models\Role;
use app\models\User;
use app\models\userForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        /** default department entry for testing  */

        $departmentsData = ['Administration','Pollution','Water','Electricity'];
        foreach($departmentsData as $departmentData){
            
            $data = Department::findOne(["department" =>$departmentData]);
                
                if(count($data)==0){
                    $department = new Department;
                    $department->department = $departmentData;
                    $department->created_at = date('Y-m-d h:i:s');
                    $department->updated_at = date('Y-m-d h:i:s');
                    $department->save();  
                } 
            
        }

        /** default Role entry for testing  */

        $rolesData['admin'] = 'Admin';
        $rolesData['cleark'] = 'Clerk';
        $rolesData['AD'] = 'Additional Director';
        $rolesData['director'] = 'Director';
        $rolesData['manager'] = 'Manager';
        
        foreach($rolesData as $roles_alias => $roles){
                
            $data = Role::findOne(["role" =>$roles]);
    
                if(count($data)==0){
                    $role = new Role;
                    $role->role = $roles;
                    $role->role_alias = $roles_alias;
                    $role->created_at = date('Y-m-d h:i:s');
                    $role->updated_at = date('Y-m-d h:i:s');
                    $role->save(false);  
                } 
            
        }


          /** default status entry for testing  */

        $statusData = ['Accept','Reject','Pending'];

        foreach($statusData as $childData){

            $data = Status::findOne(["status_type" =>$childData]);

                if(count($data)==0){
                    $status = new Status;
                    $status->status_type = $childData;
                    $status->created_at = date('Y-m-d h:i:s');
                    $status->updated_at = date('Y-m-d h:i:s');
                    $status->save();  
                } 
            
        }



          /** default user entry for testing  */
              $userType= Role::findOne(['role'=>'Admin']);
              $departmentType= Department::findOne(['department'=>'Administration']);
              $data = User::findOne(['username' =>'admin']);

              if(count($data)==0){
                      $user = new User;
                      $user->username = 'admin';
                      $user->password = 'admin@123$';
                      $user->user_email = 'test@gmail.com';
                      $user->user_type = $userType->id;
                      $user->user_department = $departmentType->id;
                      $user->authKey = 'sdsd'.rand(1,1000);
                      $user->accessToken = 'sdsdwwdd'.rand(1,1000);
                      $user->created_at = date('Y-m-d h:i:s');
                      $user->updated_at = date('Y-m-d h:i:s');
                      $user->save(false);  
                  } 

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $departments = Department::find()->indexBy('id')->all();
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
            'departments' => $departments,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays users page.
     *
     * @return string
     */
    public function actionUsers()
    {
        $model = new userForm();
        if ($model->load(Yii::$app->request->post()) && $model->createUser()) {
           return $this->goBack();
        }

        $departments = Department::find()->indexBy('id')->all();
        $roles = Role::find()->indexBy('id')->all();
    
        return $this->render('users', [
            'model'=>$model,
            'roles' => $roles,
            'departments' => $departments,
        ]);
    }
}
