<?php
    class ContactoController extends Controller
    {
        /** 
         * Carga la página de contacto
         * 
         * @return ViewResponse
        */
        public function index():ViewResponse
        {
            return view('panel/contacto');
        }

        public function send():RedirectResponse
        {
            if(empty(request()->post('enviar')))
                throw new FormException('No se hanrecibido los datos de contacto');

            $realFrom = request()->post('email');
            $realName = request()->post('nombre');
            $subject = request()->post('asunto');
            $message = request()->post('mensaje');

            try{
                $email = new Email(ADMIN_EMAIL, $subject, $message, DEFAULT_EMAIL, DEFAULT_EMAIL_NAME, $realFrom, $realName);
                $email->send();

                Session::success("Se ha enviado el mensaje. En breve recibirá respuesta.");

                return redirect('/');
            }
            catch(EmailException $e)
            {
                Session::error('No se ha podido enviar el email.');

                if(DEBUG)
                    throw new Exception($e->getMessage());

                return redirect('/Contacto');
            }
        }
    }