<html lang="utf8">
<head>
    <title>Лабораторная работа №2</title>
</head>
<body>
<?php
$server = 'localhost';
$username = 'root';
$password = '1111';
$dbname = 'mydb';
$connect=mysqli_connect($server,$username,$password,$dbname);
mysqli_select_db($connect,$dbname);
echo '<h3>Параметры создания ведомости</h3>
        <form method="POST">
        Укажите год: 
        <select name="year">';
$query_text = 'SELECT distinct year(date_of_purchase) AS year FROM clients';
$result = mysqli_query($connect, $query_text);
$count = mysqli_num_rows($result);
for ($i=0;$i<$count;$i++){
    $row=mysqli_fetch_assoc($result);
    if ($i==0)  echo '<option selected="selected" value="'.$row['year'].'">'.$row['year'].'</option>';
    else echo '<option value="'.$row['year'].'">'.$row['year'].'</option>';
}

echo '</select><br><br>
        <input type="submit" value="Создать ведомость" name="submit">
        </form>';


if (isset($_POST['submit'])){
    $year = $_POST['year'];
    $total = 0;
    $query_text =  'SELECT name_firm, model_name
FROM clients
         INNER JOIN price_list
                    ON clients.id_model = price_list.id
         INNER JOIN models
                    ON price_list.id = models.id
         INNER JOIN providers_has_models
                    ON providers_has_models.models_id_model = models.id
         INNER JOIN providers
                    ON providers_has_models.providers_id_firm = providers.id
WHERE YEAR(date_of_purchase) = '.$year.';';
    $result1 = mysqli_query($connect, $query_text);
    $count = mysqli_num_rows($result1);
    if ($count!=0){
        echo '<h3>Отчет о продаже автомобилей за '.$year.' год</h3>';
        while($row1=mysqli_fetch_assoc($result1)){
            $sum = 0;
            $query_text =  'SELECT name_firm, model_name, price, presale_preparation, transport_costs,
       price + transport_costs + presale_preparation as Total_cost
FROM clients
         INNER JOIN price_list
                    ON clients.id_model = price_list.id
         INNER JOIN models
                    ON price_list.id = models.id
         INNER JOIN providers_has_models
                    ON providers_has_models.models_id_model = models.id
         INNER JOIN providers
                    ON providers_has_models.providers_id_firm = providers.id
WHERE YEAR(date_of_purchase) = '.$year.' AND name_firm="'.$row1['name_firm'].'";';
            $result = mysqli_query($connect, $query_text);
            if ($result){
                echo '<table border="1">';
                echo '<tr><td >Название фирмы</td><td >Наименование модели</td><td>Цена</td><td>Предпродажная подготовка</td><td>Транспортные издержки</td><td>Стоимость</td></tr>';
                $count = mysqli_num_rows($result);
                for ($i=0;$i<$count;$i++){
                    $row=mysqli_fetch_assoc($result);
                    echo '<tr align = center>';
                    echo '<td style="background-color:#A9A9A9;">',$row['name_firm'],'</td><td style="background-color:#A9A9A9;">',$row['model_name'],'</td><td style="background-color:#A9A9A9;">',$row['price'],'</td><td style="background-color:#A9A9A9;">',$row['presale_preparation'],'</td><td style="background-color:#A9A9A9;">',$row['transport_costs'],'</td><td style="background-color:#3CB371;">',$row['Total_cost'],'</td>';
                    echo '</tr>';
                    $sum += $row['Total_cost'];
                }
                echo '</table>';
                echo '<p>Название фирмы ',$row1['name_firm'],'<br>';
                echo '<p style="font-weight: bold">Итого по фирме: '.$sum.'</p>';
                $total += $sum;
            }
        }
        echo '<p style="font-weight: bold">Итого_______________________________________________________________________________: '.$total.'</p>';
    }
}
?>
</body>
</html>