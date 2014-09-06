<?php
class BadgesController extends Controller
{
    /*badgeusermanager*/
    public function actionbadgeusermanager()
    {
        $this->layout = Yum::module('admin')->adminLayout;
        if(Yii::app()->user->isAdmin())
        {
            if(Yii::app()->request->isPostRequest && isset($_POST['BadgeUser']))
            {
                if(isset($_POST['badgeusersubmit1'])) // add
                {
                    $fid_user=BadgeUser::model()->findByAttributes(array('user_id'=>$_POST['BadgeUser']['user_id'],'badge_id'=>$_POST['BadgeUser']['badge_id']));
                    if($fid_user)
                    {
                        $fid_user->count=$fid_user->count+1;
                        $fid_user->save();
                    }
                    else
                    {
                        $fid_user=new BadgeUser();
                        $fid_user->user_id=$_POST['BadgeUser']['user_id'];
                        $fid_user->badge_id=$_POST['BadgeUser']['badge_id'];
                        $fid_user->count=1;
                        $fid_user->save();
                    }
                }
                elseif(isset($_POST['badgeusersubmit2'])) //remove
                {
                    $fid_user=BadgeUser::model()->findByAttributes(array('user_id'=>$_POST['BadgeUser']['user_id'],'badge_id'=>$_POST['BadgeUser']['badge_id']));
                    if($fid_user && $fid_user->count>0)
                    {
                        $fid_user->count=$fid_user->count-1;
                        $fid_user->save();
                    }
                }
                $this->redirect('index');
            }
            else $this->redirect('index');
        }
        else $this->redirect('/');
    }
	public function actionIndex()
	{
        $this->layout = Yum::module('admin')->adminLayout;
        if(Yii::app()->user->isAdmin())
        {
            if(Yii::app()->db->getSchema()->getTable('badges') && Yii::app()->db->getSchema()->getTable('badge_user'))
                $this->render('index');
            else
                $this->redirect(Yum::module('badgemanager')->installUrl);
        }
        else
		$this->redirect('/');
	}
    /*create*/
    public function actionCreate()
    {
        $this->layout = Yum::module('admin')->adminLayout;
        if(Yii::app()->user->isAdmin())
        {
            if(Yii::app()->request->isPostRequest && isset($_POST['Badges']))
            {
                $badge=new Badges();
                $badge->attributes=$_POST['Badges'];
                if(isset($_FILES['Badges']) && !empty($_FILES['Badges']))
                {
                    $file_ret=Files::model()->create($_FILES['Badges'],$title='test',Badges::model()->tableName());
                    if(is_array($file_ret))
                    {
                        $this->render('create',array('message'=>$file_ret[0]));
                    }
                    else
                    {
                        $badge->image=$file_ret;
                        if($badge->save())
                        {
                            $this->redirect('index');
                        }
                        else
                        {
                            $this->render('create',array('message'=>'badges model not saved! Please ask your specialist'));
                        }
                    }
                }
                else
                {
                    $this->render('create',array('message'=>'please put the image'));
                }
                $this->redirect('index');
            }
            else
                $this->render('create');

        }
        else $this->redirect('/');

    }
    /*update*/
    public function actionUpdate()
    {
        $this->layout = Yum::module('admin')->adminLayout;
        if(Yii::app()->user->isAdmin())
        {
                if(Yii::app()->request->isPostRequest)
                {
                    $local=Badges::model()->findByPk($_POST['Badges']['id']);
                    if($local)
                    {
                        if(isset($_FILES['Badges']) && !empty($_FILES['Badges']))
                        {
                            $file_ret=Files::model()->create($_FILES['Badges'],$title='test',Badges::model()->tableName(),$local->image);
                            if(is_array($file_ret))
                            {
                                $this->render('update'.$_POST['Badges']['id'],array('message'=>$file_ret[0]));
                                exit();
                            }
                            else
                            {
                                $local->image=$file_ret;
                                if($local->save())
                                {
                                    $this->redirect('index');
                                }
                                else
                                {
                                    $this->render('index',array('message'=>'badges model not saved! Please ask your specialist'));
                                }
                            }
                        }
                        else
                        {
                            $this->render('index',array('message'=>'please put the image'));
                        }
                        $local->attributes=$_POST['Badges'];
                        $local->save();
                    }
                    $this->redirect('index');
                }
                else
                if(!empty($_GET['id']) && $_GET['id']>0)
                {
                    $local=Badges::model()->findByPk($_GET['id']);
                    if($local) $this->render('update',array('badges'=>$local));
                    else $this->redirect('index');
                }
            else
            $this->redirect('index');
        }
        else
            $this->redirect('/');
    }
    /*delete*/
    public function actionDelete($id=null)
    {
        $this->layout = Yum::module('admin')->adminLayout;
        if(Yii::app()->user->isAdmin())
        {
            $message='';
            if(!is_null($_GET['id']) && $_GET['id']>0)
            {
                $model=Badges::model()->findByPk($_GET['id']);
                if($model)
                {
                    //find all users who have this badges and deleted
                    $badges_users=BadgeUser::model()->findAllByAttributes(array('badge_id'=>$model->id));
                    if($badges_users)
                    {
                        foreach($badges_users as $bage_user)
                        {
                            $bage_user->delete();
                        }
                    }
                    Files::model()->delete($model->image);
                    //and delete files
                    $model->delete();
                }
            }
            else
                $message='Wrong link';
            $model=Badges::model()->findAll();
            $this->redirect('/badgemanager/badges/index',array('message'=>$message,'model'=>$model));
        }
        else
            $this->redirect('/');

    }
    /*install*/
    public function actionInstall()
    {
        $this->layout = Yum::module('admin')->adminLayout;
        if(Yii::app()->user->isAdmin())
        {

            if(!Yii::app()->db->getSchema()->getTable('badges') && !Yii::app()->db->getSchema()->getTable('badge_user'))
            {
            if ($db = Yii::app()->db) {
                $sql = 'set FOREIGN_KEY_CHECKS = 0;';
                $db->createCommand($sql)->execute();
                $transaction = $db->beginTransaction();
                if(Yii::app()->request->isPostRequest)
                {
                    if (isset($_POST['installBadgemanager']) && $_POST['installBadgemanager']==1) {
                        $sql = "CREATE TABLE IF NOT EXISTS `badges` (
                              `id` int unsigned NOT NULL auto_increment,
                              `title` varchar(512) NOT NULL,
                              `description` text NOT NULL,
                              `image` int(11) NOT NULL,
                              `cost` int(11) NOT NULL,
                              PRIMARY KEY  (`id`)
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
                        $db->createCommand($sql)->execute();

                        /*badge_user*/
                        $sql = "CREATE TABLE IF NOT EXISTS `badge_user` (
                              `id` int unsigned NOT NULL auto_increment,
                              `badge_id` int(11) NOT NULL,
                              `user_id` int(11) NOT NULL,
                              `count` int(11) NOT NULL,
                              PRIMARY KEY  (`id`)
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
                        $db->createCommand($sql)->execute();

                        $this->redirect('index');
                    }
                    else $this->render(Yum::module('badgemanager')->installrenderUrl);
                }
                else
                {
                    if(Yii::app()->db->getSchema()->getTable('badges'))
                        $this->render(Yum::module('badgemanager')->installrenderUrl,array('message'=>'Badge manager table is already installed. Please remove it manually to continue'));
                    else
                        $this->render(Yum::module('badgemanager')->installrenderUrl,array('message'=>''));
                }
            }
            else throw new CException('Yii User management module is not in Debug Mode');

            }
            else
            {
                $this->render(Yum::module('badgemanager')->installUrl,array('message'=>'Some of tables (badges, badge_user) not instaled, remove them'));
            }
        }
        else
            $this->render('/');
    }

}