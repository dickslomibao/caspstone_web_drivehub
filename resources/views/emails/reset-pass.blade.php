<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Change</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            /* Background color for the entire email. */
        }

        table {
            width: 100%;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            /* Background color for the content. */
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 28px;
            color: #333;
            margin: 0;
        }

        p {
            font-size: 16px;
            color: #333;
            margin: 20px 0;
        }

        .colored {
            background-color: #545eea;
            color: #fff;
            font-size: 35px;
            font-weight: 700;
            text-align: center;
            border-radius: 10px;
            padding: 15px;
        }

        a {
            color: #545eea;
            /* Link color. */
            text-decoration: none;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td>
                <div class="container">
                    <h2>Reset Password</h2>
                    <p>
                        Click the link below to reset your password. The link is valid only for 15 minutes;
                    </p>
                   <h3>
                    <a href="http://www.drivesolution.com/reset-password/{{ $id }}" style="color: #545eea">Reset Password</a>
                   </h3>
                    <p>
                        If you recently made this change, you can disregard this message. However, if you did not
                        initiate this password update or have any concerns about the security of your account, please
                        contact our support team immediately at <a
                            href="mailto:support@drivehubsolution.com">support@drivehubsolution.com</a>.
                    </p>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
