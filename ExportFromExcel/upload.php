<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Excel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <table class="table table-striped" name="userTable" id="userTable">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Surname</th>
                <th scope="col">Age</th>
                <th scope="col">Gender</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once 'connect.php';
            require 'PHPExcel.php';
            if ($_POST) {
                $fileName = $_FILES['excelFile']['name'];
                $tmpName = $_FILES['excelFile']['tmp_name'];
                $type = $_FILES['excelFile']['type'];

                if ($fileName && $type && $tmpName) {
                    $extension = array(
                        'application/xlsx',
                        'application/xls',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'application/vnd.ms-excel'
                    );

                    if (in_array($type, $extension)) //eğer yüklenen dosyanın tipi bu uzantılarda varsa
                    {
                        $excel = PHPExcel_IOFactory::load($tmpName);
                        foreach ($excel->getWorksheetIterator() as $row) {
                            $excelRowNumber = $row->getHighestRow(); //excel row sayısı
                            for ($i = 1; $i <= $excelRowNumber; $i++) {
                                $name = $row->getCellByColumnAndRow(0, $i)->getValue(); //0.sütun i. row
                                $surname = $row->getCellByColumnAndRow(1, $i)->getValue();
                                $age = $row->getCellByColumnAndRow(2, $i)->getValue();
                                $gender = $row->getCellByColumnAndRow(3, $i)->getValue();
                                $html='<tr>
                                    <td id="name'.$i.'">'.$name.'</th>
                                    <td id="surname'.$i.'">'.$surname.'</td>
                                    <td id="age'.$i.'">'.$age.'</td>
                                    <td id="gender'.$i.'">'.$gender.'</td>
                                </tr>';
                                echo $html;
                            }
                            
                            
                        }
                    } else {
                        echo "Extension did not match!";
                    }
                }
            }
            ?>
            
        </tbody>
    </table>
    <button type="button" name="insertDatabase" id="insertDatabase" onclick="insertDatabase()">DB'ye Ekle</button>
    
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<script>
    function insertDatabase() {
        var rowCount = document.getElementById('userTable').rows.length;
        console.log("rowCount : ",rowCount);
        for(i=1;i<rowCount;i++)
        {
            var name = document.getElementById('name'+i).innerText;
            var surname = document.getElementById('surname'+i).innerText;
            var age = document.getElementById('age'+i).innerText;
            var gender = document.getElementById('gender'+i).innerText;
            console.log('name : ',name);
            console.log('surname : ',surname);
            console.log('age : ',age);
            console.log('gender : ',gender);
            jQuery.ajax({
                type : "POST",
                url : "insertDatabase.php",
                data : {name : name, surname : surname, age : age, gender : gender},
                success:function(result){
                   console.log("Result : ",result);
                }
            });          
        }
    }
</script>
</html>