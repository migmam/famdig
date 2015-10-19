<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "municipios".
 *
 * @property integer $id
 * @property integer $provincias_id
 * @property integer $cod_municipio
 * @property integer $DC
 * @property string $nombre
 *
 * @property Provincias $provincias
 * @property Usuarios[] $usuarios
 */
class Municipios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'municipios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['provincias_id', 'cod_municipio', 'DC'], 'required'],
            [['provincias_id', 'cod_municipio', 'DC'], 'integer'],
            [['nombre'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'provincias_id' => 'Provincias ID',
            'cod_municipio' => 'Cod Municipio',
            'DC' => 'Dc',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvincias()
    {
        return $this->hasOne(Provincias::className(), ['id' => 'provincias_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::className(), ['municipios_id' => 'id']);
    }
}
