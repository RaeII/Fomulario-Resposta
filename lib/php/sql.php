<?php

class sql {

    //construtor abre conexão banco
	
    public function __construct($login = '', $base = '', $endereco = '', $senha = '')
    {
        if($login != ''){
            $this->login = $login;
            $this->senha = $senha;
            $this->base = $base;
            $this->endereco = $endereco;
        } else {
            $this->login = 'root';
            $this->senha = '';
            $this->base = 'sugestaoprime';
            $this->endereco = 'localhost';
        }
    } 
    
    /*sql($login = 'root', $base = 'paradour_promoter', $endereco = 'localhost', $senha = "") {
        $this->login = $login;
        $this->senha = $senha;
        $this->base = $base;
        $this->endereco = $endereco;
    }*/

    function executaQuery($query, $retorno = "") {
        $objMysql = new mysqli($this->endereco, $this->login, $this->senha, $this->base);
        $objMysql->set_charset('utf8');

        if ($objMysql->connect_errno) {
            return FALSE;
        }

        $arrresultados = array();
        $objResult = $objMysql->query($query);
        if ($retorno != 2) {
            if ($objResult) {
                if ($retorno == 1) {
                    $retorno = $objResult->num_rows;
                } else {
                    $contador = 0;
                    $objResult->data_seek(0);
                    while ($row = $objResult->fetch_assoc()) {
                        $temp = "";
                        foreach ($row as $chave => $valor) {
                            if (!is_numeric($chave)) {
                                $temp[$chave] = $valor;
                            }
                        }
                        $retorno[$contador] = $temp;
                        $contador ++;
                    }
                }
            }
        }
        $objMysql->close();

        return $retorno;
    }

    function executaInsert($campos, $tabela, $tipo = "", $debug = "") {
        //$mysqli = mysqli_connect($this->endereco, $this->login, $this->senha, $this->base);
        $objMysql = new mysqli($this->endereco, $this->login, $this->senha, $this->base);
        $objMysql->set_charset('utf8');

        if ($objMysql->connect_errno) {
            return FALSE;
        }

        $varcampos = "";
        $varvalores = "";

        foreach ($campos as $chave => $valor) {
            if ($valor != "") {
                $varcampos .= "," . $chave;
                $varvalores .= ",'" . $valor . "'";
            }
        }
         //elimina o primeiro caractere e adiciona parenteses nas extremas
        $varcampos = "(" . substr($varcampos, 1, strlen($varcampos)) . ")";
        $varvalores = "(" . substr($varvalores, 1, strlen($varvalores)) . ")";
        $query = "INSERT INTO " . $tabela . " " . $varcampos . " VALUES " . $varvalores;
        $objResult = $objMysql->query($query);
        if ($debug == 1) {
            var_dump($query);exit;
        }
        if ($objResult) {
            if ($tipo == 1) {
                $objResult = $objMysql->query("SELECT LAST_INSERT_ID()");
                $objResult->data_seek(0);
                $data = $objResult->fetch_assoc();
                $retorno = $data["LAST_INSERT_ID()"];
            } else {
                $retorno = TRUE;
            }
        } else {
            $retorno = FALSE;
        }

        $objMysql->close();
        return $retorno;
    }

    function executaUpdate($campos, $tabela, $chaveupdt) {
        $objMysql = new mysqli($this->endereco, $this->login, $this->senha, $this->base);
        $objMysql->set_charset('utf8');

        if ($objMysql->connect_errno) {
            return FALSE;
        }

        $strupdate = "";

        foreach ($campos as $chave => $valor) {
            $strupdate .= "," . $chave . "='" . $valor . "'";
        }

        $strupdate = substr($strupdate, 1, strlen($strupdate));
        $query = "UPDATE " . $tabela . " SET " . $strupdate . " WHERE " . $chaveupdt . " = " . $campos[$chaveupdt];
        $objResult = $objMysql->query($query);
        if ($objResult) {
            $retorno = TRUE;
        } else {
            $retorno = FALSE;
        }

        $objMysql->close();
        return $retorno;
    }

