<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "servicios_usuarios_licencias_atributos".
 *
 * @property integer $servicios_usuarios_licencias_id
 * @property integer $atributos_id
 * @property string $valor
 *
 * @property ServiciosProductosUsuariosLicencias $serviciosUsuariosLicencias
 * @property Atributos $atributos
 */
class ServiciosUsuariosLicenciasAtributos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'servicios_usuarios_licencias_atributos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['servicios_usuarios_licencias_id', 'atributos_id'], 'required'],
            [['servicios_usuarios_licencias_id', 'atributos_id'], 'integer'],
            [['valor'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'servicios_usuarios_licencias_id' => 'Servicios Usuarios Licencias ID',
            'atributos_id' => 'Atributos ID',
            'valor' => 'Valor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiciosUsuariosLicencias()
    {
        return $this->hasOne(ServiciosProductosUsuariosLicencias::className(), ['id' => 'servicios_usuarios_licencias_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAtributos()
    {
        return $this->hasOne(Atributos::className(), ['id' => 'atributos_id']);
    }
}
