<div class="container">
    <div class="row min-vh-100">
        <div class="col-xs-12 col-sm-8 col-md-6 offset-sm-2 offset-md-3 my-auto">
            <form role="form" method="post">
                <h2>Acesso ao sistema</h2>
                <hr class="colorgraph" />
                <?php if (isset($error['message'])) : ?>
                    <p class="text-danger text-center fs-6"><?= $error['message']; ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <input type="text" name="email" id="email" class="form-control input-lg" placeholder="E-mail" />
                </div>
                <div class="form-group mt-3">
                    <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Senha" />
                </div>
                <div class="form-group mt-3 d-flex justify-content-between">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="remember_me" name="remember_me" value="1">
                        <label class="form-check-label" for="remember_me">Lembrar-me</label>
                    </div>
                    <a href="" class="ms-auto">Esqueceu sua senha?</a>
                </div>
                <hr class="colorgraph" />
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <button href="" class="btn btn-secondary w-100" type="button" disabled>Register</button>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <button type="submit" class="btn btn-success  w-100" type="button">Entrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>