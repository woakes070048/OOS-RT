<?php
/**
 * Recruitments (recruitments)
 * @var $this AdminController
 * @var $model Recruitments
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 1 March 2016, 13:52 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$cs = Yii::app()->getClientScript();
$js=<<<EOP
	$('#Recruitments_permanent').live('change', function() {
		var id = $(this).prop('checked');		
		if(id == true) {
			$('div#finish-date').slideUp();
		} else {
			$('div#finish-date').slideDown();
		}
	});
EOP;
	$cs->registerScript('finish', $js, CClientScript::POS_END);
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'id'=>'recruitments-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
	),
)); ?>

<?php //begin.Messages ?>
<div id="ajax-message">
	<?php //echo $form->errorSummary($model); ?>
</div>
<?php //begin.Messages ?>

<fieldset>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'event_type'); ?>
		<div class="desc">
			<?php echo $form->dropDownList($model,'event_type', array(
				0=>'Direct',
				1=>'Bundle',
			)); ?>
			<?php echo $form->error($model,'event_type'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'event_name'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'event_name',array('maxlength'=>32,'class'=>'span-7')); ?>
			<?php echo $form->error($model,'event_name'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'event_desc'); ?>
		<div class="desc">
			<?php echo $form->textArea($model,'event_desc',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'event_desc'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'event_logo'); ?>
		<div class="desc">
			<?php echo $form->fileField($model,'event_logo'); ?>
			<?php echo $form->error($model,'event_logo'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'start_date'); ?>
		<div class="desc">
			<?php
			!$model->isNewRecord ? ($model->start_date != '0000-00-00' ? $model->start_date = date('d-m-Y', strtotime($model->start_date)) : '') : '';
			//echo $form->textField($model,'start_date');
			$this->widget('zii.widgets.jui.CJuiDatePicker',array(
				'model'=>$model,
				'attribute'=>'start_date',
				//'mode'=>'datetime',
				'options'=>array(
					'dateFormat' => 'dd-mm-yy',
				),
				'htmlOptions'=>array(
					'class' => 'span-4',
				 ),
			)); ?>
			<?php echo $form->error($model,'start_date'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<?php 
	$model->permanent = 0;
	if($model->isNewRecord || (!$model->isNewRecord && in_array(date('Y-m-d', strtotime($model->finish_date)), array('0000-00-00','1970-01-01'))))
		$model->permanent = 1;
	?>
	
	<div class="clearfix">
		<?php echo $form->labelEx($model,'permanent'); ?>
		<div class="desc">
			<?php echo $form->checkBox($model,'permanent'); ?>
			<?php echo $form->error($model,'permanent'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div id="finish-date" class="clearfix <?php echo $model->permanent == 1 ? 'hide' : ''?>">
		<?php echo $form->labelEx($model,'finish_date'); ?>
		<div class="desc">
			<?php
			!$model->isNewRecord ? (!in_array(date('Y-m-d', strtotime($model->finish_date)), array('0000-00-00','1970-01-01')) ? $model->finish_date = date('d-m-Y', strtotime($model->finish_date)) : '') : '';
			//echo $form->textField($model,'finish_date');
			$this->widget('zii.widgets.jui.CJuiDatePicker',array(
				'model'=>$model,
				'attribute'=>'finish_date',
				//'mode'=>'datetime',
				'options'=>array(
					'dateFormat' => 'dd-mm-yy',
				),
				'htmlOptions'=>array(
					'class' => 'span-4',
				 ),
			)); ?>
			<?php echo $form->error($model,'finish_date'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'publish'); ?>
		<div class="desc">
			<?php echo $form->checkBox($model,'publish'); ?>
			<?php echo $form->error($model,'publish'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="submit clearfix">
		<label>&nbsp;</label>
		<div class="desc">
			<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save'), array('onclick' => 'setEnableSave()')); ?>
		</div>
	</div>
	
</fieldset>
<?php $this->endWidget(); ?>