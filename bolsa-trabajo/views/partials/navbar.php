<header>
    <nav class="flex justify-between items-center px-5 sm:px-20 py-5 border border-b-2">
        <div class="flex gap-5">
            <a href="<?= constant('URL')?>" class="text-[#000] hover:text-[#1E40AF]">Inicio</a>
            <a href="<?= constant('URL')?>trabajos/" class="text-[#000] hover:text-[#1E40AF]">Trabajos</a>
            <a href="<?= constant('URL')?>empresas/" class="text-[#000] hover:text-[#1E40AF]">Empresas</a>
        </div>

        <div class="flex gap-3">
        <?php
            require_once __DIR__ .'../../../controllers/userSesion.php';
            $userSession = new UserSesion();
            $user = $userSession->getCurrentUser();

            if ($user) {
            // Si hay un usuario actual, muestra el botón
            echo '
            <div id="login-button" class="sm:flex hidden gap-x-5 bg-[#DCE8F8] p-2 rounded-lg mt-1 z-10 hidden">
              <a  class="text-[#2A56CB] hover:text-[#1E40AF]" href="' . constant('URL') . 'login/logout">Cerrar sesion</a>
            </div>';
            } else {
            // Si no hay un usuario actual, muestra los botones de inicio de sesión y registro
                echo '
                <div id="login-button" class="sm:flex hidden gap-x-5 bg-[#DCE8F8] p-2 rounded-lg mt-1 z-10 hidden">
                    <a href="' . constant('URL') . 'login/" class="text-[#2A56CB] hover:text-[#1E40AF]">Iniciar Sesión</a>
                </div>
                <div id="register-button" class="sm:flex hidden gap-x-5 bg-[#DCE8F8] p-2 rounded-lg mt-1 z-10 hidden">
                    <a href="' . constant('URL') . 'registroUsuario/" class="text-[#2A56CB] hover:text-[#1E40AF]">Registrarme</a>
                </div>';
                }
            ?>
        </div>
    </nav>
</header>

