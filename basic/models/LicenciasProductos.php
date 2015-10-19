<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "licencias_productos".
 *
 * @property integer $productos_id
 * @property integer $licencias_id
 *
 * @property Productos $productos
 * @property Licencias $licencias
 */
class LicenciasProductos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'licencias_productos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['productos_id', 'licencias_id'], 'required'],
            [['productos_id', 'licencias_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'productos_id' => 'Productos ID',
            'licencias_id' => 'Licencias ID',
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
    public function getLicencias()
    {
        return $this->hasOne(Licencias::className(), ['id' => 'licencias_id']);
    }
}
