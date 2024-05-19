<?php

/**
 * Clase Empresa
 * 
 * Esta clase representa el modelo de la entidad Empresa en la base de datos.
 * Proporciona métodos para interactuar con la tabla 'empresas'.
 */
class Empresa extends Model {

    /**
     * Constructor de la clase Empresa.
     * Llama al constructor de la clase padre (Model).
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * Obtiene una empresa por su dirección de correo electrónico.
     * 
     * @param string $email La dirección de correo electrónico de la empresa.
     * @return mixed La empresa encontrada o null si no se encuentra ninguna empresa con el correo electrónico especificado.
     */
    public function getEmpresaByEmail($email) {
        $this->db->query('SELECT * FROM empresas WHERE email = :email');
        $this->db->bind(':email', $email);
        return $this->db->single();
    }
    
    /**
     * Comprueba si existe una empresa con la dirección de correo electrónico especificada.
     * 
     * @param string $email La dirección de correo electrónico a comprobar.
     * @return bool Devuelve true si existe una empresa con el correo electrónico especificado, de lo contrario devuelve false.
     */
    private function emailExists($email){
        $this->db->query('SELECT * FROM empresas WHERE email = :email');
        $this->db->bind(':email', $email);
        $existeEmail = $this->db->single();
        return $existeEmail !== false;
    }

    /**
     * Comprueba si existe una empresa con el nombre especificado.
     * 
     * @param string $nombre_empresa El nombre de la empresa a comprobar.
     * @return bool Devuelve true si existe una empresa con el nombre especificado, de lo contrario devuelve false.
     */
    private function userExists($nombre_empresa){
        $this->db->query('SELECT * FROM empresas WHERE nombre_empresa = :nombre_empresa');
        $this->db->bind(':nombre_empresa', $nombre_empresa);
        $existeUsuario = $this->db->single();
        return $existeUsuario !== false;
    }

    /**
     * Inserta un nuevo usuario en la tabla 'empresas'.
     * 
     * @param array $data Los datos del usuario a insertar.
     * @return string El resultado de la operación de inserción. Puede ser 'usuario_registrado' si se insertó correctamente, o 'error_registro' si ocurrió un error.
     */
    private function insertUser($data){
        $this->db->query('INSERT INTO empresas (nombre_empresa, email, password, rol_id )
                        VALUES(:nombre_empresa, :email, :password, :rol_id)');
        $this->db->bind(':nombre_empresa', $data['nombre_empresa']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':rol_id', $data['rol_id']);
        if($this->db->execute()){
            return 'usuario_registrado';
        } else {
            return 'error_registro';
        }
    }

    /**
     * Registra un nuevo usuario en la tabla 'empresas'.
     * 
     * @param array $data Los datos del usuario a registrar.
     * @return string El resultado del registro. Puede ser 'Email no válido' si el formato del correo electrónico no es válido, 'email_existe' si ya existe una empresa con el correo electrónico especificado, 'usuario_existe' si ya existe una empresa con el nombre especificado, o el resultado de la inserción si se registró correctamente.
     */
    public function register($data){
        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            return "Email no válido";
        }

        if($this->emailExists($data['email'])){
            return 'email_existe';
        }

        if($this->userExists($data['nombre_empresa'])){
            return 'usuario_existe';
        }

        $data['password'] = $this->hashPassword($data['password']);
        $this->setRol(2);
        $data['rol_id'] = $this->rol;

        return $this->insertUser($data);
    }
}

?>