    function executaDelete($id, $tabela, $chave = "") {
        $retorno = "";
        $objMysql = new mysqli($this->endereco, $this->login, $this->senha, $this->base);
        $objMysql->set_charset('utf8');

        if ($objMysql->connect_errno) {
            return FALSE;
        }

        if ($chave != "") {
            $query = "DELETE FROM " . $tabela . " WHERE " . $chave . " = " . $id;
        } else {
            $query = "DELETE FROM " . $tabela . " WHERE ID = " . $id;
        }

        $objResult = $objMysql->query($query);

        $retorno = TRUE;
        $objMysql->close();
        return $retorno;
    }

    function loadItem($tabela, $valor, $chave) {
        $retorno = "";
        $objMysql = new mysqli($this->endereco, $this->login, $this->senha, $this->base);
        $objMysql->set_charset('utf8');

        if ($objMysql->connect_errno) {
            return FALSE;
        }

        $query = "SELECT * FROM " . $tabela . " WHERE " . $chave . " = '" . $valor . "' ";
        $objResult = $objMysql->query($query);
        $records = $objResult->num_rows;
        if ($records > 0) {
            $objResult->data_seek(0);
            $arr = $objResult->fetch_assoc();
            foreach ($arr as $chave => $valor) {
                if (!is_numeric($chave)) {
                    $retorno[$chave] = $valor;
                }
            }
        } elseif ($records == 0) {
            $retorno = false;
        }

        $objMysql->close();
        return $retorno;
    }

    function validalogin($post) {
        $retorno = false;
        $post = $this->prevent_injection($post);
        if (($post["login"] != "") && ($post["senha"] != "")) {
            $query = "SELECT
	        			id,
	        			nome
        			FROM usuario 
        			WHERE login = '" . $post["login"] . "' 
        			AND senha = '" . md5($post["senha"]) . "' ";
            $dadosusuario = $this->executaQuery($query);

           

            if (isset($dadosusuario[0]["id"]) && $dadosusuario[0]["id"] != '') {
                $_SESSION['usuario'] = $dadosusuario[0]['id'];
                $_SESSION['nome'] = $dadosusuario[0]['nome'];



                $retorno = true;
            }
        }

        return $retorno;
    }

    function fechaConexao() {
        
    }

    public function listar($tabela, $campoOrdem = 'id', $tipoOrdem = 'ASC', $tipo = '1', $pagina = '1', $query = '') {
        $strQuery = '';
        $strLimite = '';
        $intIndice = 1;
        $intLimite = 0;

        if ($tipo == 2) {
            if ($pagina > 0) {
                for ($intIndice = 0; $intIndice <= $pagina; $intIndice ++) {
                    $intLimite += 15;
                }
            }
            $strLimite = ' LIMIT ' . ($intLimite - 15) . ', ' . $intLimite;
        }

        $strQuery = "SELECT * FROM " . $tabela . " ORDER BY " . $campoOrdem . " " . $tipoOrdem . " " . $strLimite;
        return $this->executaQuery($strQuery);
    }

    public function listaCamposTabela($tabela) {
        $arrCampos = array();
        $strQuery = "SHOW COLUMNS FROM " . $tabela;
        $arrRetorno = $this->executaQuery($strQuery);
        if ($arrRetorno != '') {
            foreach ($arrRetorno as $arrItemRetorno) {
                $arrCampos[] = $arrItemRetorno['Field'];
            }
        }
        return $arrCampos;
    }

    public function geraSelect($tabela, $campoId = 'id', $campoText = 'descricao', $clausula = '', $indice = '') {
        $strQuery = "SELECT "
                . $campoId . ","
                . $campoText .
                "FROM " . $tabela . " "
                . $clausula;

        return $this->executaQuery($strQuery);
    }

    public function getNumeroRegistroTabela($tabela, $strClausulaSql = '') {
        $arrResposta = $this->executaQuery("SELECT COUNT(1) AS 'quantidade' FROM " . $tabela . " " . $strClausulaSql);
        return $arrResposta[0]['quantidade'];
    }

