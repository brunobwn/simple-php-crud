<?php
require('./src/components/navbar.php');
$todos = new Todos();
$todoId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_URL);

if ($action == 'done') {
    $toggleTodo = $todos->toggleCompleted($todoId, $auth->getUserId());
    if (!$toggleTodo[0]) {
        $error['message'] = $toggleTodo[1];
    }
}

if ($action == 'edit') {
    $todoEdit = $todos->getTodoById($todoId);
    if (is_null($todoId) || !$todoEdit) {
        $error['message'] = 'Tarefa não encontrada';
    }
}

?>
<hr class="colorgraph mt-0" />
<div class="container">
    <?php if (($action == 'create' || $action == 'edit') && ($error['message'] == '')) : ?>
    <form action="?pg=home&action=save" method="POST" class="row">

        <div class="col-12">
            <h5><?= ($action == 'create') ? 'Novo' : 'Editar'; ?> registro</h5>
        </div>
        <div class="col-12 col-lg-9">
            <div class="form-group">
                <input type="text" name="description" id="description" class="form-control input-lg"
                    placeholder="Descrição da tarefa" value="<?= $todoEdit['description'] ?>" />
                <input type="hidden" name="id" value="<?= $todoId; ?>">
            </div>
        </div>
        <div class="col-12 col-lg-3 mt-2 mt-lg-0 d-flex gap-2 justify-content-end">
            <a href="?pg=home" class="btn btn-secondary">Cancelar</a>
            <button type="submit"
                class="btn btn-success"><?= ($action == 'create') ? 'Cadastrar' : 'Editar'; ?></button>
        </div>
    </form>
    <?php
    endif;
    if (!is_null($error['message'])) :
    ?>
    <p class="text-danger"><?= $error['message']; ?></p>
    <?php endif; ?>
    <div class="row">
        <div class="col">
            <h4 class="d-flex justify-content-between align-items-end">Lista de tarefas <a
                    href="?pg=home&action=create"
                    class="fs-6 link-primary text-decoration-none <?= ($action == 'create' || $action == 'edit') ? 'd-none' : ''; ?>">Cadastrar
                    nova
                    tarefa</a></h4>
            <table class="table table-hover caption-top table-responsive">
                <thead>
                    <tr>
                        <th scope="col" class="w-100">Tarefa</th>
                        <th scope="col"><span class="d-none d-md-inline">Concluído?</span></th>
                        <th scope="col" class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $todosByUser = $todos->getAllByUserId($auth->getUserId());
                    if (count($todosByUser) > 0) {
                        foreach ($todosByUser as $row) :
                    ?>
                    <tr data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Criado em: <?= date_format(date_create($row['createdAt']), 'd/m/Y'); ?> | Última edição: <?= (!is_null($row['editedAt'])) ? date_format(date_create($row['editedAt']), 'd/m/Y') : '--/--/----'; ?>">
                        <td
                            class="table-cell-fit <?= ($row['completed'] == 1) ? 'text-decoration-line-through' : ''; ?>">
                            <?= $row['description']; ?>
                        </td>
                        <td class="text-center">
                            <a href="?pg=home&action=done&id=<?= $row['todoId']; ?>"
                                class="btn btn-outline-success"><i
                                    class="fa  <?= ($row['completed'] == 1) ? 'fa-check-circle-o' : 'fa-times-circle-o'; ?> d-md-none"
                                    aria-hidden="true"></i><span
                                    class="d-none d-md-inline"><?= ($row['completed'] == 1) ? 'Desfazer' : 'Concluir'; ?></span></a>
                        </td>
                        <td class="d-flex flex-nowrap gap-2">
                            <a href="?pg=home&action=delete&id=<?= $row['todoId']; ?>"
                                class="btn btn-danger"><i class="fa fa-trash d-md-none"
                                    aria-hidden="true"></i><span
                                    class="d-none d-md-inline">Apagar</span></a>
                            <a href="?pg=home&action=edit&id=<?= $row['todoId']; ?>"
                                class="btn btn-primary"><i class="fa fa-pencil-square-o d-md-none"
                                    aria-hidden="true"></i><span
                                    class="d-none d-md-inline">Editar</span></a>
                        </td>
                    </tr>
                    <?php
                        endforeach;
                    } else { ?>
                    <tr>
                        <td colspan="4" class="fw-light text-center">Você não tem tarefas 😢 <br />
                            Que
                            tal
                            cadastrar a sua primeira?
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>