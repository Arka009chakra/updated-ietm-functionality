<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Data</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
<h1>Database Records</h1>
<table id="data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>ParentId</th>
        </tr>
    </thead>
    <tbody>
        <!-- Data will be inserted here -->
    </tbody>
</table>
<script>
// Use JavaScript fetch() to retrieve data from PHP
fetch('database.php')
    .then(response => response.json())  // Parse the JSON response
    .then(data => {
        // Get the table body element
        const tableBody = document.querySelector('#data-table tbody');
        
        // Loop through the data and create a table row for each item
        data.forEach(row => {
            const tableRow = document.createElement('tr');
            
            // Create table cells for each column and append them to the row
            const idCell = document.createElement('td');
            idCell.textContent = row.id;  // Assuming 'id' is a column in the database
            tableRow.appendChild(idCell);
            const nameCell = document.createElement('td');
            nameCell.textContent = row.name;  // Assuming 'name' is a column in the database
            tableRow.appendChild(nameCell);
            const emailCell = document.createElement('td');
            emailCell.textContent = row.parentid;  // Assuming 'email' is a column in the database
            tableRow.appendChild(emailCell);
            // Append the row to the table body
            tableBody.appendChild(tableRow);
        });
    })
    .catch(error => {
        console.error('Error fetching data:', error);
    });
</script>
</body>
</html>