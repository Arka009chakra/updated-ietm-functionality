<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <input type="text" placeholder="Enter Username" id="t1"/>
    <input type="password" placeholder="Enter Password" id="t2"/></br>
    
    <?php
    include 'config.php';
    $query = "SELECT id, name FROM discipline";
    $res = mysqli_query($conn, $query);

    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            echo '<input type="checkbox" class="t3" value="'.$row['id'].'"/> ' . $row['name'] . '<br>';
        }
    }
    ?>
    <button onclick="create()">Create User</button>
</body>
<script>
    function create() {
        const y = document.getElementById("t1").value;
        const z = document.getElementById("t2").value;
    const x = [];
    const checkboxes = document.querySelectorAll('.t3:checked'); 
    checkboxes.forEach(item => x.push(item.value)); 
    const data={
       user:y,
       psw:z,
       access : x.join(",")
    }
    console.log(data)
    fetch('createuserlogic.php',{
        method: 'POST',
        headers: {
            'Content-Type':'application/json',
        },
        body:JSON.stringify(data)

    })
    .then((res)=>res.text())
    .then((data1)=>{
            alert("success")
        })
        .catch((err)=>console.log("error"))
}
    </script>
</html>
