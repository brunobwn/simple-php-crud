<div class="container">
    <div class="row min-vh-100">
        <div
            class="col-xs-12 col-sm-8 col-md-6 col-lg-4 offset-sm-2 offset-md-3 offset-lg-4 my-auto">
            <form action="?pg=register&action=register" role="form" method="post">
                <h2>Cadastro</h2>
                <hr class="colorgraph" />
                <?php if (isset($error['message'])) : ?>
                <p class="text-danger text-center fs-6"><?= $error['message']; ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <input type="text" name="name" id="name" class="form-control input-lg"
                        placeholder="Nome" required />
                </div>
                <div class="form-group mt-3">
                    <input type="email" name="email" id="email" class="form-control input-lg"
                        placeholder="E-mail" required />
                </div>
                <div class="form-group mt-3">
                    <input type="text" name="picture" id="picture" class="form-control input-lg"
                        placeholder="Avatar URL (não obrigatório)" />
                </div>
                <div class="form-group mt-3">
                    <input type="password" name="password" id="password"
                        class="form-control input-lg" placeholder="Senha" required />
                </div>
                <div class="form-group mt-3">
                    <input type="password" name="passwordConfirm" id="passwordConfirm"
                        class="form-control input-lg" placeholder="Confirme a senha" required />
                </div>
                <hr class="colorgraph" />
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <a href="?pg=login" class="btn btn-secondary w-100" type="button">Voltar ao
                            login</a>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 mt-2 mt-sm-0">
                        <button type="submit" class="btn btn-success  w-100"
                            type="button">Cadastrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>