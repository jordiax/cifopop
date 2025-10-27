<?php
/** 
 * Clase UserControler
 * 
 * Se utiliza para las operaciones con los usuarios de la aplicación.
 * 
 * Los roles solo se pueden tocar por parte del administrador.
 * 
*/
class UserController extends Controller
{
    /** 
     * Método por defecto.
     * 
     * Redirige del método list() de esta misma clase.
     * 
     * @returns ViewResponse
    */
    public function index():ViewResponse
    {
        return $this->list();
    }

    /** 
     * Carga la vista "home" del usuario identificado.
     * 
     * @return ViewResponse
    */
    public function home()
    {
        Auth::check();

        return view('user/home', ['user'=>Login::user()]);
    }

    /** 
     * Listado de los usuarios de la aplicación con filtro y paginador.
     * Solo accesible por un usuario administrador.
     * 
     * @param int $page, el número de página del paginador. Por defecto 1.
     * @return ViewResponse
    */
    public function list(int $page = 1):ViewResponse
    {
        Auth::admin();

        $filtro = Filter::apply('users');

        $limit = RESULTS_PER_PAGE;

        if($filtro)
        {
            $total = User::filteredResults($filtro);

            $paginator = new Paginator('/User/list', $page, $limit, $total);

            $users = User::filter($filtro, $limit, $paginator->getOffset());
        }
        else
        {
            $total = User::total();

            $paginator = new Paginator('/User/list', $page, $limit, $total);

            $users = User::orderBy('id', 'ASC', $limit, $paginator->getOffset());
        }
        return view('user/list', ['users'=>$users, 
                                  'paginator'=>$paginator,
                                  'filtro'=>$filtro]);
    }

    /** 
     * Método para mostrar un usuario de la aplicación.
     * Solo puede utilizarse si se tiene Rol de administrador.
     * 
     * @param int $id, id del usuario a mostrar.
     * @return ViewResponse
    */
    public function show(int $id):ViewResponse
    {
        Auth::admin();

        if(!$id)
            throw new NothingToFindException('No se indicó el usuario a buscar');

        $user = User::findOrFail($id, 'No se encontró el usuario indicado');
        
        $anuncios = $user->hasMany('Anuncio');

        return view('user/show', ['user'=>$user, 'anuncios'=>$anuncios]);
    }

    /** 
     * Método que muestra la vista de creación de un usuario.
     * Solo puede utilizarse si se tiene Rol de administrador.
     * 
     * @return ViewResponse
    */
    public function create():ViewResponse
    {
        Auth::admin();

        return view("user/create");
    }

    /** 
     * Método que guarda un usuario nuevo.
     * 
     * @return RedirectResponse
    */
    public function store():RedirectResponse
    {
        Auth::admin();

        if(!request()->has('guardar'))
            throw new FormException('No se recibió el formulario.');

        $user = new User();

        $user->password = md5($_POST['password']);
        $repeat = md5($_POST['repeatpassword']);

        $user->displayname = request()->post('displayname');
        $user->email = request()->post('email');
        $user->phone = request()->post('phone');

        try
        {
            if($user->password != $repeat)
                throw new ValidationException("Las claves no coinciden.");

            $user->addRole('ROLE_USER', $this->request->post('roles'));

            $user->save();

            $file = request()->file('portada', 8000000, 
                            ['image/png', 'image/jpeg', 'image/gif', 'image/webp']);

            if($file)
            {
                $user->picture = $file->store('../public'.USER_IMAGE_FOLDER, 'user_');
                $user->update();
            }
            
            $aux = $_POST['password'];
            
            $message = "Su usuario se ha creado. Para acceder introduzca su email ($user->email) y su contraseña temporal $aux (recuerde cambiarla desde su página de inicio la primera vez que entre)";

            $email = new Email($user->email, 'Se ha creado su usuario', $message, DEFAULT_EMAIL, DEFAULT_EMAIL_NAME);
            $email->send();

            Session::success("Nuevo usuario $user->displayname creado con éxito.");
            return redirect("/User/show/$user->id");
        }
        catch(SQLException $e)
        {
            $mensaje = "No se pudo guardar al usuario $user->displayname.";

            if(str_contains($e, 'Duplicate entry'))
                $mensaje .= "<br> El usuario <b>ya existe</b>, comprueba el email y el teléfono.";

            Session::error($mensaje);

            if(DEBUG)
                throw new SQLException($e->getMessage());

            return redirect('/User/create');
        }
        catch(ValidationException $e)
        {
            Session::error($e->getMessage());

            if(DEBUG)
                throw new ValidationException($e->getMessage());

            return redirect('/User/create');
        }          
        catch(UploadException $e)
        {
            Session::warning("Usuario guardado correectamente, pero no se pudo subir el fichero de imagen.");

            if(DEBUG)
                throw new UploadException($e->getMessage());

            return redirect("/User/edit/$user->id");
        }
         catch(EmailException $e)
        {
            Session::warning("Se ha guardado el usuario $user->displayname, pero no se le ha podido enviar el email.");

            if(DEBUG)
                throw new Exception($e->getMessage());

            return redirect("/User/show/$user->id");
        }
    }

    /** 
     * Método que abre la vista de edición de un usuario.
     * Solo puede utilizarse si se tiene Rol de administrador.
     * 
     * @return ViewResponse
    */
    public function edit(int $id):ViewResponse
    {
        Auth::admin();

        $user = User::findOrFail($id);

        return view('user/edit', ['user'=>$user]);
    }

