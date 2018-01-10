<?php
/**
 * Created by PhpStorm.
 * User: tassio
 * Date: 09/01/2018
 * Time: 20:02
 */

class instituicao {

    private $idInstituicao;
    private $Nome;
    private $Sigla;

    public function getidInstituicao() {
        return $this->idInstituicao;
    }

    public function setidInstituicao($idInstituicao) {
        $this->idInstituicao = $idInstituicao;
    }

    public function getNome() {
        return $this->Nome;
    }

    public function setNome($Nome) {
        $this->Nome = $Nome;
    }

    public function getSigla() {
        return $this->Sigla;
    }

    public function setSigla($Sigla) {
        $this->Sigla = $Sigla;
    }


    public function remover($id){
        global $pdo;
        $this->setidInstituicao($id);
        try {
            $statement = $pdo->prepare("DELETE FROM Instituicao WHERE idInstituicao = :id");
            $statement->bindValue(":id", $this->getidInstituicao());
            if ($statement->execute()) {
                echo "Registo foi excluído com êxito";
                $id = null;
                $nome = null;
                $cargo = null;
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            echo "Erro: ".$erro->getMessage();
        }
    }

    public function salvar($id, $nome, $sigla){
        global $pdo;
        $this->setidInstituicao($id);
        $this->setNome($nome);
        $this->setSigla($sigla);
        try {

            if ($this->getidInstituicao() != "") {
                $statement = $pdo->prepare("UPDATE Instituicao SET Nome=:nome, Sigla=:sigla  WHERE idInstituicao = :id;");
                $statement->bindValue(":id", $this->getidInstituicao());
            } else {
                $statement = $pdo->prepare("INSERT INTO Instituicao (Nome, Sigla) VALUES (:nome, :sigla)");
            }
            $statement->bindValue(":nome",$this->getNome());
            $statement->bindValue(":sigla",$this->getSigla());

            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    echo "Dados cadastrados com sucesso!";
                    $id = null;
                    $nome = null;
                    $cargo = null;
                } else {
                    echo "Erro ao tentar efetivar cadastro";
                }
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            echo "Erro: " . $erro->getMessage();
        }
    }

    public function atualizar($id){
        global $pdo;
        $this->setidInstituicao($id);
        try {
            $statement = $pdo->prepare("SELECT idInstituicao, Nome, Sigla FROM Instituicao WHERE idInstituicao = :id");
            $statement->bindValue(":id", $this->getidInstituicao());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $this->setidInstituicao($rs->idInstituicao);
                $this->setNome($rs->Nome);
                $this->setSigla($rs->Sigla);
                return $this;
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            echo "Erro: ".$erro->getMessage();
        }
    }

    public function tabelapaginada() {

        //carrega o banco
        global $pdo;

        //endereço atual da página
        $endereco = $_SERVER ['PHP_SELF'];

        /* Constantes de configuração */
        define('QTDE_REGISTROS', 3);
        define('RANGE_PAGINAS', 1);

        /* Recebe o número da página via parâmetro na URL */
        $pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;

        /* Calcula a linha inicial da consulta */
        $linha_inicial = ($pagina_atual -1) * QTDE_REGISTROS;

        /* Instrução de consulta para paginação com MySQL */
        $sql = "SELECT idInstituicao, Nome, Sigla FROM Instituicao LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM Instituicao";
        $statement = $pdo->prepare($sqlContador);
        $statement->execute();
        $valor = $statement->fetch(PDO::FETCH_OBJ);

        /* Idêntifica a primeira página */
        $primeira_pagina = 1;

        /* Cálcula qual será a última página */
        $ultima_pagina  = ceil($valor->total_registros / QTDE_REGISTROS);

        /* Cálcula qual será a página anterior em relação a página atual em exibição */
        $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual -1 : 0 ;

        /* Cálcula qual será a pŕoxima página em relação a página atual em exibição */
        $proxima_pagina = ($pagina_atual < $ultima_pagina) ? $pagina_atual +1 : 0 ;

        /* Cálcula qual será a página inicial do nosso range */
        $range_inicial  = (($pagina_atual - RANGE_PAGINAS) >= 1) ? $pagina_atual - RANGE_PAGINAS : 1 ;

        /* Cálcula qual será a página final do nosso range */
        $range_final   = (($pagina_atual + RANGE_PAGINAS) <= $ultima_pagina ) ? $pagina_atual + RANGE_PAGINAS : $ultima_pagina ;

        /* Verifica se vai exibir o botão "Primeiro" e "Pŕoximo" */
        $exibir_botao_inicio = ($range_inicial < $pagina_atual) ? 'mostrar' : 'esconder';

        /* Verifica se vai exibir o botão "Anterior" e "Último" */
        $exibir_botao_final = ($range_final > $pagina_atual) ? 'mostrar' : 'esconder';

        if (!empty($dados)):
echo "
     <table class='table table-striped table-bordered'>
     <thead>
       <tr class='active'>
        <th>Código</th>
        <th>Nome</th>
        <th>Sigla</th>
        <th colspan='2'>Ações</th>
       </tr>
     </thead>
     <tbody>";
       foreach($dados as $inst):
       echo "<tr>
        <td>$inst->idInstituicao</td>
        <td>$inst->Nome</td>
        <td>$inst->Sigla</td>
        <td><a href='?act=upd&id=$inst->idInstituicao'><i class='ti-reload'></i></a></td>
        <td><a href='?act=del&id=$inst->idInstituicao'><i class='ti-close'></i></a></td>
       </tr>";
        endforeach;
     echo"
</tbody>
     </table>

     <div class='box-paginacao'>
       <a class='box-navegacao  $exibir_botao_inicio' href='$endereco?page=$primeira_pagina' title='Primeira Página'>Primeira</a>
       <a class='box-navegacao $exibir_botao_inicio' href='$endereco?page=$pagina_anterior' title='Página Anterior'>Anterior</a>
";

      /* Loop para montar a páginação central com os números */
      for ($i=$range_inicial; $i <= $range_final; $i++):
        $destaque = ($i == $pagina_atual) ? 'destaque' : '' ;
        echo "<a class='box-numero $destaque' href='$endereco?page=$i'>$i</a>";
      endfor;

       echo "<a class='box-navegacao $exibir_botao_final' href='$endereco?page=$proxima_pagina' title='Próxima Página'>Próxima</a>
       <a class='box-navegacao $exibir_botao_final' href='$endereco?page=$ultima_pagina' title='Última Página'>Último</a>
     </div>";
    else:
     echo "<p class='bg-danger'>Nenhum registro foi encontrado!</p>
     ";
    endif;

    }

}


