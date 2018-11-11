<section class="mbr-navbar mbr-navbar--freeze mbr-navbar--absolute mbr-navbar--sticky mbr-navbar--auto-collapse" id="ext_menu-0">
    <div class="mbr-navbar__section mbr-section">
        <div class="mbr-section__container container">
            <div class="mbr-navbar__container">

                <div class="mbr-navbar__column mbr-navbar__column--s mbr-navbar__brand">
                    <span class="mbr-navbar__brand-link mbr-brand mbr-brand--inline">
                        <span class="mbr-brand__logo"><a href="#"><img class="mbr-navbar__brand-img mbr-brand__img" src="views/images/logo.png" alt="Mobirise"></a></span>
                    </span>
                </div>

                <div class="mbr-navbar__hamburger mbr-hamburger text-white">
                  <span class="mbr-hamburger__line"></span>
                </div>

                <div class="mbr-navbar__column mbr-navbar__menu">
                  <nav class="mbr-navbar__menu-box mbr-navbar__menu-box--inline-right">
                    <div class="mbr-navbar__column">
                      <ul class="mbr-navbar__items mbr-navbar__items--right mbr-buttons mbr-buttons--freeze mbr-buttons--right btn-decorator mbr-buttons--active">
                        <li class="mbr-navbar__item">
                          <a class="mbr-buttons__link btn text-white" href="?view=index">INICIO
                          </a>
                        </li>

                        <?php
                        if(!isset($_SESSION['app_id'])) {
                          echo '
                          <li class="mbr-navbar__item">
                            <div class="mbr-navbar__column">
                              <ul class="mbr-navbar__items mbr-navbar__items--right mbr-buttons mbr-buttons--freeze mbr-buttons--right btn-inverse mbr-buttons--active">
                                <li class="mbr-navbar__item">
                                  <a class="mbr-buttons__btn btn btn-danger" data-toggle="modal" data-target="#Registro">REGISTRATE
                                  </a>
                                </li>
                              </ul>
                            </div>
                          </li>';
                        } else {

                          $user = new User();
                          $user->obt_usuario($_SESSION['app_id']);

                          switch ($user->rolDesc) {
                            case 'Admin':
                              echo '
                              
                              <li class="mbr-navbar__item">
                                <a class="mbr-buttons__link btn text-white" href="?view=usuario&action=listar">Admin Users
                                </a>
                              </li>
                            ';
                              
                            case 'Encuestador':
                              echo '
                              
                                <li class="mbr-navbar__item">
                                  <a class="mbr-buttons__link btn text-white" href="?view=encuesta&action=crear">Crear Encuesta
                                  </a>
                                </li>
                              ';
                              
                            case 'Encuestado':
                              echo '
                                
                                <li class="mbr-navbar__item">
                                  <a class="mbr-buttons__link btn text-white" href="?view=encuesta&action=listar">Encuestas
                                  </a>
                                </li>
                                <li class="mbr-navbar__item">
                                  <a class="mbr-buttons__link btn text-white" href="?view=perfil&id='.$_SESSION['app_id'].'">'. strtoupper($_SESSION['nomUser']) .'
                                  </a>
                                </li>
                              ';
                              break;
                            default:
                              include('core/controllers/errorController.php');
                              break;
                          }
                          echo '
                          <li class="mbr-navbar__item">
                            <a class="mbr-buttons__btn btn btn-danger" href="?view=salir">Salir
                            </a>
                          </li>';
                        }
                        ?>
                      </ul>
                    </div>
                  </nav>
                </div>

            </div> <!-- Fin de container -->
        </div>
    </div>
</section>


<?php
if(!isset($_SESSION['app_id'])) {
  
  include(HTML_DIR . '/public/reg.html');
  include(HTML_DIR . '/public/lostpass.html');
}

?>