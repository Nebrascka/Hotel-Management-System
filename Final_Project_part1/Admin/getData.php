<?php require_once('../db/db.php') ?>

<?php
    function getMonths() {
        $pdo = establishCONN(); 
        $stmt = $pdo->prepare("SELECT created_on FROM applications GROUP BY MONTH(`created_on`)");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getApls($num) {
        $pdo = establishCONN(); 
        $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM applications WHERE MONTH(`created_on`) = :num");
        $stmt->bindValue(':num', $num);

        $res = $stmt->execute();
        // var_dump($res);
        // $stmt->fetch(PDO::FETCH_ASSOC);

        return $stmt->fetch(PDO::FETCH_ASSOC);;
    }

    //var_dump(getApls(03));

    function generateDataset() {
        $dataset = [];
        $months = getMonths();

        //var_dump($months);
        //echo "<br>";
        foreach($months as $month) {
            $m = explode("-", $month["created_on"])[1];
            //var_dump($m);
            $count = getApls((int)$m);
            //echo "<br>";
            //var_dump($count["count"]);
            array_push($dataset, $count["count"]);
        }
        //echo "<pre>";
        //var_dump($dataset);
        //echo "</pre>";

        return $dataset;
    }

    if($_SERVER["REQUEST_METHOD"] === "GET") {
      $months = [];
      $m = getMonths();

      foreach($m as $i) {
         $j = explode("-", $i["created_on"])[1];
         array_push($months, $j);
      }

      echo json_encode(array("months" => $months, "map" => generateDataset()));
    }
?>