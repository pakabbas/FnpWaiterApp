<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Generator</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
        }
        input {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
        }
        #qrcode {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <h2>QR Code Generator</h2>
    <input type="text" id="qrInput" placeholder="Enter text or URL">
    <button onclick="generateQR()">Generate QR Code</button>
    <div id="qrcode"></div>

    <script>
        function generateQR() {
            let input = document.getElementById("qrInput").value.trim();
            if (input === "") {
                alert("Please enter text or a URL!");
                return;
            }
            document.getElementById("qrcode").innerHTML = ""; // Clear previous QR
            new QRCode(document.getElementById("qrcode"), {
                text: input,
                width: 200,
                height: 200
            });
        }
    </script>

</body>
</html>
