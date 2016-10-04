<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>

<script src="scripts/jquery-1.7.1.min.js"></script>

<textarea id="myTextarea"></textarea>

<script>
$('#myTextarea').keydown(function(e) {
    if(e.which == 13) {
        alert("hi");
    }
});
</script>

</body>
</html>