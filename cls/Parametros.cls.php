<?php


class Parametros
{
    public $archivo,$elemento,$elementos,$url,$formulario,$parametro1,$parametro2,$valor_de_deducible,$saldo,$tiempo;
    function mostrar_parametros()
    {
        $this->url = 'parametros.xml';
        $this->elementos = simplexml_load_file($this->url);
        $this->formulario.="<div class='row pb-3px'><div class='col-12 text-center'><span class='h3 m-1px text-primary'>Parámetros del Sistema</span></div></div>";

        $this->formulario.="<form action='/controllers/actualizar_parametros_del_sistema.ctrl.php' name='formulario_de_parametros'>";
        $this->formulario.="<div class=\"row\">";
        foreach($this->elementos as $this->elemento)
        {
            
            $this->formulario.="<div class=\"col-8 px-0 mb-2 mb-md-0\">
                
                <div class=\"ccard h-100 pt-2 pb-25 px-25 d-flex mx-2 overflow-hidden\">
                    <div class=\"position-br	mb-n5 mr-n5 radius-round bgc-purple-l3 opacity-3\" style=\"width: 5.25rem; height: 5.25rem;\"></div>
                    <div class=\"position-br	mb-n5 mr-n5 radius-round bgc-purple-l2 opacity-5\" style=\"width: 4.75rem; height: 4.75rem;\"></div>
                    <div class=\"position-br	mb-n5 mr-n5 radius-round bgc-purple-l1 opacity-5\" style=\"width: 4.25rem; height: 4.25rem;\"></div>
                    <div class=\"flex-grow-1 pl-25 pos-rel d-flex flex-column\">
                        <div class=\"text-secondary-d4\">
                         <span class=\"text-200 text-info-d1\">
                             <input type='number' class='form-control-sm border-1 text-80' name='valor_".$this->elemento->id_de_parametro."' value='".$this->elemento->valor."'>
                            
                         </span>
                        </div>

                        <div class=\"mt-auto text-nowrap text-secondary-d2 text-105 letter-spacing mt-n1\">
                            <span class='text-success'>".($this->elemento->titulo)."</span>
                        </div>
                    </div>
                    <div class=\"ml-auto pr-1 align-self-center pos-rel text-125\">
                        <i class=\"fa fa-cogs text-orange opacity-1 fa-2x mr-25\"></i>
                    </div>
                </div>
            </div>";
        }
        $this->formulario.="</div><div class='mb-5'></div>";
        $this->formulario.="<div class='row'><div class='col-12 justify-content-center'><input type='submit' class='btn btn-primary border-2 brc-black-tp10 radius-round px-3 mb-1' value='Actualizar parametros'></div></div>";
        $this->formulario.="<form>";

        echo $this->formulario;
    }
    static function  sobreescribir_parametros($valor1,$valor2,$valor3)
    {
        
        $dom = new DOMDocument();
		$dom->encoding = 'utf-8';
		$dom->xmlVersion = '1.0';
		$dom->formatOutput = true;
        
        $xml_file_name = '../parametros.xml';
		$root = $dom->createElement('parametros');
		$parametro1 = $dom->createElement('parametro');
            $id_de_parametro_1 = $dom->createElement('id_de_parametro', '1');
            $parametro1->appendChild($id_de_parametro_1);
            $titulo = $dom->createElement('titulo','Valor de cobertura por concepto de  deducible en dólares');
            $parametro1->appendChild($titulo);
            $valor = $dom->createElement('valor',$valor1);
            $parametro1->appendChild($valor);
        $root->appendChild($parametro1);
		$dom->appendChild($root);

        $parametro2 = $dom->createElement('parametro');
            $id_de_parametro_2 = $dom->createElement('id_de_parametro', '2');
            $parametro2->appendChild($id_de_parametro_2);
            $titulo = $dom->createElement('titulo','Saldo inicial por Usuario en dólares');
            $parametro2->appendChild($titulo);
            $valor = $dom->createElement('valor',$valor2);
            $parametro2->appendChild($valor);
        $root->appendChild($parametro2);
		$dom->appendChild($root);

        $parametro3 = $dom->createElement('parametro');
            $id_de_parametro_3 = $dom->createElement('id_de_parametro', '3');
            $parametro3->appendChild($id_de_parametro_3);
            $titulo = $dom->createElement('titulo','Tiempo mínimo de afiliación para acceder al servicio en meses');
            $parametro3->appendChild($titulo);
            $valor = $dom->createElement('valor',$valor3);
            $parametro3->appendChild($valor);
        $root->appendChild($parametro3);
		$dom->appendChild($root);

	    $dom->save($xml_file_name);
    header("Status: 301 Moved Permanently");
    header("Location: ../");
    exit;
    }

    function obtener_deducible()
    {
        $this->url = '../parametros.xml';
        $this->elementos = simplexml_load_file($this->url);
        foreach($this->elementos as $this->elemento)
        {
            if($this->elemento->id_de_parametro == 1)
            {
                $this->valor_de_deducible = $this->elemento->valor;
            }
            
        }
        return floatval($this->valor_de_deducible);
    }
    function obtener_saldo()
    {
        $this->url = '../parametros.xml';
        $this->elementos = simplexml_load_file($this->url);
        foreach($this->elementos as $this->elemento)
        {
            if($this->elemento->id_de_parametro == 2)
            {
                $this->saldo = $this->elemento->valor;
            }
            
        }
        return floatval($this->saldo);
    }
    function obtener_tiempo_minimo_de_afiliacion()
    {
        $this->url = '../parametros.xml';
        $this->elementos = simplexml_load_file($this->url);
        foreach($this->elementos as $this->elemento)
        {
            if($this->elemento->id_de_parametro == 3)
            {
                $this->tiempo = $this->elemento->valor;
            }
            
        }
        return floatval($this->tiempo);
    }
}