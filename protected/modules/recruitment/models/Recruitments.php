<?php
/**
 * Recruitments
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2016 Ommu Platform (ommu.co)
 * @created date 1 March 2016, 13:47 WIB
 * @link http://company.ommu.co
 * @contact (+62)856-299-4114
 *
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 *
 * --------------------------------------------------------------------------------------
 *
 * This is the model class for table "ommu_recruitments".
 *
 * The followings are the available columns in table 'ommu_recruitments':
 * @property string $recruitment_id
 * @property integer $publish
 * @property string $event_name
 * @property string $event_desc
 * @property integer $event_type
 * @property string $start_date
 * @property string $finish_date
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 *
 * The followings are the available model relations:
 * @property OmmuRecruitmentEventUser[] $ommuRecruitmentEventUsers
 * @property OmmuRecruitmentSessions[] $ommuRecruitmentSessions
 */
class Recruitments extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Recruitments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ommu_recruitments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_name, event_desc, creation_date, creation_id, modified_id', 'required'),
			array('publish, event_type', 'numerical', 'integerOnly'=>true),
			array('event_name', 'length', 'max'=>32),
			array('creation_id, modified_id', 'length', 'max'=>11),
			array('start_date, finish_date, modified_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('recruitment_id, publish, event_name, event_desc, event_type, start_date, finish_date, creation_date, creation_id, modified_date, modified_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'ommuRecruitmentEventUsers_relation' => array(self::HAS_MANY, 'OmmuRecruitmentEventUser', 'recruitment_id'),
			'ommuRecruitmentSessions_relation' => array(self::HAS_MANY, 'OmmuRecruitmentSessions', 'recruitment_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'recruitment_id' => 'Recruitment',
			'publish' => 'Publish',
			'event_name' => 'Event Name',
			'event_desc' => 'Event Desc',
			'event_type' => 'Event Type',
			'start_date' => 'Start Date',
			'finish_date' => 'Finish Date',
			'creation_date' => 'Creation Date',
			'creation_id' => 'Creation',
			'modified_date' => 'Modified Date',
			'modified_id' => 'Modified',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.recruitment_id',strtolower($this->recruitment_id),true);
		if(isset($_GET['type']) && $_GET['type'] == 'publish')
			$criteria->compare('t.publish',1);
		elseif(isset($_GET['type']) && $_GET['type'] == 'unpublish')
			$criteria->compare('t.publish',0);
		elseif(isset($_GET['type']) && $_GET['type'] == 'trash')
			$criteria->compare('t.publish',2);
		else {
			$criteria->addInCondition('t.publish',array(0,1));
			$criteria->compare('t.publish',$this->publish);
		}
		$criteria->compare('t.event_name',strtolower($this->event_name),true);
		$criteria->compare('t.event_desc',strtolower($this->event_desc),true);
		$criteria->compare('t.event_type',$this->event_type);
		if($this->start_date != null && !in_array($this->start_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.start_date)',date('Y-m-d', strtotime($this->start_date)));
		if($this->finish_date != null && !in_array($this->finish_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.finish_date)',date('Y-m-d', strtotime($this->finish_date)));
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.creation_date)',date('Y-m-d', strtotime($this->creation_date)));
		if(isset($_GET['creation']))
			$criteria->compare('t.creation_id',$_GET['creation']);
		else
			$criteria->compare('t.creation_id',$this->creation_id);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.modified_date)',date('Y-m-d', strtotime($this->modified_date)));
		if(isset($_GET['modified']))
			$criteria->compare('t.modified_id',$_GET['modified']);
		else
			$criteria->compare('t.modified_id',$this->modified_id);

		if(!isset($_GET['Recruitments_sort']))
			$criteria->order = 't.recruitment_id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>30,
			),
		));
	}


	/**
	 * Get column for CGrid View
	 */
	public function getGridColumn($columns=null) {
		if($columns !== null) {
			foreach($columns as $val) {
				/*
				if(trim($val) == 'enabled') {
					$this->defaultColumns[] = array(
						'name'  => 'enabled',
						'value' => '$data->enabled == 1? "Ya": "Tidak"',
					);
				}
				*/
				$this->defaultColumns[] = $val;
			}
		} else {
			//$this->defaultColumns[] = 'recruitment_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'event_name';
			$this->defaultColumns[] = 'event_desc';
			$this->defaultColumns[] = 'event_type';
			$this->defaultColumns[] = 'start_date';
			$this->defaultColumns[] = 'finish_date';
			$this->defaultColumns[] = 'creation_date';
			$this->defaultColumns[] = 'creation_id';
			$this->defaultColumns[] = 'modified_date';
			$this->defaultColumns[] = 'modified_id';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->defaultColumns) == 0) {
			/*
			$this->defaultColumns[] = array(
				'class' => 'CCheckBoxColumn',
				'name' => 'id',
				'selectableRows' => 2,
				'checkBoxHtmlOptions' => array('name' => 'trash_id[]')
			);
			*/
			$this->defaultColumns[] = array(
				'header' => 'No',
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
			);
			if(!isset($_GET['type'])) {
				$this->defaultColumns[] = array(
					'name' => 'publish',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("publish",array("id"=>$data->recruitment_id)), $data->publish, 1)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter'=>array(
						1=>Phrase::trans(588,0),
						0=>Phrase::trans(589,0),
					),
					'type' => 'raw',
				);
			}
			$this->defaultColumns[] = 'event_name';
			$this->defaultColumns[] = 'event_desc';
			if(!isset($_GET['type'])) {
				$this->defaultColumns[] = array(
					'name' => 'event_type',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("event_type",array("id"=>$data->recruitment_id)), $data->event_type, 1)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter'=>array(
						1=>Phrase::trans(588,0),
						0=>Phrase::trans(589,0),
					),
					'type' => 'raw',
				);
			}
			$this->defaultColumns[] = array(
				'name' => 'start_date',
				'value' => 'Utility::dateFormat($data->start_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'start_date',
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'start_date_filter',
					),
					'options'=>array(
						'showOn' => 'focus',
						'dateFormat' => 'dd-mm-yy',
						'showOtherMonths' => true,
						'selectOtherMonths' => true,
						'changeMonth' => true,
						'changeYear' => true,
						'showButtonPanel' => true,
					),
				), true),
			);
			$this->defaultColumns[] = array(
				'name' => 'finish_date',
				'value' => 'Utility::dateFormat($data->finish_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'finish_date',
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'finish_date_filter',
					),
					'options'=>array(
						'showOn' => 'focus',
						'dateFormat' => 'dd-mm-yy',
						'showOtherMonths' => true,
						'selectOtherMonths' => true,
						'changeMonth' => true,
						'changeYear' => true,
						'showButtonPanel' => true,
					),
				), true),
			);
			$this->defaultColumns[] = array(
				'name' => 'creation_date',
				'value' => 'Utility::dateFormat($data->creation_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'creation_date',
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'creation_date_filter',
					),
					'options'=>array(
						'showOn' => 'focus',
						'dateFormat' => 'dd-mm-yy',
						'showOtherMonths' => true,
						'selectOtherMonths' => true,
						'changeMonth' => true,
						'changeYear' => true,
						'showButtonPanel' => true,
					),
				), true),
			);
			$this->defaultColumns[] = 'creation_id';
			$this->defaultColumns[] = array(
				'name' => 'modified_date',
				'value' => 'Utility::dateFormat($data->modified_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'modified_date',
					'language' => 'ja',
					'i18nScriptFile' => 'jquery.ui.datepicker-en.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'modified_date_filter',
					),
					'options'=>array(
						'showOn' => 'focus',
						'dateFormat' => 'dd-mm-yy',
						'showOtherMonths' => true,
						'selectOtherMonths' => true,
						'changeMonth' => true,
						'changeYear' => true,
						'showButtonPanel' => true,
					),
				), true),
			);
			$this->defaultColumns[] = 'modified_id';
		}
		parent::afterConstruct();
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column=null)
	{
		if($column != null) {
			$model = self::model()->findByPk($id,array(
				'select' => $column
			));
			return $model->$column;
			
		} else {
			$model = self::model()->findByPk($id);
			return $model;			
		}
	}

	/**
	 * before validate attributes
	 */
	/*
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			// Create action
		}
		return true;
	}
	*/

	/**
	 * after validate attributes
	 */
	/*
	protected function afterValidate()
	{
		parent::afterValidate();
			// Create action
		return true;
	}
	*/
	
	/**
	 * before save attributes
	 */
	/*
	protected function beforeSave() {
		if(parent::beforeSave()) {
			//$this->start_date = date('Y-m-d', strtotime($this->start_date));
			//$this->finish_date = date('Y-m-d', strtotime($this->finish_date));
		}
		return true;	
	}
	*/
	
	/**
	 * After save attributes
	 */
	/*
	protected function afterSave() {
		parent::afterSave();
		// Create action
	}
	*/

	/**
	 * Before delete attributes
	 */
	/*
	protected function beforeDelete() {
		if(parent::beforeDelete()) {
			// Create action
		}
		return true;
	}
	*/

	/**
	 * After delete attributes
	 */
	/*
	protected function afterDelete() {
		parent::afterDelete();
		// Create action
	}
	*/

}