    /** 
     * Metodo que guarda la edición de un usario por parte de un administrador.
     * Se guarda también la imagen del usuario si se ha indicado.
     * 
     * @return RediredtResponse
    */
    public function update():RedirectResponse
    {
        Auth::admin();

        if(!request()->has('actualizar'))
            throw new FormException('No se recibió el formulario.');

        $id = intval(request()->post('id'));

        $user = User::findOrFail($id, 'No se ha encontrado el usuario');

        $user->displayname = request()->post('displayname');
        $user->email = request()->post('email');
        $user->phone = request()->post('phone');

        try
        {
           
            // $user->addRole('ROLE_USER', $this->request->post('roles'));

            $user->update();

            $file = request()->file('portada', 8000000, 
                            ['image/png', 'image/jpeg', 'image/gif', 'image/webp']);

            if($file)
            {
                $user->picture = $file->store('../public'.USER_IMAGE_FOLDER, 'user_');
                $user->update();
            }

            Session::success("Usuario $user->displayname modificado con éxito.");
            return redirect('Panel/admin');
        }
        catch(SQLException $e)
        {
            $mensaje = "No se pudo modificar al usuario $user->displayname.";

             Session::error($mensaje);

            if(DEBUG)
                throw new SQLException($e->getMessage());

            return redirect("/User/edit/$user->id");
        }
        catch(ValidationException $e)
        {
            Session::error($e->getMessage());

             return redirect("/User/edit/$user->id");
        }          
        catch(UploadException $e)
        {
            Session::warning("Usuario guardado correectamente, pero no se pudo subir el fichero de imagen.");

            if(DEBUG)
                throw new UploadException($e->getMessage());

            return redirect("/User/edit/$user->id");
        }
    }
    /** 
     * Abre la vista para eliminar un usuario.
     * 
     * @param int $id, el id del usuario a eliminar.
     * @return ViewResponse
    */
    public function delete(int $id):ViewResponse
    {
        Auth::admin();

        $user = User::findOrFail($id, 'No se ha encontrado el usuario');

        return view('user/delete', ['user'=>$user]);
    }
    
    public function destroy():RedirectResponse
    {
        Auth::admin();

        if(!request()->has('borrar'))
            throw new FormException('No se ha recibido confirmación.');

        $id = intval(request()->post('id'));
        $user = User::findOrFail($id, 'No se encontró el usuario');

        try{
            $user->deleteObject();
            if($user->picture)
                File::remove('../public'.USER_IMAGE_FOLDER.$user->picture, true);

            Session::success("Eliminación del usuario $user->displayname, realizada con éxito.");
            return redirect("/User/list");
        }
        catch(SQLException $e)
        {
            Session::error("No se pudo eliminar el usuario $user->displayname");

            if(DEBUG)
                throw new SQLException($e->getMessage());

            return redirect("/User/delete/$id");
        }
        catch(FileException $e)
        {
            Session::error("No se pudo eliminar el fichero de la imagen del usuario.");

            if(DEBUG)
                throw new FileException($e->getMessage());

            return redirect("/User/list");
        }


    }

    public function changePassword():ViewResponse
    {
        if(!request()->has('cambioPassword'))
            throw new FormException('No se ha recibido confirmación.');

        $id = intval(request()->post('id'));
        $user = User::findOrFail($id, 'No se encontró el usuario');

        return view('/user/changePassword', ['user'=>$user]);
    }

    public function newPassword():RedirectResponse
    {

        if(!request()->has('cambiar'))
            throw new FormException('No se recibió el formulario.');

        $id = request()->post('id');

        $user = User::findOrFail($id);

        if($user->password == md5($_POST['oldPassword']))
        {
            If(md5($_POST['newPassword']) == md5($_POST['repeatPassword']))
            {
                $user->password = md5($_POST['newPassword']);
            }
            else
            {
                Session::error('Los password nuevos no coinciden.');
                return redirect("/User/home");
            }
        }
        else
        {
            Session::error('Error con el password antiguo.');
            return redirect("/User/home");
        }
        try
        {
            $user->update();
            return redirect("/User/home");
        }
        catch(SQLException $e)
        {
            Session::error("No se pudo cambiar el password.");

            if(DEBUG)
                throw new SQLException($e->getMessage());

            return redirect("/User/home");
        }
    }

    public function addrol():RedirectResponse
    {
        Auth::admin();

        $idUser = intval(request()->post('id'));

        $user = User::findOrFail($idUser, 'No se encontró el usuario');
        $rol = request()->post('rol');

        // dd($user.', AddRol: '.$rol);
        try
        {
            $user->addRole($rol);
            $user->update();

            Session::success("Se ha añadido el rol $rol.");

            return redirect("/User/edit/$user->id");
        }
        catch(SQLException $e)
        {
            Session::error("No se ha podido añadir el rol $rol.");

            if(DEBUG)
                throw new SQLException($e->getMessage());

            return redirect("/User/edit/$idUser");
        }
    }

    public function removerol()
    {
        Auth::admin();

        $idUser = intval(request()->post('id'));
        $user = User::findOrFail($idUser, 'No se encontró el usuario');
        $rol = request()->post('rol');

        try
        {
            $user->removeRole($rol);
            $user->update();

            Session::success("Se ha eliminado el rol $rol.");

            return redirect("/User/edit/$idUser");
        }
        catch(SQLException $e)
        {
            Session::error("No se ha podido eliminar el rol $rol.");

            if(DEBUG)
                throw new SQLException($e->getMessage());

            return redirect("/User/edit/$idUser");
        }
    }
}