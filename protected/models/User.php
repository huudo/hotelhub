<?php
 
/**
 * This is the model class for table "gc_user".
 *
 * The followings are the available columns in table 'gc_user':
 * @property string $id_user
 * @property string $id_group
 * @property string $id_lang
 * @property string $lastname
 * @property string $firstname
 * @property string $email
 * @property string $passwd
 * @property integer $is_guest
 * @property string $note
 * @property string $birthday
 * @property integer $active
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property Address[] $addresses
 * @property Group $idGroup
 */
class User extends CActiveRecord
{
	const ADMIN = 1;
	const SUPPLIER = 2;
	const AGNT = 3;
	const CUSTOMER = 4;
	const GUEST = 5;
	
	private static $_items = null;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'gc_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_group, lastname, firstname, email, passwd', 'required'),
			array('is_guest, active, deleted', 'numerical', 'integerOnly'=>true),
			array('id_group, id_lang', 'length', 'max'=>10),
			array('lastname, firstname, passwd', 'length', 'max'=>32),
			array('email', 'length', 'max'=>128),
			array('note, birthday', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_user, id_group, id_lang, lastname, firstname, email, passwd, is_guest, note, birthday, active, deleted', 'safe', 'on'=>'search'),
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
			'addresses' => array(self::HAS_MANY, 'Address', 'id_user'),
			'group' => array(self::BELONGS_TO, 'Group', 'id_group'),
			'lang' => array(self::BELONGS_TO, 'Lang', 'id_lang'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_user' => 'User Id',
			'id_group' => 'Group',
			'id_lang' => 'Lang',
			'lastname' => 'Lastname',
			'firstname' => 'Firstname',
			'email' => 'Email',
			'passwd' => 'Passwd',
			'is_guest' => 'Is Guest',
			'note' => 'Note',
			'birthday' => 'Birthday',
			'active' => 'Active',
			'deleted' => 'Deleted',
			'addresses' => 'Addresses',
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

		$criteria->compare('id_user',$this->id_user,true);
		$criteria->compare('id_group',$this->id_group,true);
		$criteria->compare('id_lang',$this->id_lang,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('passwd',$this->passwd,true);
		$criteria->compare('is_guest',$this->is_guest);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function isAdmin() {
		return $this->id_group == self::ADMIN;
	}
	
	public function isSupplier() {
		return $this->id_group == self::SUPPLIER;
	}
	
	public function isAgent() {
		return $this->id_group == self::AGNT;
	}
	
	public function isCustomer() {
		return $this->id_group == self::CUSTOMER;
	}
	
	public static function getCurrentGroup() {
		$session=new CHttpSession;
		$session->open();
		
		if(isset($session['group'])) {
			$group = $session['group'];
		} else {
			$group = User::GUEST;
		}
		
		return $group;
	}
	
	public static function items($group = null)
	{
		self::loadItems($group);	
		return self::$_items;
	}
	
	private static function loadItems($group = null)
	{
		self::$_items = array();
		
		if(isset($group)) {
			$models=self::model()->findAll('id_group = :id_group', array(':id_group' => $group));		
		} else {
			$models=self::model()->findAll();
		}
	
		foreach($models as $model) {
			self::$_items[$model->id_user]=$model->email;
		}
	}
}