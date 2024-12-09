<?php
if (isset($_SESSION['orgaos'])) {
    $orgaos = $_SESSION['orgaos'];
    foreach ($orgaos as $orgao) {
        $orgao = serialize($orgao);
        $orgao = unserialize($orgao);
?>
        <!DOCTYPE html>
        <html lang="pt-br">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>

        <body>
            <option value="<?= $orgao['id']; ?>"><?= $orgao['nome']; ?></option>

            <body>

        </html>


<?php
    }
}
?>