    public function executaQueryPaginada($tabela, $paginaAtual, $acao, $campoOrdenacao, $tipoOrdem = 'DESC', $arquivo) {
        $intLimite = 0;
        $strHtmlPaginacao = '';

        for ($i = 1; $i <= $paginaAtual; $i++) {
            $intLimite += 10;
        }

        $arrResultado = $this->executaQuery(
            "SELECT
                    *
            FROM " . $tabela . " 
            ORDER BY " . $campoOrdenacao . " " . $tipoOrdem . " 
            LIMIT " . ($intLimite - 10) . ", 10"
        );


        $intNumeroTotalPagina = ceil(intval($this->getNumeroRegistroTabela($tabela, '')) / 10);

        if ($intNumeroTotalPagina > 1) {
            $strHtmlPaginacao = '<li class="paginate_button previous" id="datatable_previous">
                    <a href="' . $arquivo . '.php?acao=' . $acao . '&pagina=1">Primeiro</a>
                </li>';

            if ($paginaAtual > 1) {
                $strHtmlPaginacao .= '<li class="paginate_button previous" id="datatable_previous">
                        <a href="' . $arquivo . '.php?acao=' . $acao . '&pagina=' . ($paginaAtual - 1) . '">' . ($paginaAtual - 1) . '</a>
                    </li>';
            }

            $strHtmlPaginacao .= '<li class="paginate_button active" id="datatable_previous">
                    <a href="' . $arquivo . '.php?acao=' . $acao . '&pagina=' . $paginaAtual . '">' . $paginaAtual . '</a>
                </li>';

            for ($intI = $paginaAtual + 1; $intI <= $paginaAtual + 4; $intI ++) {
                if ($intI <= $intNumeroTotalPagina) {
                    $strHtmlPaginacao .= '<li class="paginate_button" id="datatable_previous">
                            <a href="' . $arquivo . '.php?acao=' . $acao . '&pagina=' . $intI . '">' . $intI . '</a>
                        </li>';
                }
            }

            $strHtmlPaginacao .= '<li class="paginate_button previous" id="datatable_previous">
                    <a href="' . $arquivo . '.php?acao=' . $acao . '&pagina=' . $intNumeroTotalPagina . '">Último</a>
                </li>';

            $strHtmlPaginacao = '<div class="row">
                    <div class="col-sm-5">&nbsp;</div>
                    <div class="col-sm-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
                            <ul class="pagination">' . $strHtmlPaginacao . '</ul>
                        </div>
                    </div>
                </div>';
        }

        return array('resultado' => $arrResultado, 'paginacao' => $strHtmlPaginacao);
    }
    
    public function executaQueryPaginada2 ($strQuery, $strUrlQuery, $paginaAtual, $acao, $campoOrdenacao, $tipoOrdem = 'DESC', $arquivo) {
        $intLimite = 0;
        $strHtmlPaginacao = '';

        for ($i = 1; $i<= $paginaAtual; $i++) {
            $intLimite += 10;
        }
        $arrResultado = $this->executaQuery($strQuery . " ORDER BY " . $campoOrdenacao . " " . $tipoOrdem . " LIMIT " . ($intLimite - 10) . ", 10");

        $intNumeroTotalPagina = ceil(intval(count($this->executaQuery($strQuery))) / 10);
        
        $strUrl = $arquivo . '.php?acao=' . $acao . '&' . $strUrlQuery;
        //var_dump($strUrlQuery);exit;

        if ($intNumeroTotalPagina > 1) {
            $strHtmlPaginacao =
                '<li class="paginate_button previous" id="datatable_previous">
                    <a href="' . $strUrl . '&pagina=1">Primeiro</a>
                </li>';

            if ($paginaAtual > 1) {
                $strHtmlPaginacao .=
                    '<li class="paginate_button previous" id="datatable_previous">
                        <a href="' . $strUrl . '&pagina=' . ($paginaAtual - 1) . '">' . ($paginaAtual - 1) . '</a>
                    </li>';
            }

            $strHtmlPaginacao .=
                '<li class="paginate_button active" id="datatable_previous">
                    <a href="#1">' . $paginaAtual . '</a>
                </li>';

            for ($intI = $paginaAtual + 1; $intI <= $paginaAtual + 4; $intI ++) {
                if ($intI <= $intNumeroTotalPagina) {
                    $strHtmlPaginacao .=
                        '<li class="paginate_button" id="datatable_previous">
                            <a href="' . $strUrl . '&pagina=' . $intI . '">' . $intI . '</a>
                        </li>';
                }
            }

            $strHtmlPaginacao .=
                '<li class="paginate_button previous" id="datatable_previous">
                    <a href="' . $strUrl . '&pagina=' . $intNumeroTotalPagina . '">Último</a>
                </li>';

            $strHtmlPaginacao =
                '<div class="row">
                    <div class="col-sm-5">&nbsp;</div>
                    <div class="col-sm-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
                            <ul class="pagination">' . $strHtmlPaginacao . '</ul>
                        </div>
                    </div>
                </div>';
        }

        return array('resultado' => $arrResultado, 'paginacao' => $strHtmlPaginacao);
    }

