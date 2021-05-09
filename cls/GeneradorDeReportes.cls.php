<?php
date_default_timezone_set('America/Lima');
include_once 'Conexion.cls.php';
include_once 'Historial.cls.php';
include_once 'Mailer.cls.php';
include_once 'MovimientoDeUsuario.cls.php';
include_once '../config.ini.php';

class GeneradorDeReportes
{
    //GENERA UN REPORTE DE REEMBOLSO
    static function generar_reporte_de_reembolso($numero_de_documento){

        $encabezado_de_reembolso = Conexion::conect()->get('encabezado_de_reembolso','*',['numero_de_documento'=>$numero_de_documento]);

        $etq_reembolso = '';
        switch ($encabezado_de_reembolso['tipo_de_reembolso']){
            case 1:
                $etq_reembolso = 'NORMAL';
                break;
            case 2:
                $etq_reembolso = 'CREDITO HOSPITALARIO';
                break;
            case 3:
                $etq_reembolso = 'COORDINACION DE BENEFICIOS';
                break;

        }


        $informacion_de_usuario = Conexion::conect()->get('informacion_de_usuario','*',['numero_de_id_de_usuario'=>$encabezado_de_reembolso['numero_de_id_de_usuario_fk']]);
        $cie = Conexion::conect()->get('cie','*',['codigo_de_cie'=>$encabezado_de_reembolso['codigo_de_cie']]);
        $detalles_de_reembolso = Conexion::conect()->select('detalles_de_reembolso','*',['indice_de_reembolso_fk'=>$encabezado_de_reembolso['indice_de_reembolso']]);


        $reporte = '';
        $reporte .="<table class=\"table table-bordered text-dark-m1 brc-black-tp10 mb-1 text-100\">
                        <tr>
                            <td colspan='3' class='justify-content-center'>
                                <img src='assets/logo_fe.png' alt='FarmaEnlace' width='300px'>
                            </td>
                            <td colspan='3' class='justify-content-center'>
                                <h5 class='h5 pt-2 justify-content-center text-info-d1'>".utf8_decode($informacion_de_usuario['apellidos'])." ".utf8_decode($informacion_de_usuario['nombres'])."</h5>
                            </td>
                        </tr>
                        <tr class=\"bgc-white text-secondary-d3 text-90\">
                          <th class=\"py-1 px-1 text-primary\">
                                N&uacute;mero de documento
                          </th>

                          <th class='py-1 px-1 text-secondary'>
                                ".$encabezado_de_reembolso['numero_de_documento']."
                          </th> 
                        <th class=\"py-1 px-1 text-primary\">
                                Fecha
                          </th>

                          <th class='py-1 px-1 text-secondary'>
                                ".$encabezado_de_reembolso['fecha_de_ingreso']."
                          </th> 
                           <th class=\"py-1 px-1 text-primary\">
                                Tipo de reembolso
                          </th>

                          <th class='py-1 px-1 text-secondary'>
                                ".$etq_reembolso."
                          </th>   
                        </tr>
                        <tr>
                            <td colspan='1' class='px-1 py-1 text-primary'>C&oacute;digo CIE</td>
                            <td colspan='5' class='px-1 py-1 text-secondary'>".utf8_decode($cie['nombre_de_cie'])."</td>
                        </tr>
                        <tr>
                            <td colspan='1' class='px-1 py-1 text-primary'>Enfermedad preexistente</td>
                            <td colspan='5' class='px-1 py-1 text-secondary'>".utf8_decode($encabezado_de_reembolso['enfermedad_preexistente'])."</td>
                        </tr>
                        <tr>
                            <td colspan='6'>
                                <table class=\"table table-bordered border-0 table-striped-secondary text-dark-m1 mb-0 text-90\">
                                    <thead>
                                        <tr>
                                            <th class='text-primary-d1'>Numero de factura</th>
                                            <th class='text-primary-d1'>Fecha de documento</th>
                                            <th class='text-primary-d1'>Concepto</th>
                                            <th class='text-primary-d1'>Subtotal</th>
                                            <th class='text-primary-d1'>Valor no  cubierto</th>
                                            <th class='text-primary-d1'>Valor cubierto</th>
                                            <th class='text-primary-d1'>Copago</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ";
                                    foreach ($detalles_de_reembolso as $reembolso)
                                    {
                                        if(Conexion::conect()->has('servicios_medicos',['indice_de_servicio_medico'=>$reembolso['indice_de_servicio_medico_fk']]))
                                        {
                                            $servicio = Conexion::conect()->get('servicios_medicos','*',['indice_de_servicio_medico'=>$reembolso['indice_de_servicio_medico_fk']]);
                                        }
                                        else{
                                            $servicio = Conexion::conect()->get('servicios_medicos_especiales','*',['indice_de_servicio_medico'=>$reembolso['indice_de_servicio_medico_fk']]);
                                        }
                                        $reporte.="<tr>
                                                    <td>".$reembolso['numero_de_factura']."</td>
                                                    <td>".$reembolso['fecha_de_factura']."</td>
                                                    <td>".utf8_decode($servicio['servicio_medico'])."</td>
                                                    <td>$".$reembolso['subtotal']."</td>
                                                    <td>$".$reembolso['valor_no_cubierto']."</td>
                                                    <td>$".$reembolso['valor_cubierto']."</td>
                                                    <td>$".$reembolso['valor_copago']."</td>
                                        </tr>";
                                    }
                        $reporte.="</tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class='text-primary-d2' colspan='3'>Valor total del reclamo </td> <td colspan='3' class='text-secondary-d2'>$".$encabezado_de_reembolso['valor_del_reclamo']."</td>
                        </tr>
                        <tr>    
                            <td class='text-primary' colspan='3'>Valor de deducible </td> <td colspan='3' class='text-secondary'>$".$encabezado_de_reembolso['deducible']."</td>
                        </tr>
                        <tr>    
                            <td class='text-primary' colspan='3'>Total copago </td> <td colspan='3' class='text-secondary'>$".$encabezado_de_reembolso['copago_1']."</td>
                        </tr>
                        <tr>
                            <td colspan='3' class='text-primary-d2'>Valor cubierto</td>
                            <td colspan='3' class='text-blue-d1'>$".$encabezado_de_reembolso['valor_cubierto']."</td>
                        </tr>
                        <tr>
                            <td colspan='3' class='text-primary-d2'>Valor no cubierto</td>
                            <td colspan='3' class='text-blue-d1'>$".$encabezado_de_reembolso['valor_no_cubierto']."</td>
                        </tr>
                        <tr>
                            <td colspan='3' class='text-primary-d2'>Valor total de reembolso</td>
                            <td colspan='3' class='text-blue-d1'>$".$encabezado_de_reembolso['total_de_reembolso']."</td>
                        </tr>
                        <tr>
                            <td colspan='6'>
                                <input type='button' class='btn btn-light-info' value='Imprimir' onclick='imprimir(\"div_formulario_nuevo_reembolso\")'>
                            </td>
                        </tr>
                      </table>";
    echo $reporte;
    }

