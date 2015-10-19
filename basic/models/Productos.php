<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "productos".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property LicenciasProductos[] $licenciasProductos
 * @property Licencias[] $licencias
 * @property ProductosServicios[] $productosServicios
 * @property Servicios[] $servicios
 * @property ProvisionLicencias[] $provisionLicencias
 */
class Productos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'productos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
    public function getLicenciasProductos()
    {
        return $this->hasMany(LicenciasProductos::className(), ['productos_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLicencias()
    {
        return $this->hasMany(Licencias::className(), ['id' => 'licencias_id'])->viaTable('licencias_productos', ['productos_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductosServicios()
    {
        return $this->hasMany(ProductosServicios::className(), ['productos_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicios()
    {
        return $this->hasMany(Servicios::className(), ['id' => 'servicios_id'])->viaTable('productos_servicios', ['productos_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvisionLicencias()
    {
        return $this->hasMany(ProvisionLicencias::className(), ['productos_id' => 'id']);
    }
}
