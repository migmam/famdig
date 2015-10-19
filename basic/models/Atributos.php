<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "atributos".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property ServiciosUsuariosLicenciasAtributos[] $serviciosUsuariosLicenciasAtributos
 * @property ServiciosProductosUsuariosLicencias[] $serviciosUsuariosLicencias
 */
class Atributos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'atributos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nombre'], 'required'],
            [['id'], 'integer'],
            [['nombre'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiciosUsuariosLicenciasAtributos()
    {
        return $this->hasMany(ServiciosUsuariosLicenciasAtributos::className(), ['atributos_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiciosUsuariosLicencias()
    {
        return $this->hasMany(ServiciosProductosUsuariosLicencias::className(), ['id' => 'servicios_usuarios_licencias_id'])->viaTable('servicios_usuarios_licencias_atributos', ['atributos_id' => 'id']);
    }
}
