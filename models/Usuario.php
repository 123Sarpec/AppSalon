<?php

namespace Model;

class Usuario extends  ActiveRecord
{
    protected static $tabla = 'usuarios';

    protected static $columnasDB = [
        'id',
        'nombre',
        'apellido',
        'email',
        'password',
        'telefono',
        'admin',
        'confirmado',
        'token'
    ];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre']?? '';
        $this->apellido = $args['apellido']?? '';
        $this->email = $args['email']?? '';
        $this->password = $args['password']?? '';
        $this->telefono = $args['telefono']?? '';
        $this->admin = $args['admin']?? "0";
        $this->confirmado = $args['confirmado']?? "0";
        $this->token = $args['token']?? '';
    }

    //mensaje de validacion para crear cuenta


    public function validarNuevaCuenta(){
        if(!$this->nombre){
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->apellido){
            self::$alertas['error'][] = 'El Apellido es Obligatorio';
        
        }
        if(!$this->email){
            self::$alertas['error'][] = 'El Correo es Obligatorio';
        
        }
        if(!$this->password){
            self::$alertas['error'][] = 'La Contraseña es Obligatorio';
        }
        if(!$this->telefono){
            self::$alertas['error'][] = 'El No. Telefono es Obligatorio';
        
        }
        if(strlen($this->password)< 6){
            self::$alertas['error'][] = 'La Contraseña debe tener al menos 6 caracteres';
        }

        return self::$alertas;
}
    public function validarLogin(){
        if(!$this->email){
            self::$alertas['error'][] = 'El Correo es Obligatorio';
        
        }
        if(!$this->password){
            self::$alertas['error'][] = 'La Contraseña es Obligatorio';
        
        }
        return self::$alertas;
    }

    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][] = 'El Correo es Obligatorio';       
        }
        return self::$alertas;
    }

    public function validarpassword(){
        if(!$this->password){
            self::$alertas['error'][] = 'La Contraseña es Obligatorio';
        }
        if(strlen($this->password)< 6){
            self::$alertas['error'][] = 'La Contraseña debe tener al menos 6 caracteres';
        }
        return self::$alertas;
    }

//autenticar si el usurio exite
public function existeUsuario(){
    $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
    $resultado = self::$db->query($query);
    
    if($resultado->num_rows){
        self::$alertas['error'][] = 'El Usuario ya esta registrado';
    }

    return $resultado;    
}

//crear una nueva cuenta
    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    //validar al usuriao 
    public function crearToken(){
        $this->token = uniqid();
    }
    public function comprobarContraseña($password){
        $resultado = password_verify($password, $this->password);
        if(!$resultado || !$this->confirmado){
            self::$alertas['error'][] = 'Contraseña Incorrecta o tu cuenta no ha sido confirmada';
        }else{
            return true;
        }

    }
}