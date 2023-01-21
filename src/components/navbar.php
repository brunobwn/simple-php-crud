<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">myToDoList</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled">Disabled</a>
                </li>
            </ul>
            <div class="mx-auto mx-md-0 ms-md-auto dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <?= $auth->getName(); ?>


                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="./logout.php">Sair</a></li>
                </ul>
            </div>
            <img class="avatar avatar-48 bg-white rounded-circle text-white p-1 ms-3 shadow-sm"
                src="<?= $auth->getPicture(); ?>" alt="<?= $auth->getName(); ?> profile picture" />
        </div>
    </div>
</nav>