<?php
/**
 * Recruitments (recruitments)
 * @var $this SiteController
 * @var $model Recruitments
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 11 March 2016, 10:27 WIB
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Recruitments'=>array('manage'),
		'Manage',
	);
	$this->menu=array(
		array(
			'label' => Yii::t('phrase', 'Filter'), 
			'url' => array('javascript:void(0);'),
			'itemOptions' => array('class' => 'search-button'),
			'linkOptions' => array('title' => Yii::t('phrase', 'Filter')),
		),
		array(
			'label' => Yii::t('phrase', 'Grid Options'), 
			'url' => array('javascript:void(0);'),
			'itemOptions' => array('class' => 'grid-button'),
			'linkOptions' => array('title' => Yii::t('phrase', 'Grid Options')),
		),
	);
?>

<?php $this->widget('application.components.system.OGridView', array(
	'id'=>'recruitments-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'pager' => array('header' => ''),
	'summaryText' => '',
    'columns'=>array(
		array(
			'name' => 'event_name',
			'value' => $data->event_name,
			'type' => 'raw',
		),
    ),
)); ?>