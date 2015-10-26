<?php

namespace app\models;

use Yii;

//Para utenticación
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;
//------------


/**
 * This is the model class for table "usuarios".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $apellido1
 * @property string $telefono
 * @property string $movil
 * @property string $email
 * @property string $codpostal
 * @property integer $municipios_id
 * @property string $password
 * @property string $username
 * @property string $token
 * @property string $apellido2
 * @property string $dni
 * @property string $direccion
 * @property integer $persona_fisica
 * @property string $fecha_nacimiento
 * @property string $genero
 *
 * @property Municipios $municipios
 * @property UsuariosLicencias[] $usuariosLicencias
 * @property UsuariosLicencias[] $usuariosLicencias0
 * @property Licencias[] $licencias
 */
class Usuarios extends \yii\db\ActiveRecord  implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['municipios_id', 'username', 'persona_fisica', 'genero'], 'required'],
            [['municipios_id', 'persona_fisica'], 'integer'],
            [['fecha_nacimiento'], 'safe'],
            [['nombre', 'apellido1', 'username', 'apellido2'], 'string', 'max' => 45],
            [['telefono', 'movil', 'dni'], 'string', 'max' => 15],
            [['email', 'token'], 'string', 'max' => 50],
            [['codpostal'], 'string', 'max' => 5],
            [['password'], 'string', 'max' => 150],
            [['direccion'], 'string', 'max' => 60],
            [['genero'], 'string', 'max' => 1]
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
            'apellido1' => 'Apellido1',
            'telefono' => 'Telefono',
            'movil' => 'Movil',
            'email' => 'Email',
            'codpostal' => 'Codpostal',
            'municipios_id' => 'Municipios ID',
            'password' => 'Password',
            'username' => 'Username',
            'token' => 'Token',
            'apellido2' => 'Apellido2',
            'dni' => 'Dni',
            'direccion' => 'Direccion',
            'persona_fisica' => 'Persona Fisica',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'genero' => 'Genero',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipios()
    {
        return $this->hasOne(Municipios::className(), ['id' => 'municipios_id']);
    }

    /**
      * @return \yii\db\ActiveQuery
      */
    public function getUsuariosLicencias()
    {
        return $this->hasMany(UsuariosLicencias::className(), ['usuarios_padre_id' => 'id']);
    }
   
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsuariosLicencias0()
    {
       return $this->hasMany(UsuariosLicencias::className(), ['usuarios_id' => 'id']);
    }
   
 
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLicencias()
    {
        return $this->hasMany(Licencias::className(), ['id' => 'licencias_id'])->viaTable('usuarios_licencias', ['usuarios_id' => 'id']);
    }
    
    
       /**
    * @return \yii\db\ActiveQuery
    */
  
    //Autenticación-------------------------------------------------------------
    
    
        /** INCLUDE USER LOGIN VALIDATION FUNCTIONS**/
        /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
/* modified */
    public static function findIdentityByAccessToken($token, $type = null)
    {
          return static::findOne(['access_token' => $token]);
    }
 
/* removed
    public static function findIdentityByAccessToken($token)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
*/
    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param  string      $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === sha1($password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Security::generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Security::generateRandomKey();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Security::generateRandomKey() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    /** EXTENSION MOVIE **/

}
