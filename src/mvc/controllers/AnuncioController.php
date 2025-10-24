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
    }