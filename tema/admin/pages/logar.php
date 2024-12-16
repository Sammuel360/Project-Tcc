<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Fiscal Digital Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background-color: #9A616D;">

    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="https://media.istockphoto.com/photos/close-up-photo-of-a-beautiful-young-woman-using-a-mobile-phone-in-a-picture-id1288157145?k=20&m=1288157145&s=612x612&w=0&h=fv_LEt20U4t3h-ZQEBhdk6Yuxm3weCHWK2iwCsPG_ZY="
                                    alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form action="index.php?c=usuario&a=logar" method="post">
                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                                            <span class="h1 fw-bold mb-0">Fiscal Digital</span>
                                        </div>

                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Acesse sua conta
                                        </h5>

                                        <div class="form-outline mb-4">
                                            <input type="email" id="email" name="email" placeholder="Digite seu Email"
                                                class="form-control form-control-lg" required />
                                            <label class="form-label" for="email">Email</label>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input type="password" id="password" name="password"
                                                placeholder="Digite sua senha" class="form-control form-control-lg"
                                                required />
                                            <label class="form-label" for="password">Senha</label>
                                        </div>

                                        <div class="pt-1 mb-4">
                                            <button class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <a href="#" class="small text-muted">Esqueceu a senha?</a>
                                            <p class="mb-0"><a href="index.php?c=usuario&a=cadastrar"
                                                    class="small text-muted">Cadastrar novo Usuário</a></p>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>

</html>