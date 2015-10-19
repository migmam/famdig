<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "productos_servicios".
 *
 * @property integer $productos_id
 * @property integer $servicios_id
 *
 * @property Productos $productos
 * @property Servicios $servicios
 * @property ServiciosProductosUsuariosLicencias[] $serviciosProductosUsuariosLicencias
 */
class ProductosServicios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'productos_servicios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['productos_id', 'servicios_id'], 'required'],
            [['productos_id', 'servicios_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'productos_id' => 'Productos ID',
            'servicios_id' => 'Servicios ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasOne(Productos::className(), ['id' => 'productos_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicios()
    {
        return $this->hasOne(Servicios::className(), ['id' => 'servicios_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiciosProductosUsuariosLicencias()
    {
        return $this->hasMany(ServiciosProductosUsuariosLicencias::className(), ['productos_servicios_productos_id' => 'productos_id', 'productos_servicios_servicios_id' => 'servicios_id']);
    }
}
