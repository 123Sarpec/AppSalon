<?php

namespace Controllers;
use Model\Servicio;
use Model\Cita;
use Model\CitaServicio;

class apiController{
    public static function index(){
        $servicios = Servicio ::all(); 
        echo json_encode($servicios, JSON_UNESCAPED_UNICODE);
 
        }

        public static function guardar(){ 
            //almacena la cita y debuelve el id
            $cita= new Cita($_POST);
            $resultado = $cita->guardar();

            $id = $resultado['id'];

            // almaceta las citas y los servicio 
            $idServicios = explode(",", $_POST['servicios']);

            foreach ($idServicios as $idServicio) {
              $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
              ];
              $citaServicio = new CitaServicio($args);
              $citaServicio->guardar();
            }

            echo json_encode(['resultado' => $resultado]);
            

        } 

        public static function eliminar(){ 
          if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $cita = Cita::find($id);
            $cita->eliminar();
            header('Location:' . $_SERVER['HTTP_REFERER']);
          }
        }
}