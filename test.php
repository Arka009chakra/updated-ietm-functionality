<?php include 'config.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <label>Sections</label><br>
    <select id="user">
        <option value=""></option>
        <?php
        $query = "SELECT name FROM `bomtree`;";
        $res = mysqli_query($conn, $query);
        if ($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                echo "<option>" . $row['name'] . "</option>";
            }
        }
        ?>
    </select>
    <button onclick="Check()">Check The Clicked Section</button>
    <script>
        function Check() {
            const x = document.getElementById("user").value;
            alert("Clicked Section:" + x);
        }
    </script>
    
</body>

</html>