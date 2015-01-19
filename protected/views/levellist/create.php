<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'badges-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
));
?>
<fieldset class="badge-add-form">
    <legend>Add new level</legend>
<?php $Levellist=new Levellist(); ?>
<div class="row">
    <div class="span6">
        <div>
        <?php echo $form->labelEx($Levellist, 'position');
        echo $form->textField($Levellist, 'position',array("class"=>"width-80"));
        echo $form->error($Levellist, 'position'); ?>
        </div>
        <div>
        <?php echo $form->labelEx($Levellist, 'description');
        $this->widget('application.extensions.cleditor.ECLEditor', array(
            'model'=>$Levellist,
            'attribute'=>'description',
            'options'=>array(
                'width'=>'600',
                'height'=>250,
                'useCSS'=>true,
                'class'=>'width-80 textarea-min-height'
            ),
            'value'=>$Levellist->description,
        ));
        //echo $form->textArea($Levellist, 'description',array('class'=>'width-80 textarea-min-height'));
        echo $form->error($Levellist, 'description'); ?>
        </div>
        <div>
            <?php echo $form->labelEx($Levellist, 'priority');
            echo $form->textField($Levellist, 'priority');
            echo $form->error($Levellist, 'priority'); ?>
        </div>
    </div>
</div>
</fieldset>
<div class="button-center">
    <?php echo CHtml::submitButton($Levellist->isNewRecord
        ? 'Create'
        : 'Save'); ?>
</div>
<?php $this->endWidget(); ?>

