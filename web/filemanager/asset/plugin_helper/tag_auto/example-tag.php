<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="fm.tagator.jquery.css">

        <script type="text/javascript" src="http://opensource.faroemedia.com/tagator/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="fm.tagator.jquery.js"></script>
    </head>
    <body>
        <script>
        $(function() {
            $('#inputTagator').tagator({
                autocomplete: ['first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth', 'ninth', 'tenth']
            });
        });
        </script>
        <br><br>
        <?php var_dump($_REQUEST); ?>
        <form action="">
            <div id="wrapper" class="container">
                <input id="inputTagator" class="form-control" name="inputTagator" value="Trần Phi Vũ,Võ Nhân Phong,Trần Phúc Thiện">
            </div>
            <button type="submit">sedn</button>
        </form>
    </body>
</html>
