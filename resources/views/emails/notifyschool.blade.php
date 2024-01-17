<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accreditation Reminder</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            /* Background color for the entire email. */
            font-family: 'Arial', sans-serif;
        }

        header {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            /* Background color for the content. */
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 24px;
            color: #333;
            margin: 0;
        }

        p {
            font-size: 16px;
            color: #333;
            margin: 15px 0;
        }

        .colored {
            color: #333;
            font-size: 18px;
            font-weight: 700;
            text-align: center;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }

        a {
            color: #545eea;
            /* Link color. */
            text-decoration: none;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #545eea;
            color: #fff;
            border-radius: 0 0 10px 10px;
        }
    </style>
</head>

<body>
    <header>
        <center> <img src="https://drivehubsolution.com/logo/logo-text.png" alt="Driving School Logo" style="height:100px">
            <h1>Accreditation Reminder</h1>
        </center>
    </header>

    <div class="container">

        <div class="colored">
            {{ $data['content'] }}
        </div>
        <p>For any questions or concerns, please contact us at <a
                href="mailto:support@drivehubsolution.com">support@drivehubsolution.com</a>.</p>
    </div>

    <footer>
        Thank you for choosing DriveHub Solution for your needs.
    </footer>
</body>

</html>
