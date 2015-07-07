<?php
if(isset($message)){?>
    <div style="color:red"><?php echo $message;?></div>
<?php }
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'badges-form',
    'action'=>'/store/update',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
));
?>
<fieldset class="badge-add-form">
    <legend>Update store item</legend>
<div class="row">
    <div class="span6">
        <div>
        <?php
            echo $form->hiddenField($store_item, 'id');
        ?>
        <?php echo $form->labelEx($store_item, 'title');
        echo $form->textField($store_item, 'title');
        echo $form->error($store_item, 'title'); ?>
        </div>
        <div>
        <?php echo $form->labelEx($store_item, 'price');
        echo $form->textField($store_item, 'price');
        echo $form->error($store_item, 'price'); ?>
        </div>
        <div>
            <?php

            $this->widget('application.extensions.folderviewer.folderviewer', array(
                'options'=>array(
                    'model'=>$store_item,
                    'attr'=>'image',
                    'direction'=>'store',
                    'ajaxUrl' => '/files/refresh',
                    'ajaxParams' => array('direction' => 'store'),
                ),
                'value'=>$store_item->image,
            ));

            if($store_item->image>0)
            {
                $image_file=Files::model()->findByPk($store_item->image);
                if($image_file)
                {
                    if(file_exists(Yii::app()->basePath."/../files/".$image_file->image))
                    {
                        ?>
                        <img class="image" src='/files/<?php echo $image_file->image; ?>'/>

                    <?php
                    }
                }
            } ?>
        </div>
        <div>
        <?php echo $form->labelEx($store_item, 'description');
        $this->widget('application.extensions.cleditor.ECLEditor', array(
            'model'=>$store_item,
            'attribute'=>'description',
            'options'=>array(
                'width'=>'600',
                'height'=>250,
                'useCSS'=>true,
                'class'=>'width-80 textarea-min-height'
            ),
            'value'=>$store_item->description,
        ));
        //echo $form->textArea($store_item, 'description');
        echo $form->error($store_item, 'description'); ?>
        </div>

        <div>
        <?php echo $form->labelEx($store_item, 'stock');
        echo $form->dropDownList($store_item, 'stock',array("0"=>"In stock","1"=>"No in stock"));
        echo $form->error($store_item, 'stock'); ?>
        </div>

        <div>
        <?php
        echo $form->labelEx($store_item, 'count');
        echo $form->textField($store_item, 'count');
        echo $form->error($store_item, 'count'); ?>
        </div>

        <div>
        <?php echo $form->labelEx($store_item, 'hide');
        echo $form->dropDownList($store_item, 'hide',array("1"=>"Hide","0"=>"Show"));
        echo $form->error($store_item, 'hide'); ?>
        </div>
    </div>


</div>
</fieldset>
<div class="button-center">
<?php echo CHtml::submitButton($store_item->isNewRecord
    ? 'Create'
    : 'Save'); ?>
</div>
<?php $this->endWidget(); ?>

