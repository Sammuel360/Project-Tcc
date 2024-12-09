<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Cadastro de Usuário</title>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Cadastro de Usuário</h1>
        <form action="index.php?c=usuario&a=inserir" method="post">
            <div class="mb-4">
                <label for="nome" class="sr-only">Digite seu nome</label>
                <input type="text" id="nome" name="nome" placeholder="Digite seu nome"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>
            <div class="mb-4">
                <label for="email" class="sr-only">Digite seu email</label>
                <input type="email" id="email" name="email" placeholder="Digite seu email"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>
            <div class="mb-4">
                <label for="telefone" class="sr-only">Digite seu telefone</label>
                <input type="text" id="telefone" name="telefone" placeholder="Digite seu telefone"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>
            <div class="mb-4">
                <label for="endereco" class="sr-only">Digite seu endereço</label>
                <input type="text" id="endereco" name="endereco" placeholder="Digite seu endereço"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>
            <div class="mb-4">
                <label for="cidade" class="sr-only">Digite sua cidade</label>
                <input type="text" id="cidade" name="cidade" placeholder="Digite sua cidade"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>
            <div class="mb-4">
                <label for="estado" class="sr-only">Digite seu estado</label>
                <input type="text" id="estado" name="estado" placeholder="Digite seu estado"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>
            <div class="mb-4">
                <label for="cep" class="sr-only">Digite seu CEP</label>
                <input type="text" id="cep" name="cep" placeholder="Digite seu CEP"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>
            <div class="mb-4">
                <label for="senha" class="sr-only">Digite sua senha</label>
                <input type="password" id="senha" name="senha" placeholder="Digite sua senha"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>
            <button type="submit"
                class="w-full bg-gray-800 text-white py-2 rounded-md hover:bg-gray-700 transition duration-300">Cadastrar</button>

            <div class="mt-4 text-center">
                <a href="index.php">
                    <button type="button" class="btn btn-submit">Voltar</button>
                </a>
        </form>

    </div>
    </div>
</body>

</html>