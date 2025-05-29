<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EAN-13 Barcode Scanner</title>
    <script src="https://unpkg.com/quagga/dist/quagga.min.js"></script>
    <style>
        #reader {
            width: 640px;
            height: 480px;
            border: 2px solid #ccc;
            position: relative;
        }
    </style>
</head>
<body>
    <h1>Barcode Scanner with Detection Box</h1>
    <div id="reader"></div>
    <p id="result">Barcode result will appear here</p>

    <script>
        Quagga.init({
            inputStream: {
                type: "LiveStream",
                constraints: {
                    width: 640,
                    height: 480,
                    facingMode: "environment"
                },
                target: document.querySelector('#reader')
            },
            decoder: {
                readers: ["ean_13_reader"]
            },
            locate: true,
            locator: {
                halfSample: true,
                patchSize: "medium"
            },
            frequency: 10
        }, function(err) {
            if (err) {
                console.log(err);
                return;
            }
            Quagga.start();
        });

        Quagga.onProcessed(function(result) {
            const ctx = Quagga.canvas.ctx.overlay;
            const canvas = Quagga.canvas.dom.overlay;

            ctx.clearRect(0, 0, canvas.width, canvas.height); // Clear previous drawings

            if (result) {
                if (result.boxes) {
                    result.boxes.forEach(function(box) {
                        Quagga.ImageDebug.drawPath(box, { x: 0, y: 1 }, ctx, {
                            color: "green",
                            lineWidth: 2
                        });
                    });
                }
                if (result.codeResult) {
                    Quagga.ImageDebug.drawPath(result.line, { x: 'x', y: 'y' }, ctx, {
                        color: 'blue',
                        lineWidth: 3
                    });
                }
            }
        });

        Quagga.onDetected(function(result) {
            const code = result.codeResult.code;
            document.getElementById('result').textContent = `Detected EAN-13 code: ${code}`;
            console.log('Barcode detected: ', code);
        });
    </script>
</body>
</html>
