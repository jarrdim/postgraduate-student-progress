<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
          
            max-width: 600px;
        }


        .card p {
            color: #555;
            margin: 10px 0;
        }

        .signature {
            margin-top: 20px;
            font-style: italic;
            color: #888;
        }
    </style>
    <title>University of Nairobi</title>
</head>
<body>
    <div class="card">
        <div>{{ $mailData['title'] }}</div>

        <p>{{ $mailData['body'] }}</p>

      

        <p class="signature">Regards</p>
    </div>
</body>
</html>
