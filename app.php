<?php

class Conexao{
    private $host = 'localhost';
    private $dbname = 'dashboard';
    private $user = 'root';
    private $pass = '';

    function conectar(){
        try {
            $conexao = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname",
                "$this->user",
                "$this->pass",
            );

            $conexao->exec("set charset utf8");

            return $conexao;
        } catch (PDOExecption $e) {
            echo"Tem parada errada ai";
        }
    }
}

class Dashboard{
    public $data_inicio;
    public $data_fim;
    public $total_vendas;
    public $numero_vendas;

    public function __get($attr){
        return $this->$attr;
    }

    public function __set($attr1, $attr2){
        $this->$attr1 = $attr2;
    }
}

class Service{
    private $conexao;
    private $dashboard;

    public function __construct($conexao, $dashboard){
        $this->conexao = $conexao->conectar();
        $this->dashboard = $dashboard;
    }

    public function GetNumeroVendas(){
        $query = "
        select
            count(*) as numero_vendas
        from
            tb_vendas
        where
            data_venda between :data_inicio and :data_fim;
        ";

        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(":data_inicio", "2018-10-01");
        $stmt->bindValue(":data_fim", "2018-10-31");
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ)->numero_vendas;
    }

    public function GetTotalVendas(){
        $query = "
        select
            sum(total) as numero_vendas
        from
            tb_vendas
        where
            data_venda between :data_inicio and :data_fim;
        ";

        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(":data_inicio", "2018-10-01");
        $stmt->bindValue(":data_fim", "2018-10-31");
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ)->numero_vendas;
    }
}

$dashboard = new Dashboard();
$conexao = new Conexao();
$service = new Service($conexao, $dashboard);

$dashboard->__set("data_inicio", "2018-10-01");
$dashboard->__set("data_fim", "2018-10-31");
$dashboard->__set("numero_vendas", $service->GetNumeroVendas());
$dashboard->__set("total_vendas", $service->GetTotalVendas());

print_r($dashboard);
?>