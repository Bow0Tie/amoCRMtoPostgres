<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Main</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container d-flex">
        <div class="row" style="margin: 0; position: absolute; top: 50%; left: 50%; -ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%);">
            <div class="col-sm d-flex justify-content-center align-items-center">
                <form method="POST" action="/">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="height: 50px">Get Info</button>
                </form>
            </div>
            <div class="col-sm d-flex justify-content-center align-items-center">
                <form method="POST" action="/authorization">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="height: 50px">Authorization</button>
                </form>
            </div>
        </div>
      </div>
</body>
</html>