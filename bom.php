<?php
include 'config.php';

$query = "SELECT id, name FROM bomtree1 WHERE parentid = '0';";
$res = mysqli_query($conn, $query);

echo "<ul>";
while ($row = mysqli_fetch_array($res)) {
    echo "<li>";
    echo "<details>";
    echo "<summary data-id='{$row['id']}' class='bom-tree'  data-name='{$row['name']}' onclick='showcontent({$row['id']})' style='cursor:pointer'>" . htmlspecialchars($row['name']) . "</summary>";
    
    render($conn, $row['id']);
    
    echo "</details>";
    echo "</li>";
}
echo "</ul>";

function render($conn, $id)
{
    $query1 = "SELECT id, name FROM bomtree1 WHERE parentid = '$id';";
    $res1 = mysqli_query($conn, $query1);

    echo "<ul>";
    while ($row1 = mysqli_fetch_array($res1)) {
        echo "<li>";
        echo "<details>";
        echo "<summary data-id='{$row1['id']}' class='bom-tree'  data-name='{$row1['name']}' onclick='showcontent({$row1['id']})' style='cursor:pointer'>" . htmlspecialchars($row1['name']) . "</summary>";
        $child=getaccessById($conn,$row1['id']);
    if($child)
    {
        render($conn, $row1['id']);
    }
        echo "</details>";
        echo "</li>";
    }
    echo "</ul>";
}
function getaccessById($conn,$id)
{
    
    $query2="SELECT access,name FROM user WHERE name = 'arka';";
    $res2=mysqli_query($conn,$query2);
    if($res2)
    {
        while($row2=mysqli_fetch_array($res2))
        {
        $accesslist = explode(",", $row2['access']);
        if(in_array($id,$accesslist))
        {
            
            return true;
            
        }
        else{
            
            return false; 
            
        }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .highlighted {
            background-color: yellow;
            /* For example, highlight with a yellow background */
            border: 2px solid red;
            /* Optional border for further emphasis */
        }
    </style>
</head>

<body>
    <p>
     <?php
     session_start();
      include 'config.php';
      $query="SELECT name FROM user;";
      $res=mysqli_query($conn,$query);
      if($res)
      {
        while($row=mysqli_fetch_array($res))
        {
        
        echo "<p>User:" . $row['name'] . "</p>";
        }
      }
     ?>   
    </p>
    <input type="text" id="t1" placeholder="search" />
    <button onclick="search()">search</button>
    <button onclick="bookmarkadd()">bookmarkadd</button>
    <button onclick="bookmarkview()">bookmarkview</button>
    <div id="output"></div><br>
    <div id="content1"></div>
    <button onclick="addnote()">add note</button>
    <input type="text" id="t2" placeholder="Selected Text" />
    <input type="text" id="t3" placeholder="Enter Text" />
</body>
<script>
    let breadcrumbtext;
    function bookmarkadd() {
        fetch('addbookmark.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    id: globalid
                })
            })
            .then((res) => res.text())
            .then((data) => {
                alert("bookmark added successfully!!!!")
            })
            .catch((err) => console.log("error"))
    }


    function bookmarkview() {
        fetch('viewbookmark.php', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then((res => res.json()))
            .then((data) => {
                const ids = data.map(item => item["id"]);
                expandparticularwithid(ids)
                const targets = document.querySelectorAll('.bom-tree');
                targets.forEach(target => {
                    const targetId = target.getAttribute('data-id');

                    if (ids.includes(targetId)) {
                        target.classList.add('highlighted');
                    } else {
                        target.classList.remove('highlighted');
                    }

                })
            })
            .catch((err) => console.log("error"))
    }






    let globalid;

    function showcontent(id) {
    fetch('content.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: id }),
    })
    .then(res => res.json())
    .then(data => {
        console.log(data)
        document.querySelectorAll('.bom-tree').forEach(target => {
            target.classList.toggle('highlighted', target.getAttribute('data-id') == id);
        });

        globalid = id;
        breadcrumb(id);
        document.getElementById("content1").innerHTML = data.content;
    })
    .catch(err => console.log("Error:", err));
}


    function search() {
        const searchterm = document.getElementById('t1').value;
        const names = document.querySelectorAll('.bom-tree');
        expand(searchterm); // Call the expand function before checking names
        names.forEach((name) => {
            const checksearchterm = name.getAttribute('data-name');
            if (checksearchterm.includes(searchterm)) {
                console.log("found");
                name.classList.add('highlighted')
            }
        });
    }

    function expand(searchterm) {
        const nodes = document.querySelectorAll('.bom-tree');
        const detailsElements = document.querySelectorAll('details');
        detailsElements.forEach((detail) => {
            detail.removeAttribute('open');
        });
        nodes.forEach((node) => {
            const checksearchterm = node.getAttribute('data-name');
            if (checksearchterm && checksearchterm.includes(searchterm)) {
                let current = node;
                while (current) {


                    const parent = current.closest('details');
                    if (parent) {
                        parent.setAttribute('open', 'true');
                        current = parent.parentElement;
                    } else {
                        current = null;
                    }
                }
            }
        });
    }




    function expandparticularwithids(ids) {
        const nodes = document.querySelectorAll('.bom-tree');
        const detailsElements = document.querySelectorAll('details');
        detailsElements.forEach((detail) => {
            detail.removeAttribute('open');
        });
        nodes.forEach((node) => {
            const checksearchterm = node.getAttribute('data-id');
            ids.forEach(id => {
                if (checksearchterm == id) {
                    let current = node;
                    while (current) {


                        const parent = current.closest('details');
                        if (parent) {
                            parent.setAttribute('open', 'true');
                            current = parent.parentElement;
                        } else {
                            current = null;
                        }
                    }
                }
            });
        });
    }
    let breadcrumb1 = [];

