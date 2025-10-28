<?php
    #[\AllowDynamicProperties]
    class Anuncio extends Model
    {
         Public function validate(bool $checkedId = false):array
        {
            $errores=[];

            if($checkedId && empty(intval($this->id)))
                $errores['id'] = "No se indicó el id";
            if(empty($this->titulo) || strlen($this->titulo)<1 ||strlen($this->titulo)>255)
                $errores['titulo'] = 'Error en la longitud del título.';
            if(empty(floatval($this->precio)))
                $errores['edicion'] = 'Error en el número de edición';
            
            if($errores)
                throw new ValidationException("<br>".arrayToString($errores, false, false, ".<br>"));
            
            return $errores;
        }
    }