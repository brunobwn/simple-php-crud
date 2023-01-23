<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">myToDoList</a>

        <div class="dropdown d-flex align-items-center">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                aria-expanded="false">
                <?= $auth->getName(); ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <!-- <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li> -->
                <li><a class="dropdown-item" href="./logout.php">Sair</a></li>
            </ul>
            <img class="avatar avatar-48 bg-white rounded-circle text-white p-1 ms-3 shadow-sm"
                src="<?= $auth->getPicture(); ?>" alt="<?= $auth->getName(); ?> profile picture" />
        </div>
    </div>
</nav>