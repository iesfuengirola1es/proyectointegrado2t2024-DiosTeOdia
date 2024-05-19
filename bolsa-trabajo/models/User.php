<?php 

/**
 * Clase User
 * 
 * Esta clase representa un usuario en el sistema.
 * Extiende la clase Model.
 */
class User extends Model {

    /**
     * Constructor de la clase User.
     * Llama al constructor de la clase padre.
     */
    public function __construct(){
        parent::__construct();
    }   

    /**
     * Obtiene un usuario por su email.
     * 
     * @param string $email El email del usuario.
     * @return mixed El usuario encontrado o null si no se encuentra.
     */
    public function getUserByEmail($email) {
        $this->db->query('SELECT * FROM usuarios WHERE email = :email');
        $this->db->bind(':email', $email);
        return $this->db->single();
    }
    
    /**
     * Verifica si un email ya existe en la base de datos.
     * 
     * @param string $email El email a verificar.
     * @return bool True si el email existe, False si no existe.
     */
    private function emailExists($email){
        $this->db->query('SELECT * FROM usuarios WHERE email = :email');
        $this->db->bind(':email', $email);
        $existeEmail = $this->db->single();
        return $existeEmail !== false;
    }

    /**
     * Verifica si un nombre de usuario ya existe en la base de datos.
     * 
     * @param string $nombre El nombre de usuario a verificar.
     * @return bool True si el nombre de usuario existe, False si no existe.
     */
    private function userExists($nombre){
        $this->db->query('SELECT * FROM usuarios WHERE nombre = :nombre');
        $this->db->bind(':nombre', $nombre);
        $existeUsuario = $this->db->single();
        return $existeUsuario !== false;
    }

    /**
     * Inserta un nuevo usuario en la base de datos.
     * 
     * @param array $data Los datos del usuario a insertar.
     * @return string El resultado de la inserción ('usuario_registrado' o 'error_registro').
     */
    private function insertUser($data){
        $this->db->query('INSERT INTO usuarios (nombre, email, password, rol_id )
                        VALUES(:nombre, :email, :password, :rol_id)');
        $this->db->bind(':nombre', $data['nombre']);
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
     * Registra un nuevo usuario en el sistema.
     * 
     * @param array $data Los datos del usuario a registrar.
     * @return string El resultado del registro ('Email no válido', 'email_existe', 'usuario_existe', 'usuario_registrado' o 'error_registro').
     */
    public function register($data){
        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            return "Email no válido";
        }

        if($this->emailExists($data['email'])){
            return 'email_existe';
        }

        if($this->userExists($data['nombre'])){
            return 'usuario_existe';
        }

        $data['password'] = $this->hashPassword($data['password']);
        $this->setRol(1);
        $data['rol_id'] = $this->rol;

        return $this->insertUser($data);
    }
}

?>