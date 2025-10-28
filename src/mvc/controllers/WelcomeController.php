<?php

/** Welcome
 *
 * Controlador por omisión según la configuración por defecto del
 * fichero de configuración config.php.
 *
 * Última revisión: 09/03/2025
 * 
 * @author Robert Sallent <robert@fastlight.org>
 */

class WelcomeController extends Controller{
    
    /** 
     * Carga la vista de portada. 
     * 
     * @return ViewResponse
     * 
     * */
    public function index():ViewResponse{
        // Cargamos los 5 últimos anuncios para mostrarlos en la galería últimos de la página principal.
        $anuncios = Anuncio::orderBy('id', 'DESC', 5);

        // Cargamos los 5 anuncios más baratos para mostrarlos en la galería chollos de la página principal.
        $chollos = Anuncio::orderBy('precio', 'ASC', 5);
        
        return view('welcome', ['anuncios'=>$anuncios, 'chollos'=>$chollos]);
    }  
}

