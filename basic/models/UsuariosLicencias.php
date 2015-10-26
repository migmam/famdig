<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios_licencias".
 *
 * @property integer $usuarios_id
 * @property integer $licencias_id
 * @property integer $usuarios_padre_id
 *
 * @property ServiciosProductosUsuariosLicencias[] $serviciosProductosUsuariosLicencias
 * @property Usuarios $usuariosPadre
 * @property Licencias $licencias
 * @property Usuarios $usuarios
 */
class UsuariosLicencias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuarios_licencias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuarios_id', 'licencias_id'], 'required'],
            [['usuarios_id', 'licencias_id', 'usuarios_padre_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'usuarios_id' => 'Usuarios ID',
            'licencias_id' => 'Licencias ID',
            'usuarios_padre_id' => 'Usuarios Padre ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiciosProductosUsuariosLicencias()
    {
        return $this->hasMany(ServiciosProductosUsuariosLicencias::className(), ['usuarios_licencias_usuarios_id' => 'usuarios_id', 'usuarios_licencias_licencias_id' => 'licencias_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuariosPadre()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuarios_padre_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLicencias()
    {
        return $this->hasOne(Licencias::className(), ['id' => 'licencias_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuarios_id']);
    }
}
