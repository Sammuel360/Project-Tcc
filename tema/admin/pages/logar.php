<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Fiscal Digital Login</title>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <div class="flex justify-center mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="w-16 h-16">
                <circle cx="50" cy="50" r="45" fill="#00b8d4" />
                <path d="M50 20 A30 30 0 0 1 80 50 L50 50 Z" fill="#ffffff" />
                <rect x="75" y="45" width="20" height="10" fill="#00b8d4" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Fiscal Digital</h1>
        <form action="index.php?c=usuario&a=logar" method="post">
            <div class="mb-4">
                <label for="email" class="sr-only">Digite seu Email</label>
                <input type="email" id="email" name="email" placeholder="Digite seu Email"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>

            <div class="mb-4">
                <label for="password" class="sr-only">Digite sua senha</label>
                <input type="password" id="password" name="password" placeholder="Digite sua senha"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>
            <div class="text-right mb-4">
                <a href="#" class="text-sm text-cyan-600 hover:underline">Esqueceu a senha?</a>
            </div>
            <button type="submit"
                class="w-full bg-gray-800 text-white py-2 rounded-md hover:bg-gray-700 transition duration-300">Acessar</button>
        </form>
        <div class="mt-4 text-center">
            <p class="text-gray-600">Ou</p>
        </div>
        <button
            class="w-full mt-4 bg-white border border-gray-300 text-gray-700 py-2 rounded-md hover:bg-gray-50 transition duration-300 flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                    fill="#4285F4" />
                <path
                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                    fill="#34A853" />
                <path
                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                    fill="#FBBC05" />
                <path
                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                    fill="#EA4335" />
            </svg>
            Entrar com Google
        </button>
        <div class="mt-6 text-center">
            <p class="mb-0">
                <a href="index.php?c=usuario&a=cadastrar" class="text-center">Cadastrar novo Usuario</a>
            </p>
        </div>
    </div>
</body>

</html>