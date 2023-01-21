<?php require('./src/components/navbar.php'); ?>
<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>Tarefa</th>
                <th>Concluído</th>
                <th>Criado Em</th>
                <th>Editado Em</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $todos = new Todos();
            $todos = $todos->getAllByUserId($auth->getUserId());
            if ($todos) :
                foreach ($todos as $row) :
            ?>
            <tr>
                <td>
                    <?= $row['description']; ?>
                </td>
                <td>
                    <?= ($row['completed'] == 0) ? 'Não' : 'Sim'; ?>
                </td>
                <td>
                    <?= date_format(date_create($row['createdAt']), 'd/m/Y'); ?>
                </td>
                <td>
                    <?= (!is_null($row['editedAt'])) ? date_format(date_create($row['editedAt']), 'd/m/Y') : '--/--/----'; ?>
                </td>
            </tr>
            <?php
                endforeach;
            else : ?>
            <tr>
                <td colspan="4">Você ainda não cadastrou nenhuma tarefa 😢</td>
            </tr>
            <?php
            endif;
            ?>
        </tbody>
    </table>
</div>