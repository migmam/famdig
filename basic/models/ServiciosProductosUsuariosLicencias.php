<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "servicios_productos_usuarios_licencias".
 *
 * @property integer $id
 * @property integer $usuarios_licencias_usuarios_id
 * @property integer $usuarios_licencias_licencias_id
 * @property integer $productos_servicios_productos_id
 * @property integer $productos_servicios_servicios_id
 *
 * @property UsuariosLicencias $usuariosLicenciasUsuarios
 * @property ProductosServicios $productosServiciosProductos
 * @property ServiciosUsuariosLicenciasAtributos[] $serviciosUsuariosLicenciasAtributos
 * @property Atributos[] $atributos
 */
class ServiciosProductosUsuariosLicencias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'servicios_productos_usuarios_licencias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuarios_licencias_usuarios_id', 'usuarios_licencias_licencias_id', 'productos_servicios_productos_id', 'productos_servicios_servicios_id'], 'required'],
            [['usuarios_licencias_usuarios_id', 'usuarios_licencias_licencias_id', 'productos_servicios_productos_id', 'productos_servicios_servicios_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuarios_licencias_usuarios_id' => 'Usuarios Licencias Usuarios ID',
            'usuarios_licencias_licencias_id' => 'Usuarios Licencias Licencias ID',
            'productos_servicios_productos_id' => 'Productos Servicios Productos ID',
            'productos_servicios_servicios_id' => 'Productos Servicios Servicios ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuariosLicenciasUsuarios()
    {
        return $this->hasOne(UsuariosLicencias::className(), ['usuarios_id' => 'usuarios_licencias_usuarios_id', 'licencias_id' => 'usuarios_licencias_licencias_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductosServiciosProductos()
    {
        return $this->hasOne(ProductosServicios::className(), ['productos_id' => 'productos_servicios_productos_id', 'servicios_id' => 'productos_servicios_servicios_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiciosUsuariosLicenciasAtributos()
    {
        return $this->hasMany(ServiciosUsuariosLicenciasAtributos::className(), ['servicios_usuarios_licencias_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAtributos()
    {
        return $this->hasMany(Atributos::className(), ['id' => 'atributos_id'])->viaTable('servicios_usuarios_licencias_atributos', ['servicios_usuarios_licencias_id' => 'id']);
    }
}
