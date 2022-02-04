<?php
require_once('sql.php');
function removeAcentos ($string, $slug = false) {
    $string = strtolower($string);
    // Código ASCII das vogais
    $ascii['a'] = range(224, 230);
    $ascii['e'] = range(232, 235);
    $ascii['i'] = range(236, 239);
    $ascii['o'] = array_merge(range(242, 246), array(240, 248));
    $ascii['u'] = range(249, 252);

    // Código ASCII dos outros caracteres
    $ascii['b'] = array(223);
    $ascii['c'] = array(231);
    $ascii['d'] = array(208);
    $ascii['n'] = array(241);
    $ascii['y'] = array(253, 255);

    foreach ($ascii as $key => $item) {
        $acentos = '';
        foreach ($item AS $codigo)
            $acentos .= chr($codigo);
        $troca[$key] = '/[' . $acentos . ']/i';
    }

    $string = preg_replace(array_values($troca), array_keys($troca), $string);

    // Slug?
    if ($slug) {
        // Troca tudo que não for letra ou número por um caractere ($slug)
        $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
        $string = preg_replace(' ', '-', $string);
        // Tira os caracteres ($slug) repetidos
        $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
        $string = trim($string, $slug);
    }
    return $string;
}

function removeEspaco ($string) {
    $imagem = str_replace(' ', "", $string);
    return $imagem;
}

function criaSlug ($string) {
    $string = removeAcentos(strtolower($string));
    $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
    return (substr($slug, 0, 50));
}

function geralink () {
    return "http://" . $_SERVER['HTTP_HOST'] . "/paradouro/";
}

function geraSelectHtml ($tabela, $valor, $descricao, $id = '', $query = '') {
	$objSql = new sql();
	$strSelect = '';
    if ($tabela == 'usuario') {
        $valor = 'id';
        $descricao = 'nome';
        $strQuery = "SELECT 
                    u.id, f.nome
                    FROM usuario u
                    JOIN funcionario f ON (f.id = u.funcionario)
                    ORDER BY nome ASC";
    } else {
        $strQuery = "SELECT "
                    . $valor . ", " . $descricao .
                    " FROM " . $tabela . " "
                    . ($query ? $query : '') .
                    " ORDER BY " . $descricao . " ASC ";
    }

	$arrQuery = $objSql->executaQuery($strQuery);
	
	if ($arrQuery != '') {
		if ($id != '') {
			foreach ($arrQuery as $arrElemento) {
				$strSelect .= '<option value="' . $arrElemento[$valor] . '"' . ($id == $arrElemento[$valor] ? 'selected="selected"' : '') . '>' . $arrElemento[$descricao] . '</option>';
			}
		} else {
			foreach ($arrQuery as $arrElemento) {
				$strSelect .= '<option value="' . $arrElemento[$valor] . '">' . $arrElemento[$descricao] . '</option>';
			}
		}
	}

	return $strSelect;
}

function get_endereco($strData){

    $cep = preg_replace("/[^0-9]/", "", $strData);
    $url = "http://viacep.com.br/ws/$strData/xml/";
  
    $xml = simplexml_load_file($url);
    return $xml;
  }

function formatarData ($strData) {
    return implode('/', array_reverse(explode('-', $strData)));
}

function formatarHora($strData){
    $strValor = date("H:i ", strtotime($strData));

    return str_replace(":", "h", $strValor);
}

function pegaDiaSemana($strData){
    $diaSemana = getdate(strtotime($strData));
    $diaS = '';
    switch($diaSemana['wday']){
        case 0:
            $diaS = 'Domingo';
        break;
        case 1:
            $diaS = 'Segunda';
        break;
        case 2:
            $diaS = 'Terça';
        break;
        case 3:
            $diaS = 'Quarta';
        break;
        case 4:
            $diaS = 'Quinta';
        break;
        case 5:
            $diaS = 'Sexta';
        break;
        case 6:
            $diaS = 'Sábado';
        break;
        default:
        break;
    }

    return $diaS;
}

function pegaAno($strData){
    $ano = getdate(strtotime($strData));

    return $ano['year'];
}

function pegaDia($strData){
    $dia = getdate(strtotime($strData));

    return $dia['mday'];
}

function pegaMes($strData){
    $mes = getdate(strtotime($strData));
    $rMes = '';
    switch($mes['mon']){
        case 1:
            $rMes = 'Jan';
        break;
        case 2:
            $rMes = 'Fev';
        break;
        case 3:
            $rMes = 'Mar';
        break;
        case 4:
            $rMes = 'Abr';
        break;
        case 5:
            $rMes = 'Mai';
        break;
        case 6:
            $rMes = 'Jun';
        break;
        case 7:
            $rMes = 'Jul';
        break;
        case 8:
            $rMes = 'Ago';
        break;
        case 9:
            $rMes = 'Set';
        break;
        case 10:
            $rMes = 'Out';
        break;
        case 11:
            $rMes = 'Nov';
        break;
        case 12:
            $rMes = 'Dez';
        break;
        default:
        break;
    }
    return $rMes;
}

function formatarValor ($strValor) {
    return number_format($strValor,2,",",".");
}

function formatarStringTraco ($strValor){
    $strValor = str_replace("-", " ", $strValor);
    return $strValor;
}

function formatarStringCapitalize($strValor){
    return ucwords($strValor);
}

function primeiraCapitalize($strValor){
    return ucfirst($strValor);
}

function geranomeimagem($nome, $altera = '') {
    $arrimagem = explode('.', $nome);
    $extensao = $arrimagem[count($arrimagem) - 1];
    unset($arrimagem[count($arrimagem) - 1]);
    $nome = "";
    if ($altera == 1) {
        return date('YmdHis') . '.' . $extensao;
    } else {
        foreach ($arrimagem as $toknome) {
            $nome .= $toknome;
        }
        return (substr(criaSlug($nome . '-' . mt_rand (0, 9999999999)), 0, 90) . '.' . $extensao);
    }
}

function isEmpty($var) {
    return (isset($var) && $var != '');
}

function limitarString($intLimite, $strString) 
{
    $strString = strip_tags($strString);
    return ((strlen($strString) <= $intLimite) ? $strString : substr($strString, 0, ($intLimite - 3)) . '...');
}

function resumo($string, $chars) {
    if (strlen($string) > $chars)
        return substr($string, 0, $chars).'...';
    else
        return $string;
}

function validaMenu($strAcao){
    $objSql = new sql();
    $arrPermissaoMenu = array();
    $query2 = "SELECT
            p.id,
            p.usuario,
            p.direitos,
            d.acao
            FROM permissao p INNER JOIN direitos d ON (d.id = p.direitos)
            WHERE p.usuario = " .  $_SESSION['usuario'];
    $dadospermissao = $objSql->executaQuery($query2);
    foreach($dadospermissao as $X){
     $arrPermissaoMenu[] = $X['acao'];   
    }
    if(!in_array($strAcao, $arrPermissaoMenu)){
        return 'false';
    } else {
        return 'true';
    }
}

function validaMenuSite($strAcao){
    $objSql = new sql();
    $arrPermissao = array();
    $query = "SELECT 
            m.menu as site_menu, p.menu 
            FROM permissao_site p LEFT JOIN menu_site m ON (p.menu = m.id)";
    
    $permissao = $objSql->executaQuery($query);
    foreach($permissao as $resultado){
        $arrPermissao[] = $resultado['site_menu'];
    }
    if(!in_array($strAcao, $arrPermissao)){
        return false;
    }else{
        return true;
    }
}

?>
