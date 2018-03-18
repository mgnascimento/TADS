<?php
/**
 * Created by PhpStorm.
 * User: aluno
 * Date: 16/03/2018
 * Time: 21:17
 */

require_once "conexao.php";
require_once "classes/aluno.php";

class alunoDAO
{

    public function remover($aluno){
        global $pdo;
        try {
            $statement = $pdo->prepare("DELETE FROM aluno WHERE idAluno = :id");
            $statement->bindValue(":id", $aluno->getIdAluno());
            if ($statement->execute()) {
                echo "Registo foi excluído com êxito";
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            echo "Erro: ".$erro->getMessage();
        }
    }

    public function salvar($aluno){
        global $pdo;
        try {
            if ($aluno->getIdAluno() != "") {
                $statement = $pdo->prepare("UPDATE aluno SET Nome=:nome, Matricula=:matricula  WHERE idAluno = :id;");
                $statement->bindValue(":id", $aluno->getIdAluno());
            } else {
                $statement = $pdo->prepare("INSERT INTO Aluno (Matricula, Nome) VALUES (:matricula, :nome)");
            }
            $statement->bindValue(":nome",$aluno->getNome());
            $statement->bindValue(":matricula",$aluno->getMatricula());

            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    echo "Dados cadastrados com sucesso!";
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

    public function atualizar($aluno){
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT idAluno, Nome, Matricula FROM Aluno WHERE idAluno = :id");
            $statement->bindValue(":id", $aluno->getidAluno());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $aluno->setidAluno($rs->idAluno);
                $aluno->setNome($rs->Nome);
                $aluno->setMatricula($rs->Matricula);
                return $aluno;
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            echo "Erro: ".$erro->getMessage();
        }
    }

}