    public function executaQueryPaginadaDinamica ($strQuery, $strUrlQuery, $paginaAtual, $acao, $campoOrdenacao, $tipoOrdem = 'DESC', $arquivo, $itemPagina) {
        $intLimite = 0;
        $strHtmlPaginacao = '';

        for ($i = 1; $i<= $paginaAtual; $i++) {
            $intLimite += $itemPagina;
        }
        $arrResultado = $this->executaQuery($strQuery . " ORDER BY " . $campoOrdenacao . " " . $tipoOrdem . " LIMIT " . ($intLimite - $itemPagina) . ", ".$itemPagina);

        $intNumeroTotalPagina = ceil(intval(count($this->executaQuery($strQuery))) / $itemPagina);
        
        $strUrl = $arquivo . '.php?acao=' . $acao . '&' . $strUrlQuery;
        //var_dump($strUrlQuery);exit;

        if ($intNumeroTotalPagina > 1) {
            $strHtmlPaginacao =
                '<li class="paginate_button previous" id="datatable_previous">
                    <a href="' . $strUrl . '&pagina=1">Primeiro</a>
                </li>';

            if ($paginaAtual > 1) {
                $strHtmlPaginacao .=
                    '<li class="paginate_button previous" id="datatable_previous">
                        <a href="' . $strUrl . '&pagina=' . ($paginaAtual - 1) . '">' . ($paginaAtual - 1) . '</a>
                    </li>';
            }

            $strHtmlPaginacao .=
                '<li class="paginate_button active" id="datatable_previous">
                    <a href="#1">' . $paginaAtual . '</a>
                </li>';

            for ($intI = $paginaAtual + 1; $intI <= $paginaAtual + 4; $intI ++) {
                if ($intI <= $intNumeroTotalPagina) {
                    $strHtmlPaginacao .=
                        '<li class="paginate_button" id="datatable_previous">
                            <a href="' . $strUrl . '&pagina=' . $intI . '">' . $intI . '</a>
                        </li>';
                }
            }

            $strHtmlPaginacao .=
                '<li class="paginate_button previous" id="datatable_previous">
                    <a href="' . $strUrl . '&pagina=' . $intNumeroTotalPagina . '">Último</a>
                </li>';

            $strHtmlPaginacao =
                '<div class="row">
                    <div class="col-sm-5">&nbsp;</div>
                    <div class="col-sm-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
                            <ul class="pagination">' . $strHtmlPaginacao . '</ul>
                        </div>
                    </div>
                </div>';
        }

        return array('resultado' => $arrResultado, 'paginacao' => $strHtmlPaginacao);
    }

    function prevent_injection($arrData) {
        $objMysql = new mysqli($this->endereco, $this->login, $this->senha, $this->base);
        $objMysql->set_charset('utf8');

        foreach ($arrData as $mixIndice => $mixData) {
            // remove whitespaces from begining and end
            $mixData = trim($mixData);

            // apply stripslashes to pevent double escape if magic_quotes_gpc is enabled
            if (get_magic_quotes_gpc()) {
                $mixData = stripslashes($mixData);
            }
            // connection is required before using this function
            $mixData = mysqli_real_escape_string($objMysql, $mixData);

            $arrData[$mixIndice] = $mixData;
        }

        return $arrData;
    }

}
