<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f4; /* Background color for the entire email. */
        }

        table {
            width: 100%;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff; /* Background color for the content. */
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
            color: #545eea; /* Link color. */
            text-decoration: none;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td>
                <div class="container">
                    <h2>Verify your registration</h2>
                    <p>
                        Thank you for choosing DriveHub! To ensure the security of your account, we have generated a
                        One-Time Password (OTP) for you to complete your authentication process.
                    </p>
                    <div class="colored">
                        {{ $data['otp'] }}
                    </div>
                    <p>
                        Please use this OTP to verify your identity and complete your login or registration process on
                        our platform.
                    </p>
                    <p>
                        Note: This OTP is valid for a single use and will expire after 15 minutes. Please do not share
                        this OTP with anyone, including our support team. We will never ask for your OTP.
                    </p>
                    <hr>
                    <p>
                        If you did not request this OTP or have any concerns about your account's security, please contact
                        our customer support immediately at <a
                            href="mailto:support@drivehubsolution.com">support@drivehubsolution.com</a>.
                    </p>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>