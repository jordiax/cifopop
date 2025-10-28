<?php
    /** 
     * AnuncioController
     * 
     * Controller para las operaciones con anuncios.
    */
    class AnuncioController extends Controller
    {
        /** 
         * Método por defecto.
         * 
         * Redirige del método list() de esta misma clase.
         * 
         * @return ViewResponse
        */
        public function index():ViewResponse
        {
            return $this->list();
        }

        /** 
         * Listado de todos los anuncios.
         * 
         * @param int $page, numero de página del paginador. Por defecto la primera.
         * @return ViewResponse
        */
        public function list(int $page = 1):ViewResponse
        {
            $filtro = Filter::apply('anuncios');

            $limit = RESULTS_PER_PAGE;

            if($filtro)
            {
                $total = Anuncio::filteredResults($filtro);

                $paginator = new Paginator('/Anuncio/list', $page, $limit, $total);

                $anuncios = Anuncio::filter($filtro, $limit, $paginator->getOffset());
            }
            else
            {
                $total = Anuncio::total();

                $paginator = new Paginator('/Anuncio/list', $page, $limit, $total);

                $anuncios = Anuncio::orderBy('id', 'ASC', $limit, $paginator->getOffset());
            }
            return view('anuncio/list', ['anuncios'=>$anuncios, 
                                        'paginator'=>$paginator,
                                        'filtro'=>$filtro]);
        }

        /** 
         * Detalle de un solo anuncio.
         * 
         * @param int $id, el id del anuncio a mostrar.
         * @return ViewResponse
        */
        public function show(int $id = 0):ViewResponse
        {
            if(!$id)
                throw new NothingToFindException('No se indicó el anuncio a buscar');

            $anuncio = Anuncio::findOrFail($id, 'No se encontró el anuncio indicado');

            return view('anuncio/show', ['anuncio'=>$anuncio]);
        }

        public function create()
        {
            Auth::role('ROLE_USER');

            return view('anuncio/create');
        }
        
        /** 
         * Guarda los datos enviados por el formulario de creación de un nuevo anuncio.
         * 
         * @returns RedirectResponse
        */
        public function store():RedirectResponse
        {
            Auth::role('ROLE_USER');

            if(!request()->has('guardar'))
                throw new FormException('No se recibió el formulario');

            $anuncio = new Anuncio();

            $anuncio->iduser        = request()->post('iduser');
            $anuncio->titulo        = request()->post('titulo');
            $anuncio->precio        = request()->post('precio');
            $anuncio->descripcion   = request()->post('descripcion');

            try
            {
                $anuncio->validate();
                $anuncio->save();

                $file = request()->file('imagen', 8000000, 
                            ['image/png', 'image/jpeg', 'image/gif', 'image/webp']);


                if($file)
                {
                    $anuncio->imagen = $file->store('../public'.AD_IMAGE_FOLDER, 'ad_');
                    $anuncio->update();
                }

                Session::success("Guardado del anuncio $anuncio->titulo correcto.");

                return redirect("/Anuncio/show/$anuncio->id");
            }
            catch(ValidationException $e)
            {
                Session::error("Errores de validación al crear el anuncio. ".$e->getMessage());

                return redirect("/Anuncio/create");
            }
            catch(SQLException $e)
            {
                Session::error("No se pudo guardar el anuncio $anuncio->titulo correcto.");

                if(DEBUG)
                    throw new SQLException($e->getMessage());

                return redirect("/Anuncio/create");
            }
            catch(UploadException $e)
            {
                Session::warning("Anuncio guardado correectamente, pero no se pudo subir el fichero de imagen.");

                if(DEBUG)
                    throw new UploadException($e->getMessage());

                return redirect("/Anuncio/edit/$anuncio->id");
            }
        }

        /** 
         * Editar los datos de un anuncio.
         * 
         * @param int $id, el id del anuncio a editar.
         * @return ViewResponse
        */
        public function edit(int $id = 0):ViewResponse
        {
            Auth::role('ROLE_USER');

            $anuncio = Anuncio::findOrFail($id, 'No se encontró el anuncio');
           
            if(user()->id != $anuncio->iduser)
                throw new AuthException("No uede modificar un anuncio que no sea suyo");

            return view('anuncio/edit', ['anuncio' => $anuncio]);
        }

        /** 
         * Guarda los datos enviados por el formulario de modificación de un anuncio.
         * 
         * @returns RedirectResponse
        */
        public function update():RedirectResponse
        {
            Auth::role('ROLE_USER');

            if(!request()->has('actualizar'))
                throw new FormException('No se recibieron datos');

            $id = intval(request()->post('id'));

            $anuncio = Anuncio::findOrFail($id, 'No se ha encontrado el anuncio');

            $anuncio->titulo        = request()->post('titulo');
            $anuncio->iduser        = request()->post('iduser');
            $anuncio->precio        = request()->post('precio');
            $anuncio->descripcion   = request()->post('descripcion');

            try
            {
                $anuncio->validate($id);
                $anuncio->update();

                $file = request()->file('imagen', 8000000, 
                            ['image/png', 'image/jpeg', 'image/gif', 'image/webp']);

                if($file)
                {
                    if($anuncio->imagen)
                        File::remove('../public'.AD_IMAGE_FOLDER.$anuncio->imagen);

                    $anuncio->imagen = $file->store('../public'.AD_IMAGE_FOLDER, 'ad_');
                    $anuncio->update();
                }

                Session::success("Actualización del anuncio $anuncio->titulo correcta.");

                return redirect("/Anuncio/show/$anuncio->id");
            }
            catch(ValidationException $e)
            {
                Session::error("Errores de validación al editar el anuncio. ".$e->getMessage());

                return redirect("/Anuncio/edit/$id");
            }
            catch(SQLException $e)
            {
                Session::error("No se pudo actualizar el anuncio $anuncio->titulo correcto.");

                if(DEBUG)
                    throw new SQLException($e->getMessage());

                return redirect("/Anuncio/edit/$id");
            }
            catch(UploadException $e)
            {
                Session::warning("Anuncio guardado correctamente, pero no actualizó la imagen.");

                if(DEBUG)
                    throw new UploadException($e->getMessage());

                return redirect("/Anuncio/edit/$id");
            }
        }

        /** 
         * Elimina la imagen del anuncio.
         * 
         * @return RedirectResponse
        */
        public function dropimage():RedirectResponse
        {
            Auth::role('ROLE_USER');

            if(!request()->post('borrar'))
                throw new FormException('Faltan datos para completar la operación');

            $id = request()->post('id');
            $anuncio = Anuncio::findOrFail($id, 'No se ha encontrado el anuncio');

            $tmp = $anuncio->imagen;
            $anuncio->imagen = NULL;

            try
            {
                $anuncio->update();
                
                File::remove('../public'.AD_IMAGE_FOLDER.$tmp, true);

                Session::success("Borrado de la imagen de $anuncio->titulo realizada.");

                return redirect("/Anuncio/edit/$id");
            }
            catch(SQLException $e)
            {
                Session::error("No se pudo eliminar la imagen.");

                if(DEBUG)
                    throw new SQLException($e->getMessage());

                return redirect("/Anuncio/edit/$id");
            }
            catch(FileException $e)
            {
                Session::error("No se pudo eliminar el fichero de la imagen.");

                if(DEBUG)
                    throw new FileException($e->getMessage());

                return redirect("/Anuncio/edit/$id");
            }
        }

        /** 
         * Abre la vista para elimina los datos de un anuncio.
         * 
         * @param int $id, el id del anuncio a eliminar.
         * @return ViewResponse
        */
        public function delete(int $id = 0):ViewResponse
        {
            Auth::role('ROLE_USER');

            $anuncio = Anuncio::findOrFail($id, 'Anuncio no encontrado');

            if(user()->id != $anuncio->iduser)
                throw new AuthException("No uede eliminar un anuncio que no sea suyo.");

            return view('anuncio/delete', ['anuncio' => $anuncio]);
        }

        /** 
         * Elimina los datos de un anuncio.
         * 
         * @return RedirectResponse
        */
        public function destroy():RedirectResponse
        {
            Auth::role('ROLE_USER');

            if(!request()->has('borrar'))
                throw new FormException('No se ha recibido confirmación.');
            
            $id = intval(request()->post('id'));
            $anuncio = Anuncio::findOrFail($id, 'No se encontró el anuncio');

            try
            {
                $anuncio->deleteObject();

                if($anuncio->imagen)
                    File::remove('../public'.AD_IMAGE_FOLDER.$anuncio->imagen, true);

                Session::success("Eliminación del anuncio $anuncio->titulo, realizada con éxito.");
                return redirect("/Anuncio/list");
            }
            catch(SQLException $e)
            {
                Session::error("No se pudo eliminar el anuncio $anuncio->titulo");

                if(DEBUG)
                    throw new SQLException($e->getMessage());

                return redirect("/anuncio/delete/$id");
            }
             catch(FileException $e)
            {
                Session::error("No se pudo eliminar el fichero de la imagen.");

                if(DEBUG)
                    throw new FileException($e->getMessage());

                return redirect("/Anuncio/list");
            }
        }
    }