    //GENERA UN REPORTE DE TODOS LOS REEMBOLSOS DEPENDIENDO EL AÑO
    static function reporte_de_reembolsos_por_periodod($periodo)
    {
        $data_de_encabezados = Conexion::conect()->select('encabezado_de_reembolso','*',['periodo'=>$periodo]);
        $reporte="";
        $total_de_reembolso =0;
        $etiqueta_de_estado = '';
        $etiqueta_de_tipo_de_reembolso = '';
        $reporte.="<table class=\"table text-dark-m1 brc-black-tp10 mb-1\">
                      <thead>
                        <tr class=\"bgc-white text-secondary-d3\">
                          <th colspan='6' class=\"py-3 pl-35 text-center\">
                            <span class='h3  text-primary-d1'>Reporte de reembolsos generados en el per&iacute;odo ".$periodo."</span>
                          </th>
                        </tr>
                      </thead>
                      <tr class=\"bgc-white text-secondary-d3 text-85\">
                        <th class=\"py-3 pl-35 text-center\">Fecha de apertura</th>
                        <th class=\"py-3 pl-35 text-center\">N&uacute;mero de documento</th>
                        <th class=\"py-3 pl-35 text-center\">Beneficiario</th>
                        <th class=\"py-3 pl-35 text-center\">Tipo de reembolso</th>
                        <th class=\"py-3 pl-35 text-center\">Estado</th>        
                        <th class=\"py-3 pl-35 text-center\">Reembolso</th>
                      </tr>
                      <tbody>
                      ";
        foreach ($data_de_encabezados as $encabezado)
        {

            $usuario = Conexion::conect()->get('informacion_de_usuario','*',['numero_de_id_de_usuario'=>$encabezado['numero_de_id_de_usuario_fk']]);
            switch ($encabezado['estado_de_reclamo'])
            {
                case 1: $etiqueta_de_estado = 'GENERADO';
                    break;
                case 2: $etiqueta_de_estado = 'PROCESADO';
                    break;
                case 3: $etiqueta_de_estado = 'RECHAZADO';
                    break;
                case 4: $etiqueta_de_estado = 'ENTREGADO';
                    break;

            }

            switch ($encabezado['tipo_de_reembolso'])
            {
                case 1: $etiqueta_de_tipo_de_reembolso = 'NORMAL';
                    break;
                case 2: $etiqueta_de_tipo_de_reembolso = 'CREDITO HOSPITALARIO';
                    break;
                case 3: $etiqueta_de_tipo_de_reembolso = 'COORDINACION DE BENEFICIOS';
                    break;

            }

            $reporte.="<tr class='bgc-h-orange-l1 text-80'>
                        <td class='text-left'>".$encabezado['fecha_de_ingreso']."</td>
                        <td class='text-left'><a onclick='generar_reporte_de_reembolso(\"".$encabezado['numero_de_documento']."\")'><i class='text-orange fa  fa-print px-3px'></i> ".$encabezado['numero_de_documento']."</a></td>
                        <td class='text-left'>".utf8_decode($usuario['apellidos'])." ".utf8_decode($usuario['nombres'])."</td>
                        <td class='text-left'>".utf8_decode($etiqueta_de_tipo_de_reembolso)."</td>
                        <td class='text-left'>".utf8_decode($etiqueta_de_estado)."</td>
                        <td class='text-right'>$ ".$encabezado['total_de_reembolso']."</td>
                    </tr>";
            $total_de_reembolso=$total_de_reembolso+$encabezado['total_de_reembolso'];

        }
        $reporte.="<tr class='bgc-h-orange-l1 text-80'>";
            $reporte.="<td colspan='2' class='text-center h4 text-primary-d1'>Total reembolsado en este per&iacute;odo</td>
            <td colspan='4' class='text-right h4 text-primary-d2'>$".$total_de_reembolso."</td>";
        $reporte.="</tr>";
        $reporte.="<tr><td colspan='6' class='align-content-center'><input type='button' class='btn btn-light-info' value='Imprimir' onclick='imprimir(\"div_formulario_nuevo_reembolso\")'></td></tr>";
        $reporte.="</tbody></table>";
        return $reporte;
    }

}