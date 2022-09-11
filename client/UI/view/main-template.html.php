<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$title ?? 'Venture'?></title>
    <script>
        function sendPost(data) {
            const formData  = new FormData();

            for(const name in data) {
                formData.append(name, data[name]);
            }

            fetch('/', {
                method: 'POST',
                body: formData
            }).then(async (response) => {
                document.open();
                document.write(await response.text());
                document.close();
            })
        }
    </script>
</head>
<body>
    <?=implode('<br/>', $errors)?>
    <?=$content ?? ''?>
</body>
</html>
