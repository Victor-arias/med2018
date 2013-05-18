<?php

/**
 * This is the model class for table "ronda".
 *
 * The followings are the available columns in table 'ronda':
 * @property integer $id
 * @property integer $jugador_id
 * @property integer $tiempo
 * @property integer $preguntas
 * @property integer $nivel
 * @property string $fecha
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property PreguntaXRonda[] $preguntaXRondas
 * @property Jugador $jugador
 */
class Ronda extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ronda the static model class
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
		return 'ronda';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('tiempo, preguntas, nivel, puntos, fecha, estado', 'required'),
			//array('tiempo, preguntas, nivel, puntos, estado', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, jugador_id, tiempo, preguntas, nivel, fecha, estado', 'safe', 'on'=>'search'),
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
			'preguntaXRondas' => array(self::HAS_MANY, 'PreguntaXRonda', 'ronda_id'),
			'jugador' => array(self::BELONGS_TO, 'Jugador', 'jugador_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'jugador_id' => 'Jugador',
			'tiempo' => 'Tiempo',
			'preguntas' => 'Preguntas',
			'nivel' => 'Nivel',
			'puntos' => 'Puntos',
			'fecha' => 'Fecha',
			'estado' => 'Estado',
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
		$criteria->compare('jugador_id',$this->jugador_id);
		$criteria->compare('tiempo',$this->tiempo);
		$criteria->compare('preguntas',$this->preguntas);
		$criteria->compare('nivel',$this->nivel);
		$criteria->compare('puntos',$this->puntos);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function iniciarRonda($jugador_id)
	{
		$this->jugador_id = $jugador_id;
		$this->puntos = 0;
		$this->tiempo = 0;
		$this->preguntas = 0;
		$this->nivel = 1;
		$this->fecha = date('Y-m-d H:i:s');
		$this->estado = 1;

		$this->save();

		return $this->getPrimaryKey();

	}

	public function getRondasDia($jugador_id)
	{
		$a = new CDbCriteria;

		$a->addCondition('jugador_id = '. $jugador_id);
		//$a->addCondition('DATE(fecha)='. date('Y-m-d'));
		
		return $this->count($a);

	}
}