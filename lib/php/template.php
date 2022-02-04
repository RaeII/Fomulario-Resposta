<?php
class templateParser
{
    private $output;
 
    //construtor faz a carga do template
    function templateParser( $templateFile='template.htm' ) {
        (file_exists($templateFile)) ? $this->output=file_get_contents($templateFile) : die('Erro: Arquivo '.$templateFile.' não encontrado');
    }
 
    //faz a substituição
    function parseTemplate ($tags=array()) {
        if(count($tags)>0){
            foreach($tags as $tag=>$data){
                $this->output = str_replace('{'.$tag.'}',$data, $this->output);
            }
        }
        else {
            die('Erro: Arquivo não encontrado');
        }
    }
 
    //Exibe o template
    function display() {
        return $this->output;
    }
}