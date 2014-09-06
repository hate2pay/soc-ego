<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'user-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
));
?>

<div class="row">
    <div class="span6">

        <?php
            if(isset($message) and !empty($message))
            {
                echo $message,"<br />";
            }
            else
            {
                echo CHtml::dropDownList('installBadgemanager',array(),
                    array('0' => 'No','1' => 'Yes'));
                echo CHtml::submitButton(Yum::t('Install'));
            }
        ?>
</div>
</div>

<?php $this->endWidget(); ?>

