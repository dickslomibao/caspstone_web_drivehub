<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <button>Back to Home</button>

    <script>
        const btn = document.querySelector("button");
        btn.addEventListener("click", function() {
            window.toaster.postMessage('cancel');
        });
    </script>
</body>

</html>