function breadcrumb(id) {
    console.log("enter")
    fetch('crumb.php', {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: id })
    })
    .then(res => res.json())
    .then(data => {
        breadcrumb1 = data;
        console.log("breadcrumb1", breadcrumb1);
        document.getElementById("output").innerHTML = data
            .map(item => `<span style="cursor:pointer; color:blue; text-decoration:underline;" 
            onclick="removebreadcrumb(${item.id})">${item.name}</span>`)
            .join(" > ");
    })
    .catch(err => console.log("Error:", err));
}

function removebreadcrumb(id1) {
    let index = breadcrumb1.findIndex(item => item.id == id1);
    if (index !== -1) {
        breadcrumb1 = breadcrumb1.slice(0, index + 1);
    }
    document.getElementById("output").innerHTML = breadcrumb1
        .map(item => `<span style="cursor:pointer; color:blue; text-decoration:underline;" 
        onclick="removebreadcrumb(${item.id})">${item.name}</span>`)
        .join(" > ");

    console.log("Updated Breadcrumb:", breadcrumb1);
}

let selectiontext = "";

document.addEventListener("mouseup", () => {
    let selectedText = window.getSelection().toString();
    if (selectedText) {
        console.log("Selected Text:", selectedText);
        selectiontext = selectedText;
        document.getElementById("t2").value = selectiontext
    }
});

function addnote() {
    let selectiontext = document.getElementById("t2").value;
    let entertext = document.getElementById("t3").value;
    const breadcrumb2 = breadcrumb1.map(item=>item.name).join(">");
    const data = {
        selectiontext: selectiontext,
        id: globalid,  // Ensure globalid is defined elsewhere
        entertext: entertext,
        breadcrumb2: breadcrumb2
    };

    console.log("breadcrumb1", breadcrumb2);
    console.log("globalid",globalid);
    console.log(data);
    fetch("noteadd.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data) // Fix: Do not wrap inside another object
    })
    .then(res => res.text()) // Expect JSON response
    .then(response => {

            alert("Insert done!!!!");
        
    })
    .catch(err => console.error("Fetch error:", err));
}

</script>

</html>