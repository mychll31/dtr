<?php

/**
 * This is the model class for table "schedule".
 *
 * The followings are the available columns in table 'schedule':
 * @property integer $id
 * @property string $mon
 * @property string $tue
 * @property string $wed
 * @property string $thur
 * @property string $fri
 * @property string $sat
 * @property string $sun
 */
class Schedule extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Schedule the static model class
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
		return 'schedule';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mon, tue, wed, thur, fri, sat, sun', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, mon, tue, wed, thur, fri, sat, sun', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'mon' => 'Mon',
			'tue' => 'Tue',
			'wed' => 'Wed',
			'thur' => 'Thur',
			'fri' => 'Fri',
			'sat' => 'Sat',
			'sun' => 'Sun',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('mon',$this->mon,true);
		$criteria->compare('tue',$this->tue,true);
		$criteria->compare('wed',$this->wed,true);
		$criteria->compare('thur',$this->thur,true);
		$criteria->compare('fri',$this->fri,true);
		$criteria->compare('sat',$this->sat,true);
		$criteria->compare('sun',$this->sun,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
