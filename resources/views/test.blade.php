<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>API Client</title>
</head>

<body>
    <h1>Fiber API Client</h1>
    <button id="callApi">Call API</button>
    <p id="result"></p>

    <script>
        document.getElementById("callApi").addEventListener("click", () => {
            fetch("http://localhost:8080/api")
                .then(res => res.text())
                .then(data => {
                    document.getElementById("result").innerText = data;
                })
                .catch(err => {
                    document.getElementById("result").innerText = "Error: " + err;
                });
        });
    </script>
</body>

</html>
