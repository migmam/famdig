<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "licencias".
 *
 * @property integer $id
 * @property string $codlicencia
 * @property integer $estado
 *
 * @property LicenciasProductos[] $licenciasProductos
 * @property Productos[] $productos
 * @property UsuariosLicencias[] $usuariosLicencias
 * @property Usuarios[] $usuarios
 */
class Licencias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'licencias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['estado'], 'integer'],
            [['codlicencia'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codlicencia' => 'Codlicencia',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLicenciasProductos()
    {
        return $this->hasMany(LicenciasProductos::className(), ['licencias_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Productos::className(), ['id' => 'productos_id'])->viaTable('licencias_productos', ['licencias_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuariosLicencias()
    {
        return $this->hasMany(UsuariosLicencias::className(), ['licencias_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::className(), ['id' => 'usuarios_id'])->viaTable('usuarios_licencias', ['licencias_id' => 'id']);
    }
}
