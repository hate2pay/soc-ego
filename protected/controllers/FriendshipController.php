<?php

class FriendshipController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

    public $defaultAction = 'view';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','GetAllUsersByName','GetAllFriendsByName'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','GetAllUsersByName','GetAllFriendsByName'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','GetAllUsersByName','GetAllFriendsByName'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Friendship;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Friendship']))
		{
			$model->attributes=$_POST['Friendship'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Friendship']))
		{
			$model->attributes=$_POST['Friendship'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->layout = '//layouts/main';
        $curruser=Yii::app()->user->getId();
        $current_user = User::model()->findByPk($curruser);
        $friends = $current_user->getFriendsList();
        $allusers=User::model()->findAllUsersWithout(array($curruser));
        $curruserinviter=Friendship::model()->getAllUsersByIdIfInviter($curruser);
        $currusernotinviter=Friendship::model()->getAllUsersByIdIfNotInviter($curruser);
        $friendrequest=array();
        for($i=0;$i<count($currusernotinviter);$i++)
        {
            $friendrequest[]=User::model()->findByPk($currusernotinviter[$i]);
        }
        $sortedfriend=User::model()->sortFullNameByAlph($friends);
        $this->render('index', array('friends'=>$sortedfriend,
                                     'allusers'=>$allusers,
                                     'curruserinviter'=>$curruserinviter,
                                     'currusernotinviter'=>$currusernotinviter,
                                     'allusershtml'=>$this->renderPartial('allusers',array( 'allusers'=>$allusers,
                                                                                            'friends'=>$sortedfriend,
                                                                                            'curruserinviter'=>$curruserinviter,
                                                                                            'currusernotinviter'=>$currusernotinviter),true),

                                     'allfriendshtml'=>$this->renderPartial('allfriends',array('friends'=>$sortedfriend),true),
                                     'friendrequest'=>$friendrequest,
                                     'requestshtml'=>$this->renderPartial('requests',array('friendrequest'=>$friendrequest),true),
                                     'recenthtml'=>$this->renderPartial('recent',array('friends'=>$sortedfriend),true)
                    ));
	}


    /**
     * get all users by name
     */
    public function actionGetAllUsersByName()
    {
        if(Yii::app()->request->isAjaxRequest && isset($_POST) && !empty($_POST))
        {
            if(!empty($_POST) && isset($_POST['q']))
            {
                $searchword=strtolower(trim($_POST['q']));
                $curruser=Yii::app()->user->getId();
                $allwithoutme=User::model()->findAllUsersWithOut(array(Yii::app()->user->getId()));
                $allusersbyname=array();
                $allusersbynameobjects=array();
                $current_user = User::model()->findByPk($curruser);
                $friends = $current_user->getFriendsList();
                $curruserinviter=Friendship::model()->getAllUsersByIdIfInviter($curruser);
                $currusernotinviter=Friendship::model()->getAllUsersByIdIfNotInviter($curruser);
                if(strlen($searchword)>=3)
                {
                    foreach($allwithoutme as $user)
                    {
                        $fullname=strtolower($user->profile->firstname.' '.$user->profile->lastname);
                        if(strpos($fullname,$searchword)===0)
                        {
                            $allusersbyname[]=array('image'=>Profile::model()->getAvatarUrl($user->id),
                                'name'=>$fullname,
                                'jobtitle'=>Profile::model()->jobTitle($user->id));
                            $allusersbynameobjects[]=$user;
                        }
                    }
                }
                else
                {
                    $allusersbynameobjects=$allwithoutme;
                }
                $sortedfriend=User::model()->sortFullNameByAlph($friends);
                echo json_encode(array('allusers'=>$allusersbyname,
                        'allusershtml'=>$this->renderPartial('allusers',array('allusers'=>$allusersbynameobjects,
                                                            'friends'=>$sortedfriend,
                                                            'curruserinviter'=>$curruserinviter,
                                                            'currusernotinviter'=>$currusernotinviter),true)
                ));
            }
        }
    }

    /**
     * get all friends by name
     */
    public function actionGetAllFriendsByName()
    {
        if(Yii::app()->request->isAjaxRequest && isset($_POST) && !empty($_POST))
        {
            if(!empty($_POST) && isset($_POST['q']))
            {
                $searchword=strtolower(trim($_POST['q']));
                $curruser=Yii::app()->user->getId();
                $current_user = User::model()->findByPk($curruser);
                $friends = $current_user->getFriendsList();
                $allusersbynameobjects=array();
                if(strlen($searchword)>=3)
                {
                    foreach($friends as $user)
                    {
                        $fullname=strtolower($user->user->profile->firstname.' '.$user->user->profile->lastname);
                        if(strpos($fullname,$searchword)===0)
                        {
                            $allusersbynameobjects[]=$user;
                        }
                    }
                }
                else
                {
                    $allusersbynameobjects=$friends;
                }
                $sortedfriend=User::model()->sortFullNameByAlph($allusersbynameobjects);
                echo json_encode(array('friends'=>$sortedfriend,
                    'allfriendshtml'=>$this->renderPartial('allfriends',array('friends'=>$sortedfriend),true)
                ));
            }
        }
    }

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Friendship('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Friendship']))
			$model->attributes=$_GET['Friendship'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Friendship the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Friendship::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Friendship $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='friendship-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
