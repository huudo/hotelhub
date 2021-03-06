<?php

/**
 * This is the model class for table "gc_special_supplier".
 *
 * The followings are the available columns in table 'gc_special_supplier':
 * @property string $id_supplier
 * @property string $id_service
 * @property string $position
 *
 * The followings are the available model relations:
 * @property Supplier $idSupplier
 * @property Service $idService
 */
class SpecialSupplier extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SpecialSupplier the static model class
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
		return 'gc_special_supplier';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_supplier, id_service', 'required'),
			array('id_supplier, id_service, position', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_supplier, id_service, position', 'safe', 'on'=>'search'),
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
			'supplier' => array(self::BELONGS_TO, 'Supplier', 'id_supplier'),
			'service' => array(self::BELONGS_TO, 'Service', 'id_service'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_supplier' => 'Supplier',
			'id_service' => 'Service',
			'position' => 'Position',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_supplier',$this->id_supplier,true);
		$criteria->compare('id_service',$this->id_service,true);
		$criteria->compare('position',$this->position,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function getSuppliers($id_service = null) {
		$criteria=new CDbCriteria;
		if(isset($id_service)) {
			$criteria->condition = 'id_service = :id_service';
			$criteria->params = array(':id_service'=>$id_serivce);
		}
		$criteria->order = 'position ASC';
		$models = SpecialSupplier::model()->find($criteria);
		return $models;
	}
}