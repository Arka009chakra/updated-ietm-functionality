<?php include 'config.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <label>Section</label><br>
    <Select id="user" onchange="fetchData()">
        <option value=""></option>
        <?php
            $query = "SELECT name FROM bomtree1;";
            $res = mysqli_query($conn,$query);
            if($res)
            {
                while($row=mysqli_fetch_assoc($res))
                {
                    echo "<option value='".$row['name']."'>".$row['name']."</option>";
                }
            }
        ?>
    </Select><br>
    <label>Auto Text</label><br>
    <input type="text" id="t1" />
    <button>Check</button>
</body>
<script>
    function fetchData()
    {
       const x = document.getElementById("user").value;
       
       fetch('addauto.php',{
        method: 'POST',
        headers: {
            'Content-Type':'application/json',
        },
        body: JSON.stringify({check:x})
       })
       .then(res=> res.json())
       .then((data)=>{
        console.log(data)
        document.getElementById("t1").value = data;
       })
       .catch((err)=>console.log("error"))
    }
</script>
</html>