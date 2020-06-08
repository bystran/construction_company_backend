<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h4>{{ $contact_form->getName() }} [{{ $contact_form->getEmail() }}] napísal:</h4>

    <p>{{ $contact_form->getMessage() }}</p>
</body>
</html>