document.getElementById('logout').addEventListener('click', function(event) {
        event.preventDefault();
        window.location.href = 'ad_login.php'; // Redirect to ad_login.php
    });

    function search() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("customerTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1]; // Index 1 for Name column
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function generateReport() {
        // AJAX request to trigger generation of CSV file
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "list.php?generate_report=1", true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Once the file is generated, initiate download
                var url = URL.createObjectURL(xhr.response);
                var a = document.createElement('a');
                a.href = url;
                a.download = 'customer_data.csv';
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            }
        }
        xhr.responseType = 'blob'; // Set the response type as blob
        xhr.send();
    }