<!DOCTYPE html>
<html>
<head>
    <title>Parsear texto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <div class="card border-primary mb-3" style="max-width: 20rem;">
        <div class="card-header">Munitorum Field Manual - 16/06/2023</div>
        <div class="card-body text-primary">
<!--            <h4 class="card-title">Indexes</h4>-->
            <p class="card-text">
                <a href="https://www.warhammer-community.com/warhammer-40000-downloads/"
                   target="_blank">Downloads</a> Copy your faction's index data and paste it in the text area then click on Export button.
            </p>
            <form action="../parse/monitorum.php" method="post">
                <textarea name="text" id="areatexto" rows="10" cols="30" required></textarea>
                <br>
                <input class="btn btn-success" type="submit" value="Export">
                <input type="reset" class="btn btn-danger" value="Clear">
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

</body>
</html>