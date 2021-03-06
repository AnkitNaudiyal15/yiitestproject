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
use app\models\UserForm;
use app\models\DaakForm;
use app\models\Daak;
use app\models\Comment;
use yii\web\UploadedFile;
use yii\data\ArrayDataProvider;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;


class SiteController extends Controller
{
    public $uploadDocument;
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
        if(Yii::$app->user->isGuest) {
			return $this->render('index');
		} else {
            return $this->redirect(array('site/daaklist'));
        }
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
        $rolesData['clerk'] = 'Clerk';
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
     * Displays create users page.
     *
     * @return string
     */
    public function actionUsers()
    {
        $this->roleManagement(['admin']);
        $model = new UserForm();
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

    /**
     * Displays create daak page.
     *
     * @return string
     */
    public function actionDaak()
    { 
        $this->roleManagement(['clerk']);
        $loginUser =Yii::$app->user->id;
        $daak = new DaakForm();

        if ($daak->load(Yii::$app->request->post()) && $daak->createDaak()) {
                $daak->file = UploadedFile::getInstance($daak,'file');
                $path = 'uploads/' . date('Y-m-d h:i:s') . '.pdf';          
                $daak->file->saveAs($path);
                $daakFinalData =new Daak();
                $daakFinalData->subject = $daak->subject;
                $daakFinalData->content = $daak->content;
                $daakFinalData->department_type = $daak->department;
                $daakFinalData->user_type = $daak->role;
                $daakFinalData->file = $path;
                $daakFinalData->created_by = Yii::$app->user->id;
                $daakFinalData->approve_by = '';
                $daakFinalData->status = $daak->status;
                $daakFinalData->created_at = date('Y-m-d h:i:s');
                $daakFinalData->updated_at = date('Y-m-d h:i:s');
                $daakFinalData->save();

            return $this->goBack();
        }

        $departments = Department::find()->where(['<>','department','Administration'])->indexBy('id')->all();
        $roles = Role::find()->where(['<>','role','Admin'])->indexBy('id')->all();
        $status[0] = Status::findOne(['status_type'=>'pending']);
        return $this->render('daak', [
            'model'=> $daak,
            'roles' => $roles,
            'departments' => $departments,
            'status' => $status
        ]);
    }


    /**
     * Displays daak page.
     *
     * @return string
     */
    public function actionDaaklist()
    {
        $dataProvider = new ActiveDataProvider([
        'query' => Daak::find()->with('department','role','state'),
        'pagination' => [
        'pageSize' => 10,
        ],]);

        $users =User::find()->all(); 
        return $this->render('daaklist', [
        'data' => $dataProvider,
        'users'=> $users,
        ]);
    }


    /**
     * Displays daak page.
     *
     * @return string
     */
    public function actionStatus()
    {


        $model = new Daak();
        if ($model->load(Yii::$app->request->post()) && $model->changeStatus()) {
            $daak = Daak::findOne(Yii::$app->request->post()['Daak']['daakId']);
            $daakId = Yii::$app->request->post()['Daak']['daakId'];
            $daakStatus = Yii::$app->request->post()['Daak']['status'];
            $daak->updateAll(array('status' => $daakStatus),"id= $daakId");
            return $this->goBack();
        }

        $daak= Daak::findOne(yii::$app->request->get('id'));
        $status = Status::find()->where(['<>','status_type','pending'])->all();
        return $this->render('statuschange.php', [
        'data' => $daak,
        'status' => $status,
        'selectedStatus' =>$daak->getAttribute('status')
        ]);
    }

      /**
     * Displays daak page.
     *
     * @return string
     */
    public function actionComment()
    {

        $model = new Comment();
      
        if ($model->load(Yii::$app->request->post()) && $model->comments()) {

            $postData = Yii::$app->request->post('Comment');
        
            $model->message = $postData['message'];
            $model->daak = $postData['daak'];
            $model->message_by = $postData['messageBy'];
            $model->created_at = date('Y-m-d h:i:s');
            $model->save();
        }


        $dataProvider = new ActiveDataProvider([
        'query' => Comment::find()->with('commenter'),
        'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]],
        'pagination' => [
        'pageSize' => 10,
        ],]);
        
        $daakId = Yii::$app->request->get('id');
        $daak = Daak::findOne($daakId);
        
        $comment = new Comment();

        return $this->render('commentlist', [
        'data' => $dataProvider,
        'model' =>  $comment,
        'daak' =>  $daak,
        'login' => Yii::$app->user->id
        ]);
    }
    
    /** checking user are access to view page content or not */
    public function roleManagement($roles){

        $userRole = Yii::$app->user->identity->getAttribute('user_type');
        $role = Role::findOne($userRole)->getAttribute('role_alias');
        if(!in_array($role,$roles )){
            return $this->redirect(array('site/daaklist'));
        }
    }
}
